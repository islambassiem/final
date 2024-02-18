<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacation;
use App\Models\Admin\Month;
use App\Http\Requests\PayslipRequest;
use App\Models\Admin\Attendance;
use App\Models\Admin\PayDeduct;

class PayslipController extends Controller
{

  public function __construct()
  {
    return  $this->middleware('auth');
  }

  public function index(PayslipRequest $request, string $id = null)
  {
    $user = $id == null ? User::find(auth()->user()->id) : User::find($id);
    $userMonth = $request->month;
    $userYear = $request->year;
    $month = Month::where('month', $userMonth)
      ->where('year', $userYear)
      ->first();
    $payslip = PayDeduct::where('user_id', $user->id)
      ->where('month_id', $month->id)
      ->get();
    $workingDays = 30 - Attendance::where('user_id', $user->id)
      ->where('month_id', $month->id)
      ->sum('days');
      return $this->processSalary($month->start_date, $month->end_date);
    return view('salary.payslip', [
      'user' => $user,
      'month' => Carbon::create($userYear, $userMonth),
      'workingDays' => $workingDays,
      'paidDays' => 5,
      'unpaidDays' => 5,
      'annual' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '1'),
      'sick' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '2'),
      'absent' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '3'),
      'unpaid' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '4'),
      'maternity' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '5'),
      'paternity' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '6'),
      'study' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '7'),
      'pilgrimage' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '8'),
      'death' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '9'),
      'marriage' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '10'),
      'other' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '11'),
      'business' => $this->getAttendance($this->month_id($month->start_date, $month->end_date) , '12'),
      'start_date' => Carbon::parse($month->start_date)->format('j/m/Y'),
      'end_date' => Carbon::parse($month->end_date)->format('j/m/Y'),
      'payables' => $payslip->where('transaction_type', '1'),
      'deductables' => $payslip->where('transaction_type', '0'),
    ]);
  }


  public function getMonth($year)
  {
    $months = Month::where('year',  $year)->get('month');
    return json_encode($months);
  }

  public function attendance($start, $end, $status)
  {
    $vacations = Vacation::where('start_date' , '<=', $end)
      ->where('end_date', '>=', $start)
      ->where('status_id', $status)
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
    return $vacations->toArray();
  }

  public function processSalary($start, $end)
  {
    $pending  = $this->attendance($start, $end, 0);
    $approved = $this->attendance($start, $end, 1);
    $declined = $this->attendance($start, $end, 2);

    $this->dbAttendanceFeed($approved, $start, $end);
    $this->dbAttendanceFeed($pending, $start, $end, '4');
    $this->dbAttendanceFeed($declined, $start, $end, '3');
  }

  public function dbAttendanceFeed($attendance, $start, $end, $vacation_type = null)
  {
    foreach ($attendance as $user => $item) {
      foreach($item as $type => $days){
        $type = $vacation_type == null ? $type : $vacation_type;
        Attendance::create([
          'user_id' => $user,
          'month_id' => $this->month_id($start, $end),
          'type' => $type,
          'days' => $days
        ]);
      }
    }
  }


  public function month_id($start, $end)
  {
    $month =  Month::where('start_date', $start)->where('end_date', $end)->first('id');
    return $month->id;
  }

  public function getAttendance($month_id, $type, $id = null)
  {
    $user_id = $id == null ? auth()->user()->id : $id;
    $days = Attendance::where('user_id', $user_id)
      ->where('month_id', $month_id)
      ->where('type', $type)
      ->first('days');
    return $days->days ?? 0;
  }
}
