<?php

namespace App\Http\Controllers\Admin\Salaries;

use App\Models\Admin\PayDeduct;
use App\Models\Admin\TransportationDeduction;

trait Transportation
{
  public function deduct($month_id)
  {
    $deductions =  TransportationDeduction::with('user')->whereNull('to')->get();
    foreach ($deductions as $deduction) {
      PayDeduct::insert([
        'user_id' => $deduction->user_id,
        'month_id' => $month_id,
        'amount' => $deduction->user->transportation($deduction->user->id),
        'description' => 'Transportation',
        'type' => '0',
        'created_at' => now(),
        'updated_at' => now()
      ]);
    }
  }
}
