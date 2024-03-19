<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use App\Models\Admin\Month;
use Illuminate\Http\Request;
use App\Models\Admin\WorkingDays;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\NonWorkingDays;
use App\Http\Controllers\Admin\Salaries\GOSI;
use App\Http\Controllers\Admin\Salaries\Ticket;
use App\Http\Controllers\Admin\Salaries\Transportation;

class SalariesController extends Controller
{

  use GOSI;
  use Ticket;
  use Transportation;


  private $end_date;
  public function __construct()
  {
    $end_date_last_month = Month::orderby('year', 'desc')
      ->orderby('month', 'desc')->first('end_date')->end_date;
    $this->end_date = new DateTime($end_date_last_month);
    $this->end_date->modify('+1 day');
    return $this->middleware(['auth', 'admin']);
  }

  public function index()
  {
    return view('admin.salaries.months',[
      'months' => Month::orderBy('created_at', 'desc')->get(),
      'start_date' => $this->end_date->format('Y-m-d'),
    ]);
  }

  public function dashboard($month_id)
  {
    $month    = Month::find($month_id);
    return view('admin.salaries.dashboard', [
      'month_id' => $month_id,
      'month' => $month->month,
      'status' => $month->status
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'from' => 'required|date_equals:'.$this->end_date->format('Y-m-d'),
      'to' => 'required|date|after:'.$this->end_date->format('Y-m-d'),
      'month' => 'required',
      'year' => 'required'
    ], [
      'from' => __('admin/salaries.startReq'),
      'to' => __('admin/salaries.endDateReq'),
      'month' => __('admin/salaries.monthReq'),
      'year' => __('admin/salaries.yearReq')
    ]);
    Month::create([
      'start_date' => $validated['from'],
      'end_date' => $validated['to'],
      'month' => $validated['month'],
      'year' => $validated['year'],
      'user_id' => auth()->user()->id
    ]);
    return redirect()->back()->with('success', __('admin/salaries.success'));
  }

  public function process(Request $request)
  {
    $request->validate([
      'fingerprint'     => 'required',
      'payablesConf'    => 'required',
      'deductablesConf' => 'required'
    ], [
      'fingerprint'     => __('admin/salaries.fpReq'),
      'payablesConf'    => __('admin/salaries.payReq'),
      'deductablesConf' => __('admin/salaries.dedReq'),
    ]);
    $month    = Month::find($request->month);
    $end      = Carbon::parse($month->end_date)->lastOfMonth();

    if($month->status){
      return redirect()->back()->with('error', __('admin/salaries.monthProcessed'));
    }
    $this->pending($month->start_date, $month->end_date);
    $this->deduct($end, $month->id);
    $this->gosi($end, $month->id);
    $this->tickets($end, $month->id);
    $this->approved($month->id, $month->start_date, $month->end_date);
    $this->notApproved($month->id, $month->start_date, $month->end_date);
    $this->workingDays($month->id);
    $month->status = 1;
    $month->save();

    return redirect()->back()->with('salarySuccess', __('admin/salaries.salarySuccess'));
  }


  public function working($month_id)
  {
    $working = WorkingDays::with('user')
      ->where('month_id', $month_id)
      ->get();
    return view('admin.salaries.workingDays', [
      'month_id' => $month_id,
      'days' => $working
    ]);
  }

  public function nonWorking($month_id)
  {
    $nonworking = NonWorkingDays::with(['user', 'vacationType'])
    ->where('month_id', $month_id)
    ->get();
    return view('admin.salaries.nonWorkingDays', [
      'month_id' => $month_id,
      'days' => $nonworking
    ]);
  }

  private function approved($month_id, $start, $end)
  {
    $vacations = Vacation::where('start_date' , '<=', $end)
      ->where('end_date', '>=', $start)
      ->where('status_id', '1')
      ->get()
      ->map(function(Vacation $vacation) use($start, $end){
        $vacation->start_date = $vacation->start_date <= $start ? $vacation->start_date = $start : $vacation->start_date;
        $vacation->end_date = $vacation->end_date >= $end ? $vacation->end_date = $end : $vacation->end_date;
        return $vacation;
      })
      ->groupBy(['user_id', 'vacation_type'])
      ->map(function($type){
        return $type->map(function($item){
          $total = $item->sum('days');
					return $total >= 30 ? 30 :  $total;
        });
      });
    foreach ($vacations as $user => $vacation) {
      foreach ($vacation as $key => $value) {
        NonWorkingDays::create([
          'user_id' => $user,
          'month_id' => $month_id,
          'type' => $key,
          'days' => $value
        ]);
      }
    }
  }

  private function notApproved($month_id, $start, $end)
  {
    $vacations = Vacation::where('start_date' , '<=', $end)
      ->where('end_date', '>=', $start)
      ->where('status_id', '!=' ,'1')
      ->orderBy('user_id')
      ->get()
      ->map(function(Vacation $vacation) use($start, $end){
        $vacation->start_date = $vacation->start_date <= $start ? $vacation->start_date = $start : $vacation->start_date;
        $vacation->end_date = $vacation->end_date >= $end ? $vacation->end_date = $end : $vacation->end_date;
        return $vacation;
      })
      ->groupBy(['user_id', 'vacation_type'])
      ->map(function($type){
        return $type->map(function($item){
          $total = $item->sum('days');
					return $total >= 30 ? 30 :  $total;
        });
      });
    foreach ($vacations as $user => $vacation) {
      foreach ($vacation as $key => $value) {
        $key = $key != 3 ? 4 : 3;
        NonWorkingDays::create([
          'user_id' => $user,
          'month_id' => $month_id,
          'type' => $key,
          'days' => $value
        ]);
      }
    }
  }


  private function pending($start, $end)
  {
    $vacations = Vacation::where('start_date' , '<=', $end)
      ->where('end_date', '>=', $start)
      ->where('status_id', '=' ,'0')
      ->orderBy('user_id')
      ->get();
    foreach ($vacations as $vacation) {
      $vacation->update(['status_id' => '2']);
    }
  }

  private function workingDays($month_id)
  {
    $nonWorkingDays = DB::table('non_working_days')
      ->where('month_id', $month_id)
      ->selectRaw('user_id, 30 - sum(days) as days')
      ->groupBy('user_id')
      ->get()
      ->toArray();

    foreach ($nonWorkingDays as $nonWorkingDay) {
      WorkingDays::create([
        'user_id' => $nonWorkingDay->user_id,
        'month_id' => $month_id,
        'working_days' => $nonWorkingDay->days <= 0 ? 0 : $nonWorkingDay->days
      ]);
    }

    foreach ($nonWorkingDays as $nonWorkingDay) {
      $nonWorking[] = $nonWorkingDay->user_id;
    }

    $users = User::where('active', '1')
      ->where('salary', '1')
      ->get('id')
      ->except($nonWorking);

    foreach ($users as $user) {
      WorkingDays::create([
        'user_id' => $user->id,
        'month_id' => $month_id,
        'working_days' => '30'
      ]);
    }
  }
}
