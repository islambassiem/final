<?php

namespace App\Http\Requests\Admin\Salaries;

use Illuminate\Foundation\Http\FormRequest;

class PayDeductRequest extends FormRequest
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
      'month_id' => 'required',
      'user_id' => 'required',
      'number' => 'required',
      'unit' => 'required',
      'description' => 'required|max:255'
    ];
  }

  public function attributes()
  {
    return [
      'month_id' => __('admin/salaries.month'),
      'user_id' => __('admin/salaries.employee'),
      'number' => __('admin/salaries.amount'),
      'unit' => __('admin/salaries.unit'),
      'description' => __('admin/salaries.description')
    ];
  }
}
