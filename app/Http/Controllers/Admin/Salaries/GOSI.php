<?php

namespace App\Http\Controllers\Admin\Salaries;

use App\Models\Admin\PayDeduct;
use App\Models\User;

trait GOSI
{

  public function gosi($date, $month_id)
  {
    $salaries = $this->salary($date);
    foreach ($salaries as $salary) {
      PayDeduct::insert([
        'user_id' => $salary['user_id'],
        'month_id' => $month_id,
        'amount' => ((float) str_replace(',', '',$salary['basic']) + (float) str_replace(',', '',$salary['housing'])) * 9.75 / 100,
        'description' => 'GOSI',
        'type' => '0',
        'created_at' => now(),
        'updated_at' => now()
      ]);
    }
  }

  private function salary($date)
  {
    $users = $this->saudi();
    $salary = [];
    foreach ($users as $user) {
      $salary[] = $user->salaries->sortByDesc('effective')
      ->where('effective', '<=', $date)
      ->values()
      ->first();
    }
    return $salary;
  }

  private function saudi()
  {
    $users = User::with('salaries')
      ->where('active', '1')
      ->where('nationality_id', '1')
      ->where('sponsorship_id', '!=', '3')
      ->where('id', '!=', '3')
      ->get();
    return $users;
  }

}
