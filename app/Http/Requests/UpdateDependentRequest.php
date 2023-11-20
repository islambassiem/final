<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDependentRequest extends FormRequest
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
      'identification' => 'required|string|max:10|min:10',
      'date_of_birth' => 'required|date',
      'relationship_id'  => 'required'
    ];
  }
  public function messages()
  {
    return [
      'name.required' => __('The dependent name is required'),
      'name.string' => __('The dependent name must be a text'),
      'name.max' => __('The dependent name can not exceed 255 characters'),
      'identification.required'  => __('The ID number of the depenedent is required'),
      'identification.max' => __('The ID is invalid'),
      'identification.min' => __('The ID is invalid'),
      'identification.string' => __('The ID is invalid'),
      'date_of_birth.required' => __('The date of birth is required'),
      'date_of_birth.date'  => __('Date of Birth is requried'),
      'relationship.required' => __('Relation with the employee is required')
    ];
  }
}
