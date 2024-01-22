<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class VacationConflictStart implements ValidationRule, DataAwareRule
{

  protected $data = [];

  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $start_date = Carbon::parse($value);
    $vacations = Vacation::where('user_id', auth()->user()->id)
      ->orderByDesc('start_date')->get();

    foreach($vacations as $vacation){
      if($vacation['start_date'] <= $start_date && $vacation['end_date'] >= $start_date){
        $fail('The date you have entered conflicts with vacations you have already applied for before!');
      }
    }
  }

  public function setData(array $data)
  {
    $this->data = $data;
    return $this;
  }
}
