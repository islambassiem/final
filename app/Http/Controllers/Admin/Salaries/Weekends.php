<?php

namespace App\Http\Controllers\Admin\Salaries;

use DateTime;
use DateInterval;
use Carbon\Carbon;
use App\Models\Vacation;
use App\Models\VacationDetail;
use Illuminate\Support\Facades\DB;

trait Weekends
{

  public function weekends(string $start_date, string $end_date)
  {
    return $this->thursdays($start_date, $end_date);
  }

  private function thursdays(string $start_date, string $end_date)
  {
    $thursdays =  $this->getDays($start_date, $end_date, 'Thursday');

    $abscent = Vacation::query()
      ->whereIn('vacation_type', [1, 3, 4])
      ->whereIn('end_date', $thursdays)
      ->get();

    foreach ($abscent as $user) {
      $friday = Carbon::parse($user->end_date)->addDays(1)->format('Y-m-d');
      $saturday = Carbon::parse($user->end_date)->addDays(2)->format('Y-m-d');
      $sunday = Carbon::parse($user->end_date)->addDays(3)->format('Y-m-d');

      if ($this->isEmployeeAbsent($user->user_id, $saturday) && !$this->insertedBefore($user->user_id, $friday)) {
        $this->insertAbscent($user->user_id, $friday);
      }

      if ($this->isEmployeeAbsent($user->user_id, $sunday) && !$this->insertedBefore($user->user_id, $friday)) {
        $this->insertAbscent($user->user_id, $friday);
      }

      if ($this->isEmployeeAbsent($user->user_id, $sunday) && !$this->insertedBefore($user->user_id, $saturday)) {
        $this->insertAbscent($user->user_id, $saturday);
      }
    }
  }

  private function isEmployeeAbsent(string $user_id, string $date)
  {
    return Vacation::query()
      ->where('user_id', $user_id)
      ->where('start_date', $date)
      ->whereIn('vacation_type', [1, 3, 4])
      ->count();
  }

  private function insertedBefore(string $user_id, string $date)
  {
    return Vacation::query()
      ->where('user_id', $user_id)
      ->where('start_date', $date)
      ->count();
  }

  private function getDays(string $start_date, string $end_date, string $dayOfWeek)
  {
    $beg = Carbon::parse($start_date);
    $end = Carbon::parse($end_date);
    $days = [];
    while ($beg <= $end) {
      if ($beg->englishDayOfWeek === $dayOfWeek) {
        $days[] = $beg->format('Y-m-d');
      }
      $beg->addDay();
    }
    return $days;
  }

  private function insertAbscent(string $user_id, string $date)
  {
    DB::transaction(function () use ($user_id, $date) {
      $vacation = Vacation::create([
        'user_id' => $user_id,
        'vacation_type' => '3',
        'start_date' => $date,
        'end_date' => $date,
        'status_id' => '1',
      ]);

      VacationDetail::create([
        'vacation_id' => $vacation->id,
        'head_status' => '1',
        'hr_status' => '1',
        'hr_notes' => 'Added Automatically',
      ]);
    });
  }
}
