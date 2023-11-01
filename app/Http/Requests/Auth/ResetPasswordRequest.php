<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
      'email'                   => 'required|string|email|exists:users,email',
      'password'                => 'required|min:8|confirmed',
      'password_confirmation'   => 'required'
    ];
  }

  public function messages()
  {
    return [
      'email.required'  => 'Please Enter your email',
      'email.string'  => 'The email you entered is invalid',
      'email.email'  => 'The email you entered is invalid',
      'email.exists'  => 'Please put your official email',
      'password.required'  => 'You must enter a password',
      'password.min'  => 'The minimun number of characters is 8 characters',
      'password.confirmed'  => 'The passwords do not match',
      'password_confirmation.required' => 'You must fill the password confirmation feild'
    ];
  }
}
