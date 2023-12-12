<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\VacationType;
use App\Http\Requests\VacationRequest;
use App\Models\Attachment;
use App\Models\VacationDetail;
use DateTime;

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
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->all();
    $validated['user_id'] = auth()->user()->id;
    $validated['status_id'] = 0;
    if($request->vacation_type == 1){
      $this->annual($request, $validated);
    }else{
      $this->vacation($request, $validated);
    }
    return redirect()->back()->with('success', 'You have applied for a vacation successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return view('vacations.show', [
      'vacation' => Vacation::with(['detail', 'attachment'])->find($id)
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function updateVacation(Request $request, string $id)
  {
    return 'update function';
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $vacation = Vacation::find($id);
    if($vacation->status_id > 0){
      return redirect()->back()->with('error', 'An action has been taken on your vacation; you cannot delete it');
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
    return redirect()->back()->with('success', 'You have deleted your vacation successfully');
  }

  private function annual(VacationRequest $request, array $validated)
  {
    if($request->vacation_type == 1)
    {
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

        //process the unpaid portion
        $this->createVacation($unpaidStartDate, $unpaidEndDate, '4');
        $latest = Vacation::latest('id')->first();
        $this->detail($validated, $latest->id);
        $this->attach($request, $latest);

      }elseif($days <= $balance){
        Vacation::create($validated);
        $latest = Vacation::latest('id')->first();
        $this->detail($validated, $latest->id);
        $this->attach($request, $latest);
      }
    }
  }

  private function vacation(VacationRequest $request, array $validated)
  {
    if($request->vacation_type != 1)
    {
      Vacation::create($validated);
      $latest = Vacation::latest('id')->first();
      $this->detail($validated, $latest->id);
      $this->attach($request, $latest);
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
    if($request->has('attachment'))
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
}
