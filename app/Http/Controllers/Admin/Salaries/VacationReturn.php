<?php

namespace App\Http\Controllers\Admin\Salaries;

use App\Http\Requests\VacationRequest;
use App\Models\Admin\Month;
use App\Models\Admin\NonWorkingDays;
use App\Models\Admin\PayDeduct;
use App\Models\Admin\WorkingDays;
use App\Models\Salary;
use App\Models\Vacation;
use Carbon\Carbon;

trait VacationReturn
{
  public function vacationReturners($month_id)
  {
    $month = Month::find($month_id);
    $vacations = $this->vacations($month_id);

    foreach ($vacations as $vacation) {
      $end_date = Carbon::parse($vacation->end_date);
      if($end_date->lessThanOrEqualTo(Carbon::parse($month->end_date)) && $end_date->greaterThanOrEqualTo(Carbon::parse($month->end_date)->startOfMonth())){
        $this->thisMonth($vacation, $month_id);
      }elseif($end_date->greaterThanOrEqualTo(Carbon::parse($month->start_date)) && $end_date->lessThanOrEqualTo(Carbon::parse($month->start_date)->endOfMonth())){
        $this->previousMonth($vacation, $month_id);
      }
      $vacation->update(['returner' => 0]);
    }
  }

  private function previousMonth($vacation, $month_id)
  {
    $unpaidDays = NonWorkingDays::where('month_id', $month_id)->where('user_id', $vacation->user_id)->where('type', '4')->first();

    $workingDays = WorkingDays::where('month_id', $month_id)->where('user_id', $vacation->user_id)->first();

    $workingDays->update([
      'working_days' => (int) $workingDays->working_days + (int) $unpaidDays->days
    ]);

    $unpaidDays->update([
      'days' => 0
    ]);

    $daysToBePaid = 30 - (int) Carbon::parse($vacation->end_date)->format('d');
    $date = Carbon::parse(Month::find($month_id)->start_date)->lastOfMonth();
    $amount = $this->amount($date, $vacation->user_id, $daysToBePaid);
    $description =  $daysToBePaid . " working days after vacation " . $date->format('M Y');

    PayDeduct::create([
      'user_id' => $vacation->user_id,
      'month_id' => $month_id,
      'amount' => $amount,
      'description' => $description,
      'type' => '1'
    ]);
  }

  private function thisMonth($vacation, $month_id)
  {
    $month             = Month::find($month_id);
    $vacationStartDate = Carbon::parse($vacation->start_date);
    $monthStartDate    = Carbon::parse($month->start_date);
    $monthEndDate      = Carbon::parse($month->end_date);
    $annual            = NonWorkingDays::where('month_id', $month_id)->where('user_id', $vacation->user_id)->where('type', '1')->first();
    $unpaid            = NonWorkingDays::where('month_id', $month_id)->where('user_id', $vacation->user_id)->where('type', '4')->first();

    if ($annual != null) {
      if ($vacationStartDate->lessThanOrEqualTo($monthStartDate->endOfMonth())) {
        $workingDays  = WorkingDays::where('month_id', $month_id)->where('user_id', $vacation->user_id)->first();
        $diff = $vacationStartDate->diffInDays($monthStartDate->endOfMonth()) + 1;

        $unpaid->days = (int) $unpaid->days - $diff;
        $unpaid->save();

        $workingDays->working_days = (int) $workingDays->working_days + $diff;
        $workingDays->save();
      }
    } else {
      $daysToBePaid = 30 - (int)$monthEndDate->format('d');

      $date = Carbon::parse(Month::find($month_id)->end_date)->lastOfMonth()->format('Y-m-d');
      $amount = $this->amount($date, $vacation->user_id, $daysToBePaid);
      $description = "{$daysToBePaid} working days after unpaid vacation";

      PayDeduct::create([
        'user_id' => $vacation->user_id,
        'month_id' => $month_id,
        'amount' => $amount,
        'description' => $description,
        'type' => '1'
      ]);

      $unpaid->update([
        'days' => (int) $unpaid->days - $daysToBePaid
      ]);
    }
  }

  private function vacations($month_id)
  {
    $month = Month::find($month_id);
    $vacations = Vacation::query()
      ->where('start_date', '<=', $month->end_date)
      ->where('end_date', '>=', $month->start_date)
      ->where('returner', 1)
      ->get(['id', 'user_id', 'returner', 'start_date','end_date'])
      ->filter(function ($vacation) use ($month){
        return Carbon::parse($vacation->end_date)->lessThanOrEqualTo(Carbon::parse($month->end_date));
      });
    return $vacations;
  }

  private function amount($date, $user_id, $days)
  {
    $package =  Salary::where('user_id' ,$user_id)
      ->where('effective', '<=', $date)
      ->orderByDesc('effective')
      ->first()
      ->package();

    return round(floatval(str_replace(',', '', $package)) * $days / 30, 2);
  }
}