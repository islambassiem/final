<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use App\Models\Vacation;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class AnnualVacationStartRule implements DataAwareRule, ValidationRule
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
      $start_date = Carbon::parse($value);
      $day_of_start = $start_date->englishDayOfWeek;
      if ($day_of_start == 'Sunday') {
        $three_days_before = $start_date->subDays(3);
        $annual_vacations = Vacation::where('user_id', auth()->user()->id)
          ->where('vacation_type', '1')->orderByDesc('start_date')->get();
        foreach ($annual_vacations as $vacation) {
          $endingDate = Carbon::parse($vacation['end_date']);
          if ($three_days_before->equalTo($endingDate)) {
            $fail('The start date should be ' . date('d/m/Y', strtotime(Carbon::parse($value)->subDays(2))));
          }
        }
      }
      if ($day_of_start == 'Saturday') {
        $two_days_before = $start_date->subDays(2);
        $annual_vacations = Vacation::where('user_id', auth()->user()->id)
          ->where('vacation_type', '1')->orderByDesc('start_date')->get();
        foreach ($annual_vacations as $vacation) {
          $endingDate = Carbon::parse($vacation['end_date']);
          if ($two_days_before->equalTo($endingDate)) {
            $fail('The start date should be ' . date('d/m/Y', strtotime(Carbon::parse($value)->subDays(1))));
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
