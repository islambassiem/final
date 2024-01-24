<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class VacationConflictEnd implements ValidationRule, DataAwareRule
{

  protected $data = [];

  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $end_date = Carbon::parse($value);
    $vacations = Vacation::where('user_id', auth()->user()->id)
      ->orderByDesc('start_date')->get();

    foreach($vacations as $vacation){
      if(
          Carbon::parse($vacation['start_date']) <= $end_date
          &&
          Carbon::parse($vacation['end_date']) >= $end_date){
        $fail(__('vacations.conflict'));
      }
    }
  }

  public function setData(array $data)
  {
    $this->data = $data;
    return $this;
  }
}
