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
      'study_type' => 'required',
      'study_nature' => 'required',
      'graduation_date' => 'required',
      'graduation_university' => 'required',
      'graduation_college' => 'required',
      'graduation_country' => 'required',
      'city' => 'required',
      'thesis' => 'sometimes',
      'major_id' => 'required',
      'minor_id' => 'required',
      'gpa'=> 'required',
      'gpa_type' => 'required',
      'rating' => 'required',
      'attachment.*' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'qualification.required' => __('The Qualification is required'),
      'study_type.required' => __('The study type is required'),
      'study_nature.required' => __('The nature of the study is required'),
      'graduation_date.required' => __('The graduation date is required'),
      'graduation_university.required' => __('The graduation University is required'),
      'graduation_college.required' => __('The graduation college is required'),
      'graduation_country.required' => __('The graduation country is required'),
      'city.required' => __('The city where the university is located is required'),
      'major_id.required' => __('The major is required'),
      'minor_id.required' => __('The minor is required'),
      'gpa.required' => __('Your GPA is required'),
      'gpa_type.required' => __('The GPA type is required'),
      'rating.required' => __('The rating is required'),
      'attachment.mimes' => __('The attachment file must be an image or a pdf file'),
      'attachment.max' => __('The maximum file size should not exceed 2 MDs')
    ];
  }
}
