<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use App\Models\Attachment;
use App\Models\Admin\Month;
use Illuminate\Http\Request;
use App\Traits\VacationTrait;
use App\Models\VacationDetail;
use App\Models\Tables\VacationType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Tables\WorkflowStatus;
use App\Notifications\VacationAction;
use App\Mail\VacationAction as MailVacationAction;

class VacationController extends Controller
{

  use VacationTrait;

  public function index(Request $request)
  {

    $vacations = Vacation::where('start_date', '<=', Carbon::now()->format('Y-m-d'))
      ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
      ->count();

    return view('admin.vacations.index', [
      'pending' => Vacation::where('status_id', '0')->count(),
      'vacations' => $vacations,
      'balance' => User::where('active', '1')->where('vacation_class', '>', '0')->count(),
      'upComingVacations' => Vacation::where('start_date', '>=', Carbon::now()->format('Y-m-d'))->count()
    ]);
  }

  public function upcoming()
  {
    return view('admin.vacations.upcoming', [
      'vacations' => Vacation::where('start_date', '>=', Carbon::now()->format('Y-m-d'))->get(),
      'types' => VacationType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }

  public function pending()
  {
    $vacations = Vacation::with('user', 'detail')
      ->where('status_id', '0')
      ->orderByDesc('id')
      ->get();
    // return count($vacations);
    return view('admin.vacations.pending', [
      'vacations' => $vacations,
      'types' => VacationType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }

  public function search(Request $request)
  {
    return view('admin.vacations.search', [
      'vacations' => $this->vacations($request),
      'users' => User::where('active', '1')->get(),
      'types' => VacationType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }

  private function vacations(Request $request)
  {
    $vacations = Vacation::with('user', 'detail')
      ->where(function ($q) use($request){
        $q->when($request->user_id != null, function($q) use ($request){
            $q->where('user_id', $request->user_id);
          })
        ->when($request->type != null, function($q) use ($request){
            $q->where('vacation_type', $request->type);
          })
        ->when($request->start != null, function($q) use($request){
            $q->whereDate('end_date', '>=', Carbon::parse($request->start));
          },function ($q){
            $q->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d'));
          })
        ->when($request->end != null, function($q) use($request){
            $q->whereDate('start_date', '<=', Carbon::parse($request->end));
          },function ($q){
            $q->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d'));
          })
        ->when($request->status != null, function($q) use ($request){
            $q->where('status_id', $request->status);
          });
        })
      ->orderByDesc('start_date')
      ->get();
    return $vacations;
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
    if($this->checkIfSalaryProcessed($vacation)){
      return redirect()->back()->with('processed', __('head/vacations.processed'));
    }
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

  public function destroy(string $id)
  {
    $vacation = Vacation::find($id);
    $detail = VacationDetail::where('vacation_id', $vacation->id)->first();
    $attachment = Attachment::where('attachmentable_type', 'App\Models\Vacation')->where('attachmentable_id', $vacation->id)->first();
    if($detail){
      $detail->delete();
    }
    if($attachment){
      $attachment->delete();
    }
    $vacation->delete();
    return redirect()->back()->with('success', __('admin/vacations.vacationDeleted'));
  }

  public function annualBalance()
  {
    $users = User::where('active', '1')->where('vacation_class', '>', '0')->get();
    foreach ($users as $user) {
      $user->balance = $this->balance(date('Y-m-d'), $user->joining_date, $user->vacation_class, $user->id);
    }
    return view('admin.vacations.balance', [
      'users' => $users,
    ]);
  }

  private function checkIfSalaryProcessed(Vacation $vacation)
  {
    return Month::where('start_date', '<=', $vacation->start_date)->orderByDesc('start_date')->first()->status;
  }
}
