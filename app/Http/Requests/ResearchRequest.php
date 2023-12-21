<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchRequest extends FormRequest
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
      'type_id' => 'nullable',
      'status_id' => 'nullable',
      'progress_id' => 'nullable',
      'nature_id' => 'nullable',
      'domain_id' => 'nullable',
      'title' => 'nullable|',
      'lang_id' => 'nullable',
      'publication_location' => 'nullable|max:100',
      'publishing_date' => 'nullable|date',
      'publisher' => 'nullable|max:60',
      'edition' => 'nullable|max:10',
      'isbn' =>'nullable|max:13',
      'magazine' => 'nullable|max:100',
      'publishing_url' => 'nullable|max:1000',
      'summary' => 'nullable',
      'key_words' => 'nullable|max:200',
      'pages_number' => 'nullable|max:5',

    ];
  }

  public function messages()
  {
    return [
      'publishing_date.date' => __('The date is invalid'),
      'lang_id.required' => __('The research language is required'),
      'publication_location.max' => __('The maximum number of allowed characters is 100 characters'),
      'publisher.max' => __('The maximum number of allowed characters is 60 characters'),
      'edition.max' => __('The maximum number of allowed characters is 10 characters'),
      'isbn.max' => __('The maximum number of allowed characters is 13 characters'),
      'magazine.max' => __('The maximum number of allowed characters is 100 characters'),
      'publishing_url.max' => __('The maximum number of allowed characters is 1000 characters'),
      'key_words.max' => __('The maximum number of allowed characters is 200 characters'),
      'pages_number.max' => __('The maximum number of allowed characters is 5 characters'),
    ];
  }
}
