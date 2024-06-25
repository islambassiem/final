<?php

namespace App\Http\Controllers\Head;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use App\Models\Admin\Month;
use Illuminate\Http\Request;
use App\Models\VacationDetail;
use App\Models\Tables\VacationType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Tables\WorkflowStatus;
use App\Notifications\VacationAction;
use App\Mail\VacationAction as MailVacationAction;

class HeadVacationController extends Controller
{
  public function __construct()
  {
    return $this->middleware(['auth', 'head']);
  }

  public function index(Request $request)
  {
    $sub = User::where('active', '1')->where('head', auth()->user()->id)->pluck('id')->toArray();
    $vacations = Vacation::with('user', 'detail')
      ->join('vacation_details', 'vacation_details.vacation_id', '=', 'vacations.id')
      ->where(function($q) use($request){
        $q->where('head_status', '0')
        ->orWhere(function ($q) use($request){
          $q->when($request->start != null, function($q) use($request){
            $q->whereDate('start_date', '>=', Carbon::parse($request->start));
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
            $q->where('head_status', $request->status);
          });
        });
      })
      ->whereIn('user_id', $sub)
      ->orderByDesc('vacations.id')
      ->get(['vacations.id', 'user_id', 'vacation_type', 'start_date', 'end_date', 'status_id', 'vacations.deleted_at', 'vacations.created_at', 'vacations.updated_at', 'head_status']);
    return view('head.vacations.index', [
      'vacations' => $vacations,
      'types' => VacationType::all(),
      'status' => WorkflowStatus::All()
    ]);
  }

  public function show(string $id)
  {
    return view('head.vacations.show', [
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
    if($detail->head_time == null){
      $detail->update([
        'head_status' => $request->action ?? 0,
        'head_notes' => $request->head_notes,
        'head_time' => Carbon::now()
      ]);
      $user->notify(new VacationAction($vacation));
      Mail::queue(new MailVacationAction($vacation));
      return redirect()->back()->with('success', __('You have taken an action successfully'));
    }
    return redirect()->route('lLeave.index')->with('error', __('You have taken an action already'));
  }

  private function checkIfSalaryProcessed(Vacation $vacation)
  {
		$latestMonthStartDate = Month::orderByDesc('start_date')->first()->start_date;
		return $vacation->start_date <= $latestMonthStartDate;
  }

}
