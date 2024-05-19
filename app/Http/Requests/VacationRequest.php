<?php

namespace App\Http\Requests;

use App\Rules\AnnualVacationEndRule;
use App\Rules\AnnualVacationStartRule;
use App\Rules\VacationConflictEnd;
use App\Rules\VacationConflictStart;
use Illuminate\Foundation\Http\FormRequest;

class VacationRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'start_date' => ['required','date', 'before_or_equal:end_date', new AnnualVacationStartRule, new VacationConflictStart],
      'end_date' => ['required', 'date', 'after_or_equal:start_date', new AnnualVacationEndRule, new VacationConflictEnd],
      'vacation_type' => ['required'],
      'employee_notes' => ['nullable', 'max:255'],
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'start_date.required' => __('The vacation start date is required'),
      'start_date.date' => __('The vacation start date is invalid'),
      'start_date.before_or_equal' => __('The vacation start date must be before its end date'),
      'end_date.required' => __('The vacation end date is required'),
      'end_date.date' => __('The vacation end date is invalid'),
      'end_date.after_or_equal' => __('The vacation end date must be after its start date'),
      'vacation_type.required' => __('The vacation type is required'),
      'employee_notes' => __('Your notes must not exceed 255 characters'),
      'attachment.mimetypes' => __('The file is invalid'),
      'attachment.max' => __('The maximum file upload is 2MBs'),
    ];
  }
}
