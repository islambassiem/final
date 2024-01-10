<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\LeaveDetail;
use Illuminate\Http\Request;
use App\Models\Tables\LeaveType;
use App\Notifications\LeaveAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Tables\WorkflowStatus;
use App\Mail\LeaveAction as MailLeaveAction;

class LeaveController extends Controller
{
  public function index(Request $request){
    $sub = User::where('active', '1')->pluck('id')->toArray();
    $q = Leave::with('user', 'detail')
      ->when($request->start != null, function($q) use ($request) {
        return $q->whereDate('date', '>=', Carbon::parse($request->start));
      }, function($q){
        return $q->whereDate('date', '>=', Carbon::now());
      })
      ->when($request->end != null, function ($q) use ($request){
        return $q->whereDate('date', '<=', Carbon::parse($request->end));
      })
      ->when($request->type != null, function($q) use ($request){
        $q->where('leave_type', $request->type);
      })
      ->when($request->status != null, function($q) use ($request){
        $q->where('status_id', $request->status);
      })
      ->orWhere('status_id', '0')
      ->orderByDesc('id')
      ->get()
      ->whereIn('user_id', $sub);


    return view('admin.leaves.index', [
      'permissions' => $q,
      'types' => LeaveType::all(),
      'status' => WorkflowStatus::all()
    ]);
  }

  public function show(string $id)
  {
    return view('admin.leaves.show', [
      'permission' => Leave::with(['detail', 'attachment', 'user'])->find($id)
    ]);
  }

  public function update(string $id, Request $request)
  {
    $leave = Leave::find($id);
    $user = User::find($leave->user_id);
    $detail = LeaveDetail::where('leave_id', $id)->first();

    $leave->update([
      'status_id' => $request->action ?? $leave->status_id
    ]);

    $detail->update([
      'hr_status' => $request->action ?? $leave->status_id,
      'hr_notes' => $request->hr_notes,
      'hr_time' => Carbon::now(),
      'action_by' => auth()->user()->id
    ]);
    $user->notify(new LeaveAction($leave));
    Mail::send(new MailLeaveAction($leave));
    return redirect()->back()->with('success', __('You have taken an action successfully'));
  }
}
