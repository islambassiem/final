<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Support\Facades\DB;

trait VacationTrait{

  private function balance($endDate = null, $joining_date = null, $vacation_class = null ,$user_id = null)
  {
    return round($this->accrued($endDate, $joining_date, $vacation_class) - $this->availed($user_id), 0);
  }

  private function accrued($endDate = null, $joining_date = null, $vacation_class = null)
  {
    $endDate = $endDate ?? date('Y-m-d');
    $joining_date = $joining_date ?? auth()->user()->joining_date;
    $vacation_class = $vacation_class ?? auth()->user()->vacation_class;
    $start = Carbon::parse($joining_date);
    $end = Carbon::parse($endDate);
    $days = $this->days($start, $end);
    $accrued = 0;
    if($vacation_class == 30){
      $accrued =  $days * 30 / 365 ;
    }
    if($vacation_class == 21){
      $joiningDate = Carbon::parse($joining_date);
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

  private function availed($user_id = null)
  {
    $user_id = $user_id ?? auth()->user()->id;
    $availed =  DB::select("SELECT
      SUM(DATEDIFF(
        vacations.end_date,
        vacations.start_date
      ) +1) AS days
    FROM vacations WHERE vacation_type = 1 AND `status_id` = 1 AND user_id = ? AND deleted_at IS NULL LIMIT 1;", [$user_id]);
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

  public function availedInDuration($start, $end, $vacation_type = 1, $status_id = 1, $user_id = null)
  {
    $user_id = $user_id ?? auth()->user()->id;
    $vacations = Vacation::where('user_id', $user_id)
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