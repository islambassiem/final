<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPayableRequest extends FormRequest
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
      'numberEdit' => 'required|numeric',
      'unitEdit' => 'required',
      'descriptionEdit' => 'required|max:255'
    ];
  }

  public function messages()
  {
    return [
      'numberEdit' => __('admin/salaries.number'),
      'unitEdit' => __('admin/salaries.unit'),
      'descriptionEdit' => __('admin/salaries.descriptionEdit')
    ];
  }
}
