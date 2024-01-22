<?php

namespace App\Rules;

use Closure;
use App\Models\Leave;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class LeaveConflict implements ValidationRule, DataAwareRule
{

  protected $data = [];

  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $leaves = Leave::where('user_id', auth()->user()->id)
      ->orderByDesc('date')->get();

    foreach ($leaves as $leave) {
      if(Carbon::parse($value)->equalTo($leave['date'])){
        $fail(__('leaves.conflict'));
      }
    }
  }

  public function setData(array $data)
  {
    $this->data = $data;
    return $this;
  }
}
