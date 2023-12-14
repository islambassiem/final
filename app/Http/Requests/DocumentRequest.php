<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
      'user_id' => 'nullable',
      'document_type_id' => 'required',
      'document_id' => 'required',
      'description' => 'nullable',
      'place_of_issue' => 'required_if:document_type_id,2',
      'date_of_issue' => 'required_if:document_type_id,2',
      'date_of_expiry' => 'required',
      'notification' => 'nullable',
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ];
  }

  public function messages()
  {
    return [
      'document_type_id.required' => __('You must choose the type of your document'),
      'document_id.required' => __('You document ID is required'),
      'place_of_issue.required_if' => __('The place of issue is required in case the document is a passport'),
      'date_of_issue.required_if' => __('The date of issue is required in case the document is a passport'),
      'date_of_expiry.required' => __('The expiry date of the document is required'),
      'attachment.mimetypes' => __('The file is invalid'),
      'attachment.max' => __('The maximum file upload is 2MBs'),
    ];
  }
}
