<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Support\Facades\DB;

trait VacationTrait{

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

  public function availedVacationThisYear($vacation_type = 1, $status_id = 1)
  {
    $start = Carbon::now()->startOfYear()->format('Y-m-d');
    $end = Carbon::now()->endOfYear()->format('Y-m-d');
    return $this->availedInDuration($start, $end, $vacation_type, $status_id);
  }

  public function availedInDuration($start, $end, $vacation_type = 1, $status_id = 1)
  {
    $vacations = Vacation::where('user_id', auth()->user()->id)
    ->where('status_id', $status_id)
    ->where('vacation_type', $vacation_type)
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