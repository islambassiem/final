<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
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
      'position' => 'nullable',
      'institution_id' => 'required',
      'city_id' => 'required',
      'college_id' => Rule::requiredIf(fn () => auth()->user()->category_id == 1 ? true : false),
      'section_id' => 'required',
      'major_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'minor_id' => 'nullable',
      'employment_number' => 'nullable',
      'academic_rank_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'professional_rank_id' => Rule::requiredIf(fn () => ! auth()->user()->category_id),
      'hiring_date' => 'nullable',
      'joining_date' => 'nullable',
      'resignation_date' => 'nullable',
      'appointment_type_id' => 'nullable',
      'employment_status_id' => 'nullable',
      'tasks' => 'nullable',
      'job_type_id' => 'nullable',
      'accommodation_status_id' => 'nullable',
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'institution_id.required' => __('The institution is required'),
      'city_id.required' => __('The city is required'),
      'college_id.required' => __('The College is required'),
      'section_id.required' => __('The Department is required'),
      'major_id.required' => __('The Major is required'),
      'academic_rank_id.required' => __('The academic Rank is required'),
      'professional_rank_id.required' => __('The Professional Rank is required'),
      'attachment.mimetypes' => __('The file is invalid'),
      'attachment.max' => __('The maximum file upload is 2MBs')
    ];
  }
}
