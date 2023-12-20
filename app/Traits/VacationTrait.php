<?php

namespace App\Traits;

use Carbon\Carbon;
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
}