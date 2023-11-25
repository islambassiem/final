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
      'user_id' => 'required',
      'type_id' => 'required',
      'status_id' => 'required',
      'progress_id' => 'required',
      'nature_id' => 'required',
      'domain_id' => 'required',
      'title' => 'required|max:255',
      'lang_id' => 'required',
      'publication_location' => 'required',
      'publishing_date' => 'required|date',
      'publisher' => 'nullable',
      'edition' => 'nullable',
      'isbn' =>'nullable',
      'magazine' => 'nullable',
      'publishing_url' => 'nullable',
      'summary' => 'nullable',
      'key_words' => 'nullable',
      'pages_number' => 'nullable',

    ];
  }

  public function messages()
  {
    return [
      'type_id.required' => __('The research type is required'),
      'status_id.required' => __('Research status is required'),
      'progress_id.required' => __('The research Progress is required'),
      'nature_id.required' => __('The research nature is required'),
      'domain_id.required' => __('The research domain is required'),
      'title.required' => __('The research title is required'),
      'title.max' => __('The maximum number of allowed characters is 255'),
      'publishing_date.required' => __('The publication date is required'),
      'publishing_date.date' => __('The date is invalid'),
      'lang_id.required' => __('The research language is required'),
      'publication_location.required' => __('The publication location is required')
    ];
  }
}
