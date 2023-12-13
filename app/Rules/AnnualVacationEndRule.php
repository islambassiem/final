<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class AnnualVacationEndRule implements DataAwareRule, ValidationRule
{

  protected $data = [];


  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    if(($this->data)['vacation_type'] == '1'){
      $end_date = Carbon::parse($value);
      $day_of_end = $end_date->englishDayOfWeek;
      if ($day_of_end == 'Thursday') {
        $three_days_after = $end_date->addDays(3);
        $two_days_after = Carbon::parse($value)->addDays(2);
        $annual_vacations = Vacation::where('user_id', auth()->user()->id)
          ->where('vacation_type', '1')->orderByDesc('start_date')->get();
          foreach ($annual_vacations as $vacation) {
            $startingDate = Carbon::parse($vacation['start_date']);
            if($three_days_after->equalTo($startingDate)){
              $fail('The end date should be ' . date('d/m/Y', strtotime(Carbon::parse($value)->addDays(2))));
            }
            if($two_days_after->equalTo($startingDate)){
              $fail('The end date should be ' . date('d/m/Y', strtotime(Carbon::parse($value)->addDays(1))));
            }
          }
      }
    }
  }

  public function setData(array $data): static
  {
    $this->data = $data;
    return $this;
  }
}
