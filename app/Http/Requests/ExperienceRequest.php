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
      'position' => 'required',
      'institution_id' => 'required',
      'college_id' => Rule::requiredIf(fn () => auth()->user()->category_id == 1 ? true : false),
      'city_id' => 'required',
      'section_id' => 'required',
      'major_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'minor_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'academic_rank_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'professional_rank_id' => Rule::requiredIf(fn () => ! auth()->user()->category_id),
      'hiring_date' => 'required',
      'joining_date' => 'required',
      'resignation_date' => 'required',
      'appointment_type_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'employment_status_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'tasks' => '',
      'job_type_id' => Rule::requiredIf(fn () => auth()->user()->category_id  == 1 ? true : false ),
      'accommodation_status_id' => Rule::requiredIf(fn () => ! auth()->user()->category_id),
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'attachment.mimetypes' => __('The file is invaild'),
      'attachment.max' => __('The maximum file upload is 2MBs')
    ];
  }
}
