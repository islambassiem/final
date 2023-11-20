<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcquaintanceRequest extends FormRequest
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
      'name' => 'required|string|max:255',
      'mobile' => 'required|min:10|max:15',
      'email' => 'required|email',
      'position' => 'required|max:255'
    ];
  }

  public function messages()
  {
    return [
      'name.required' => __("The name is required"),
      'name.string' => __('The name is invalid'),
      'name.max' => __('The name is invalid'),
      'mobile.required' => __('The mobile is required'),
      'mobile.min' => __('The mobile is invalid'),
      'mobile.max' => __('The mobile is invalid'),
      'email.required' => __('The email is required'),
      'email.email' => __('The email is invalid'),
      'position.required' => __('The position is required'),
      'position.max' => __('The position max length is 255 character long'),
    ];
  }
}
