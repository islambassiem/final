<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\Vacation;
use App\Models\Admin\Month;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\NonWorkingDays;
use App\Http\Controllers\Admin\Salaries\GOSI;
use App\Http\Controllers\Admin\Salaries\Ticket;
use App\Http\Controllers\Admin\Salaries\Transportation;
use App\Models\Admin\WorkingDays;

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

  public function process($month)
  {
    $month    = Month::find($month);
    $month_id = $month->id;
    $start    = $month->start_date;
    $end      = $month->end_date;
    $status   = $month->status;

    if($status){
      return redirect()->back()->with('error', __('admin/salaries.monthProcessed'));
    }

    $this->gosi($end, $month_id);
    $this->tickets($end, $month_id);
    $this->approved($month_id, $start, $end);
    $this->notApproved($month_id, $start, $end);
    $month->update([
      'status' => '1'
    ]);
    return redirect()->back()->with('salarySuccess', __('admin/salaries.salarySuccess'));
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
}
