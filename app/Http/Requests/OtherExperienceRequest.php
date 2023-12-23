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
      'profession' => 'required|max:100',
      'organization_name'=> 'required|max:100',
      'country_id' => 'required',
      'city' => 'nullable|max:30',
      'department' => 'nullable|max:100',
      'section' => 'nullable|max:100',
      'start_date' => 'required|date',
      'end_date' => 'required|date',
      'functional_tasks' => 'nullable',
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'profession.required' => __('The profession name is required'),
      'organization_name.required' => __('The organization name is required'),
      'country_id.required' => __('The country is required'),
      'start_date.required' => __('The start date is required'),
      'start_date.date' => __('The start date is invalid'),
      'end_date.required' => __('The end date is required'),
      'end_date.date' => __('The end date is invalid'),
      'attachment.mimetypes' => __('The file is invalid'),
      'attachment.max' => __('The maximum file upload is 2MBs'),
    ];
  }
}
