<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Attachment;
use App\Models\LeaveDetail;
use Illuminate\Http\Request;
use App\Models\Tables\LeaveType;
use App\Notifications\ApplyLeave;
use App\Http\Requests\LeaveRequest;
use App\Mail\LeaveApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class LeaveController extends Controller
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
    return view('leaves.index', [
      'leaves' => Leave::with(['detail', 'attachment'])->where('user_id', auth()->user()->id)->orderByDesc('id')->get(),
      'types' => LeaveType::all(),
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
  public function store(LeaveRequest $request)
  {
    $validated = $request->validated();
    $validated['user_id'] = auth()->user()->id;
    $validated['status_id'] = 0;
    $start = Carbon::parse($validated['from']);
    $end = Carbon::parse($validated['to']);
    $diff = $end->floatDiffInHours($start);
    if($diff > 4 && $validated['leave_type'] != 1){
      return redirect()->back()->with('error', 'The permission cannot be more than 4 hours');
    }
    Leave::create($validated);
    $latest_leave = Leave::with('user')->latest('id')->first();
    $head = User::find(auth()->user()->head);
    $this->leaveDetial($request, $latest_leave->id);
    $this->attach($request, $latest_leave);
    Notification::send($head, new ApplyLeave($latest_leave));
    Mail::send(new LeaveApplication($latest_leave));
    return redirect()->back()->with('success', 'You have applied for a permission successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    return view('leaves.show', [
      'leave' => Leave::with(['detail', 'attachment'])->find($id)
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
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $leave = Leave::find($id);
    if($leave->status_id > 0){
      return redirect()->back()->with('error', 'An action has been taken on your permission; you cannot delete it');
    }
    $detail = LeaveDetail::where('leave_id', $leave->id)->first();
    $attachment = Attachment::where('attachmentable_type', 'App\Models\leave')->where('attachmentable_id', $leave->id)->first();
    if($detail){
      $detail->delete();
    }
    if($attachment){
      $attachment->delete();
    }
    $leave->delete();
    return redirect()->back()->with('success', 'You have deleted your permission successfully');
  }

  private function leaveDetial(LeaveRequest $request, string $id)
  {
    LeaveDetail::create([
      'leave_id' => $id,
      'employee_notes' => $request->employee_notes,
      'employee_time' => Carbon::now(),
      'head_status' => '0',
      'hr_status' => '0'
    ]);
  }

  private function attach(LeaveRequest $request, Leave $latest)
  {
    if($request->has('attachment'))
    {
      $filepath = $request->file('attachment')->store(auth()->user()->id . '/leaves', 'public');
      $latest->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '9',
        'link' => $filepath,
        'title' => 'leave'
      ]);
    }
  }

  public function getAttachment($id)
  {
    $link = Attachment::where('attachmentable_type', 'App\Models\Leave')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return response()->download("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment'));
  }
}
