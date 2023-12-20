<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\VacationHelperController;

class DashboardController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('dashboard', [
      'availdMonth' => $this->availdVacationThisMonth(),
      'availdYear' => $this->availdVacationThisYear(),
      'balance' => $this->balance()
    ]);
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

  private function availdVacationThisMonth()
  {
    $start = Carbon::now()->startOfMonth()->format('Y-m-d');
    $end = Carbon::now()->endOfMonth()->format('Y-m-d');
    return $this->availdInDuration($start, $end);
  }

  private function availdVacationThisYear()
  {
    $start = Carbon::now()->startOfYear()->format('Y-m-d');
    $end = Carbon::now()->endOfYear()->format('Y-m-d');
    return $this->availdInDuration($start, $end);
  }

  public function availdInDuration($start, $end)
  {
    $vacations = Vacation::where('user_id', auth()->user()->id)
    ->where('status_id', '1')
    ->where('start_date', '<=', $end)
    ->where('end_date', '>=', $start)
    ->get();
    $total = 0;
    foreach ($vacations as $vacation) {
      if($vacation->start_date >= $start){
        $start_date = $vacation->start_date;
        if($vacation->end_date >= $end){
          $end_date = $end;
        }else{
          $end_date = $vacation->end_date;
        }
      }else{
        $start_date = $start;
        if($vacation->end_date <= $end){
          $end_date = $vacation->end_date;
        }else{
          $end_date = $end;
        }
      }
      $diff = Carbon::parse($end_date)->diffIndays(Carbon::parse($start_date)) + 1;
      $total += $diff;
    }
    return $total ;
  }
}
