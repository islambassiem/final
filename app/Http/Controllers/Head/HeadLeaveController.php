<?php

namespace App\Http\Controllers\Head;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\LeaveDetail;
use Illuminate\Http\Request;
use App\Models\Tables\LeaveType;
use App\Notifications\LeaveAction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Tables\WorkflowStatus;
use App\Mail\LeaveAction as MailLeaveAction;

class HeadLeaveController extends Controller
{
  public function __construct()
  {
    return $this->middleware(['auth', 'head']);
  }

  public function index(Request $request)
  {
    $sub = User::where('active', '1')->where('head', auth()->user()->id)->pluck('id')->toArray();
    $leaves = Leave::with('user', 'detail')
        ->join('leave_details', 'leave_details.leave_id', '=', 'leaves.id')
        ->where(function($q) use($request){
          $q->where('head_status', '0')
          ->orWhere(function($q) use($request){
            $q->when($request->start != null, function($q) use ($request) {
              return $q->whereDate('date', '>=', Carbon::parse($request->start));
            }, function($q){
              return $q->whereDate('date', '>=', Carbon::now());
            })
            ->when($request->end != null, function ($q) use ($request){
              return $q->whereDate('date', '<=', Carbon::parse($request->end));
            }, function($q){
              $q->whereDate('date', '>=', Carbon::now());
            })
            ->when($request->type != null, function($q) use ($request){
              return $q->where('leave_type', $request->type);
            })
            ->when($request->status != null, function($q) use ($request){
              $q->where('head_status', $request->status);
            });
          });
        })
      ->orderByDesc('leaves.id')
      ->whereIn('user_id', $sub)
      ->orderByDesc('leaves.id')
      ->get(['leaves.id', 'user_id', 'leave_type', 'date', 'from', 'to', 'status_id', 'leaves.deleted_at', 'leaves.created_at', 'leaves.updated_at', 'head_status']);

    return view('head.leaves.index', [
      'permissions' => $leaves,
      'types' => LeaveType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }

  public function show(string $id)
  {
    return view('head.leaves.show', [
      'permission' => Leave::with(['detail', 'attachment', 'user'])->find($id)
    ]);
  }

  public function update(string $id, Request $request)
  {
    $leave = Leave::find($id);
    $user = User::find($leave->user_id);
    $detail = LeaveDetail::where('leave_id', $leave->id)->first();
    if($detail->head_time == null){
      $detail->update([
        'head_status' => $request->action,
        'head_notes' => $request->head_notes,
        'head_time' => Carbon::now()
      ]);
      $user->notify(new LeaveAction($leave));
      Mail::queue(new MailLeaveAction($leave));
      return redirect()->back()->with('success', __('You have taken an action successfully'));
    }
    return redirect()->route('sLeave.index')->with('error', __('You have taken an action already'));
  }
}
