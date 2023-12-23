<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
      'user_id' => 'required',
      'name' => 'required|string|max:100',
      'issuer' => 'required|string|max:100',
      'courseDate' => 'required|date',
      'period' => 'required|string|max:20',
      'country_id' => 'required',
      'city' => 'required|max:30',
      'type_id' => 'required',
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'name.required' => __('The course name is required'),
      'name.string' => __('The course name is invalid'),
      'name.max' => __('The maximum length for the course name is 100 characters'),
      'issuer.required' => __('The course issuer is required'),
      'issuer.string' => __('The course issuer is invalid'),
      'issuer.max' => __('The maximum length for the course issuer is 100 characters'),
      'courseDate.required' => __('The course date is required'),
      'courseDate.date' => __('The course date is invalid'),
      'period.required' => __('The course period is required'),
      'period.string' => __('The course period is invalid'),
      'period.max' => __('The maximum length for the course period is 100 characters'),
      'country_id.required' => __('The country of the course is required'),
      'city' => __('The course city is required'),
      'type_id.required' => __('The course type is required'),
      'attachment.mimetypes' => __('The file is invaild'),
      'attachment.max' => __('The maximum file upload is 2MBs'),
    ];
  }
}
