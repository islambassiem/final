<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\VacationDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\VacationType;
use App\Http\Requests\VacationRequest;
use App\Notifications\ApplyVacation;

class VacationController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $vacations = Vacation::with('detail')->where('user_id', auth()->user()->id)
      ->where('start_date', '!=', auth()->user()->joining_date)
      ->orderByDesc('id')
      ->orderByDesc('start_date')
      ->get();
    return view('vacations.index', [
      'balance' => $this->balance(),
      'vacations' => $vacations,
      'types' => VacationType::orderBy('ordering')->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('vacations.create', [
      'types' => VacationType::orderBy('ordering')->get(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(VacationRequest $request)
  {
    $validated = $request->validated();
    $validated['user_id'] = auth()->user()->id;
    $validated['status_id'] = 0;
    if($request->vacation_type == 1){
      $this->annual($request, $validated);
    }else{
      $this->vacation($request, $validated);
    }
    return redirect()->route('vacations.index')->with('success', 'You have applied for a vacation successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return view('vacations.show', [
      'vacation' => Vacation::with(['detail', 'attachment'])->find($id),
      'types' => VacationType::orderBy('ordering')->get(),
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    return view('vacations.edit',[
      'vacation' => Vacation::with(['detail', 'attachment'])->find($id),
      'types' => VacationType::orderBy('ordering')->get(),
    ]);
  }

  public function attachAttachment(Request $request, string $id)
  {
    $vacation = Vacation::find($id);
    $request->validate([
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ], [], [
      'attachment.mimetypes' => __('The file is invalid'),
      'attachment.max' => __('The maximum file upload is 2MBs'),
    ]);
    if($request->hasFile('attachment'))
    {
      $filepath = $request->file('attachment')->store(auth()->user()->id . '/vacations', 'public');
      $vacation->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '8',
        'link' => $filepath,
        'title' => 'vacation'
      ]);
      return redirect()->back()->with('success', 'You have uploaded a file succcessfully');
    }
    return redirect()->back()->with('error', 'No files were uploaded');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $vacation = Vacation::find($id);
    if($vacation->status_id > 0){
      return redirect()->route('vacations.index')->with('error', 'An action has been taken on your vacation; you cannot delete it');
    }
    $detail = VacationDetail::where('vacation_id', $vacation->id)->first();
    $attachment = Attachment::where('attachmentable_type', 'App\Models\Vacation')->where('attachmentable_id', $vacation->id)->first();
    if($detail){
      $detail->delete();
    }
    if($attachment){
      $attachment->delete();
    }
    $vacation->delete();
    return redirect()->route('vacations.index')->with('success', 'You have deleted your vacation successfully');
  }

  private function annual(VacationRequest $request, array $validated) 
  {
    if($request->vacation_type == 1)
    {
      $head = User::find(auth()->user()->head);
      $days = $this->days($request->start_date, $request->end_date);
      $balance = $this->balance($request->end_date);
      if($days > $balance){

        // divide the vacation into paid and unpaid
        $end_date = Carbon::parse($request->start_date);
        $paidStartDate = $request->start_date;
        $paidEndDate = $end_date->addDays($balance - 1);
        $unpaidStartDate = (Carbon::parse($paidEndDate)->addDay());
        $unpaidEndDate = $request->end_date;

        // process the paid portion
        $this->createVacation($paidStartDate, $paidEndDate, '1');
        $latest = Vacation::latest('id')->first();
        $this->detail($validated, $latest->id);
        $this->attach($request, $latest);
        $head->notify(new ApplyVacation($latest));

        //process the unpaid portion
        $this->createVacation($unpaidStartDate, $unpaidEndDate, '4');
        $latest = Vacation::latest('id')->first();
        $this->detail($validated, $latest->id);
        $this->attach($request, $latest);
        $head->notify(new ApplyVacation($latest));
      }elseif($days <= $balance){
        Vacation::create($validated);
        $latest = Vacation::latest('id')->first();
        $this->detail($validated, $latest->id);
        $this->attach($request, $latest);
        $head->notify(new ApplyVacation($latest));
      }
    }
  }

  private function vacation(VacationRequest $request, array $validated)
  {
    if($request->vacation_type != 1)
    {
      $head = User::find(auth()->user()->head);
      Vacation::create($validated);
      $latest = Vacation::latest('id')->first();
      $this->detail($validated, $latest->id);
      $this->attach($request, $latest);
      $head->notify(new ApplyVacation($latest));
    }
  }

  private function createVacation($start_date, $end_date, $vacation_type)
  {
    Vacation::create([
      'user_id' => auth()->user()->id,
      'vacation_type' => $vacation_type,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'status_id' => '0'
    ]);
  }

  private function detail(array $validated, string $latest_id)
  {
    VacationDetail::create([
      'vacation_id' => $latest_id,
      'employee_notes' => $validated['employee_notes'],
      'employee_time' => Carbon::now(),
      'head_status' => '0',
      'hr_status' => '0'
    ]);
  }

  private function attach(VacationRequest $request, Vacation $latest)
  {
    if($request->hasFile('attachment'))
    {
      $filepath = $request->file('attachment')->store(auth()->user()->id . '/vacations', 'public');
      $latest->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '8',
        'link' => $filepath,
        'title' => 'vacation'
      ]);
    }
  }

  private function balance($endDate = null)
  {
    return round($this->accrued($endDate) - $this->availed(), 0);
  }

  private function accrued($endDate = null)
  {
    $endDate ?? date('Y-m-d');
    $start = Carbon::parse(auth()->user()->joining_date);
    $end = Carbon::parse($endDate);
    $days = $this->days($start, $end);
    $accrued = 0;
    if(auth()->user()->vacation_class == 30){
      $accrued =  $days * 30 / 365 ;
    }
    if(auth()->user()->vacation_class == 21){
      $joiningDate = Carbon::parse(auth()->user()->joining_date);
      $tillDate = Carbon::parse((Carbon::parse($endDate))->addDay());
      $diff = ($tillDate->diffInDays($joiningDate)) / 365;
      if($diff >= 5){
        $accrued = (5 * 21) + (($diff - 5) * 30);
      }
      if($diff < 5){
        $accrued = $days * 21 / 365;
      }
    }
    return $accrued;
  }

  private function availed()
  {
    $availed =  DB::select("SELECT
      SUM(DATEDIFF(
        vacations.end_date,
        vacations.start_date
      ) +1) AS days
    FROM vacations WHERE vacation_type = 1 AND `status_id` = 1 AND user_id = ? AND deleted_at IS NULL LIMIT 1;", [auth()->user()->id]);
    return $availed[0]->days;
  }

  private function days($start_date, $end_date)
  {
    $start = Carbon::parse($start_date);
    $end = Carbon::parse($end_date);
    return $end->diffInDays($start) + 1;
  }

  public function getAttachment($id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
      ->where('attachmentable_type', 'App\Models\Vacation')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return response()->download("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment'));
  }
}
