<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Models\VacationDetail;
use App\Models\Tables\VacationType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Tables\WorkflowStatus;
use App\Notifications\VacationAction;
use App\Mail\VacationAction as MailVacationAction;

class VacationController extends Controller
{
  public function index(Request $request)
  {
    $sub = User::where('active', '1')->pluck('id')->toArray();
    $vacations = Vacation::with('user', 'detail')
      ->when($request->start != null, function($q) use($request){
        $q->whereDate('end_date', '>=', Carbon::parse($request->start));
      }, function($q){
        $q->whereDate('start_date', '>=', Carbon::now());
      })
      ->when($request->end != null, function($q) use($request){
        $q->whereDate('start_date', '<=', Carbon::parse($request->end));
      }, function($q){
        $q->whereDate('end_date', '>=', Carbon::now());
      })
      ->when($request->type != null, function($q) use ($request){
        $q->where('vacation_type', $request->type);
      })
      ->when($request->status != null, function($q) use ($request){
        $q->where('status_id', $request->status);
      })
      ->orWhere('status_id', '0')
      ->orderByDesc('id')
      ->get()
      ->whereIn('user_id', $sub);
    return view('admin.vacations.index', [
      'vacations' => $vacations,
      'types' => VacationType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }

  public function show(string $id)
  {
    return view('admin.vacations.show', [
      'vacation' => Vacation::with(['detail', 'attachment', 'user'])->find($id),
      'types' => VacationType::all()
    ]);
  }

  public function update(string $id, Request $request)
  {
    $vacation = Vacation::find($id);
    $user = User::find($vacation->user_id);
    $detail = VacationDetail::where('vacation_id', $vacation->id)->first();

    $vacation->update([
      'status_id' => $request->action ?? $vacation->status_id
    ]);

    $detail->update([
      'hr_status' => $request->action ?? $vacation->status_id,
      'hr_notes' => $request->hr_notes,
      'hr_time' => Carbon::now(),
      'action_by' => auth()->user()->id
    ]);

    $user->notify(new VacationAction($vacation));
    Mail::queue(new MailVacationAction($vacation));
    return redirect()->back()->with('success', __('You have taken an action successfully'));
  }
}
