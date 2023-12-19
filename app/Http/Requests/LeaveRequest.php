<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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
      'leave_type' => 'required',
      'date' => 'required|date',
      'from' => 'required|date_format:H:i|before:to',
      'to' => 'required|date_format:H:i|after:from',
      'employee_notes' => 'nullable',
      'attachment' => 'file'
    ];
  }

  public function messages()
  {
    return [
      'leave_type.required' => __('The permission type is required'),
      'date.required' => __('The permission date is required'),
      'from.required' => __('The start time of the permisson is required'),
      'from.before' => __('The start time of the permission should be before the end time'),
      'to.required' => __('The end of the permission is required'),
      'to.after' => __('The end of the permission should be after the start time')
    ];
  }
}
