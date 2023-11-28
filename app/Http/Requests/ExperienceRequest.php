<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return false;
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
      'position' => 'required',
      'institution_id' => 'required',
      'college_id' => 'required',
      'city_id' => 'required',
      'section_id' => 'required',
      'major_id' => 'required',
      'minor_id' => 'required',
      'academic_rank_id' => 'required',
      'professional_rank_id' => 'required',
      'hiring_date' => 'required',
      'joining_date' => 'required',
      'resignation_date' => 'required',
      'appointment_type_id' => 'required',
      'employment_status_id' => 'required',
      'tasks' => 'required',
      'job_type_id' => 'required',
      'accommodation_status_id' => 'required'
    ];
  }
}
