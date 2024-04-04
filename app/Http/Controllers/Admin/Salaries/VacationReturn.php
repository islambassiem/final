<?php

namespace App\Http\Controllers\Admin\Salaries;

use Carbon\Carbon;
use App\Models\Vacation;
use App\Models\Admin\Month;
use App\Models\Admin\PayDeduct;
use App\Models\Admin\NonWorkingDays;
use App\Models\Salary;

trait VacationReturn
{
  public function vacationReturners($month_id)
  {
    $eligibleUsers = $this->eligibleUsers($month_id);
    $month = Month::find($month_id);
    foreach ($eligibleUsers as $key => $value) {
      foreach ($value as $user_id => $latest_date) {
        if(Carbon::parse($month->start_date)->format('m') == Carbon::parse($latest_date)->format('m'))
          echo $this->previousMonth($user_id, $month_id);
        if(Carbon::parse($month->end_date)->format('m') == Carbon::parse($latest_date)->format('m'))
          echo $this->thisMonth($user_id, $month_id);
      }
    }
  }

  private function thisMonth($user_id, $month_id)
  {
    $latestDay = Carbon::parse($this->latestAbsence($user_id, $month_id)->end_date);
    $newDeduction = (int) $latestDay->format('d');
    $unpaid =  NonWorkingDays::where('month_id', $month_id)
      ->where('user_id', $user_id)
      ->first();
    $unpaid->update(["days" => $newDeduction]);
  }

  private function previousMonth($user_id, $month_id)
  {
    $latestDay = Carbon::parse($this->latestAbsence($user_id, $month_id)->end_date);
    $date = Carbon::parse(Month::find($month_id)->start_date)->lastOfMonth();
    $amount = $this->amount($date, $user_id, 30 - $latestDay->format('d'));
    $description =  30 - $latestDay->format('d') . " working days after vacation " . $date->format('M Y');
    PayDeduct::create([
      'user_id' => $user_id,
      'month_id' => $month_id,
      'amount' => $amount,
      'description' => $description,
      'type' => '1'
    ]);
  }

  private function eligibleUsers($month_id)
  {
    $users = $this->usersInVacation($month_id);
    $month = Month::find($month_id);
    $eligibleUsers = [];
    foreach ($users as $user) {
      $latestAbscent = Carbon::parse($this->latestAbsence($user, $month_id)->end_date);
      if($latestAbscent->lessThanOrEqualTo($month->end_date) && $latestAbscent->greaterThanOrEqualTo($month->start_date))
        array_push($eligibleUsers, [$user => $latestAbscent]);
    }
    return $eligibleUsers;
  }

  private function usersInVacation($month_id)
  {
    $users = $this->usersWithAbsence($month_id);
    $usersToBeProcessed = [];
    foreach ($users as $user) {
      if($this->isVacation($month_id, $user)){
        $usersToBeProcessed[] = $user;
      }
    }
    return $usersToBeProcessed;
  }

  private function usersWithAbsence($month_id)
  {
    $month = Month::find($month_id);
    return  Vacation::where('start_date', '<=', $month->end_date)
      ->where('end_date', '>=', $month->start_date)
      ->whereIn('vacation_type', ['3', '4'])
      ->selectRaw("user_id, datediff(`end_date`, `start_date`) + 1 as days")
      ->orderBy('user_id')
      ->distinct()
      ->pluck('user_id');
  }

  private function isVacation($month_id, $user_id)
  {
    $month = Month::find($month_id);
    $from = Carbon::parse($month->start_date);
    $latestDay = Carbon::parse($this->latestAbsence($user_id, $month_id)->end_date);
    $absenceCount = $latestDay->diffInDays($from) + 1 ;
    $day = $latestDay->copy();
    $totalActualAbsence = 1;
    for ($i = 1; $i < $absenceCount; $i++)
      if($this->checkIfDayExists($day->subDay(), $user_id))
        $totalActualAbsence++;
    if($totalActualAbsence == $absenceCount)
      return true;
    return false;
  }

  private function checkIfDayExists($day, $user_id)
  {
    return Vacation::where('user_id',$user_id)
      ->where('start_date', '<=', $day)
      ->where('end_date', '>=', $day)
      ->whereIn('vacation_type', ['3', '4'])
      ->count();
  }

  private function latestAbsence($user_id, $month_id)
  {
    $month = Month::find($month_id);
    return Vacation::where('user_id', $user_id)
      ->where('start_date', '<=', $month->end_date)
      ->where('end_date', '>=', $month->start_date)
      ->whereIn('vacation_type', ['3', '4'])
      ->orderByDesc('start_date')
      ->first();
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