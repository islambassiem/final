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
      'title' => 'required|max:100',
      'donor' => 'nullable|max:100',
      'year' => 'numeric|min:1900|max:2100',
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'title.required' => __('The achievement title is required'),
      'title.max' => __('The max number of character allowed is 100 characters'),
      'donor.max' => __('The max number of character allowed is 100 characters'),
      'year.numeric' => __('The achievement year is required'),
      'year.min' => __('The year you entered is invalid'),
      'year.max' => __('The year you entered is invalid'),
      'attachment.mimetypes' => __('The file is invaild'),
      'attachment.max' => __('The maximum file upload is 2MBs'),
    ];
  }
}
