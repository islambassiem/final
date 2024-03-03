<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HolidayRequest extends FormRequest
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
      'from' => 'required|date|before_or_equal:to',
      'to' => 'required|date|after_or_equal:from',
      'description' => 'required|max:255',
      'branch_id' => 'required'
    ];
  }

  public function messages()
  {
    return [
      'from.required' => __('admin/holiday.fromReq'),
      'to.required' => __('admin/holiday.toReq'),
      'from.date' => __('admin/holiday.dateInvaild'),
      'from.before' => __('admin/holiday.dateInvaild'),
      'to.date' => __('admin/holiday.dateInvaild'),
      'to.after' => __('admin/holiday.dateInvaild'),
      'description.required' => __('admin/holiday.descReq'),
      'branc_id.required' => __('admin/holiday.branchReq')
    ];
  }
}
