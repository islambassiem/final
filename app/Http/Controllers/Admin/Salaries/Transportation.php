<?php

namespace App\Http\Controllers\Admin\Salaries;

use App\Models\User;
use App\Models\Admin\PayDeduct;
use App\Models\Admin\TransportationDeduction;

trait Transportation
{
  public function deduct($date, $month_id)
  {
    $deductions =  $this->transportation($date);
    foreach ($deductions as $deduction) {
      PayDeduct::insert([
        'user_id' => $deduction->user_id,
        'month_id' => $month_id,
        'amount' => $deduction->transportation,
        'description' => 'Transportation',
        'type' => '0',
        'created_at' => now(),
        'updated_at' => now()
      ]);
    }
  }

  private function transportation($date)
  {
    $users = $this->users();
    $salary = [];
    foreach ($users as $user) {
      $salary[] = $user->salaries->sortByDesc('effective')
      ->where('effective', '<=', $date)
      ->values()
      ->first();
    }
    return $salary;
  }

  private function users()
  {
    $users = User::whereHas('transportationDeduction', function($q){
      $q->whereNull('to');
    })
    ->with('salaries')
    ->get();
    return $users;
  }
}
