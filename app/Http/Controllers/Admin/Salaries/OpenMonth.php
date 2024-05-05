<?php

namespace App\Http\Controllers\Admin\Salaries;

use App\Models\Admin\Month;
use Carbon\Carbon;

trait OpenMonth
{
  public function openMonth()
  {
    if(Month::where('status', '0')->first() == null)
    {
      $last_month = Month::where('status', '1')->orderByDesc('month')->first();
      $start_date = Carbon::parse($last_month->end_date)->addDay();
      $end_date = Carbon::parse($last_month->end_date)->copy()->addMonth();
      $month = $last_month->month == 12 ? 1 :  $last_month->month + 1;
      $year = $last_month->month == 12 ? $last_month->year + 1 : $last_month->year;
      Month::create([
        'start_date' => $start_date,
        'end_date' => $end_date,
        'month' => $month,
        'year' => $year,
        'user_id' => 71
      ]);
    }
    return Month::orderByDesc('created_at')->first();
  }
}
