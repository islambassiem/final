<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtherExperienceRequest extends FormRequest
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
      'profession' => 'required',
      'organization_name'=> 'required',
      'country_id' => 'required',
      'city' => 'required',
      'department' => 'required',
      'section' => 'required',
      'start_date' => 'required|date',
      'end_date' => 'required|date',
      'functional_tasks' => 'nullable'
    ];
  }

  public function messages()
  {
    return [
      'profession.required' => __('The profession name is required'),
      'organization_name.required' => __('The organization name is required'),
      'city.required' => __('The city name is required'),
      'country_id.required' => __('The country is required'),
      'department.required' => __('The department is required'),
      'section.required' => __('The section is required'),
      'start_date.required' => __('The start date is required'),
      'start_date.date' => __('The start date is invalid'),
      'end_date.required|date' => __('The end date is required'),
      'end_date.date' => __('The end date is invalid'),
    ];
  }
}
