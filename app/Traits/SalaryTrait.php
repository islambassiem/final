<?php

namespace App\Traits;

use App\Models\Salary;

trait SalaryTrait
{

  public function salary($user_id, $date)
  {
    return Salary::where('user_id', $user_id)
    ->where('effective', '<=', $date)
    ->orderByDesc('effective')
    ->first();
  }

  public function package($user_id, $date)
  {
    return $this->floatval($this->salary($user_id, $date)->package());
  }

  public function floatval(string $string) :float
  {
    return floatval(str_replace(',', '', $string));
  }
}