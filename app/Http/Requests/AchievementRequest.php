<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementRequest extends FormRequest
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
      'title' => 'required|max:255',
      'donor' => 'required|max:255',
      'year' => 'numeric|min:1900|max:2100'
    ];
  }

  public function messages()
  {
    return [
      'title.required' => __('The achievement title is required'),
      'title.max' => __('The max number of character allowed is 255 characters'),
      'donor.required' => __('The donor is required'),
      'donor.max' => __('The max number of character allowed is 255 characters'),
      'year.numeric' => __('The achievement year is required'),
      'year.min' => __('The year you entered is invalid'),
      'year.max' => __('The year you entered is invalid'),
    ];
  }
}
