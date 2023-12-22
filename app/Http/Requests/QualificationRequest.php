<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QualificationRequest extends FormRequest
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
      'qualification' => 'required',
      'thesis' => 'sometimes|max:255',
      'major_id' => 'required',
      'minor_id' => 'nullable',
      'rating' => 'nullable',
      'gpa'=> 'nullable',
      'gpa_type' => 'nullable',
      'study_type' => 'nullable',
      'graduation_university' => 'required',
      'graduation_college' => 'nullable',
      'graduation_date' => 'required',
      'city' => 'nullable',
      'graduation_country' => 'required',
      'study_nature' => 'nullable',
      'attachment.*' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'qualification.required' => __('The Qualification is required'),
      'major_id.required' => __('The major is required'),
      'graduation_university.required' => __('The graduation University is required'),
      'graduation_date.required' => __('The graduation date is required'),
      'graduation_country.required' => __('The graduation country is required'),
      'attachment.mimes' => __('The attachment file must be an image or a pdf file'),
      'attachment.max' => __('The maximum file size should not exceed 2 MBs')
    ];
  }
}
