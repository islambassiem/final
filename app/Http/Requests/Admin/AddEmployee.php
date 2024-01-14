<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddEmployee extends FormRequest
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
      'empid' => 'required|string|max:6|min:6|unique:users,empid',
      'first_name_en' => 'required|string',
      'middle_name_en' => 'nullable',
      'third_name_en' => 'nullable',
      'family_name_en' => 'required|string',
      'first_name_ar' => 'required|string',
      'middle_name_ar' => 'nullable',
      'third_name_ar' => 'nullable',
      'family_name_ar' => 'required|string',
      'personal_email' => 'nullable',
      'email' => 'required|email|unique:users,email',
      'mobile' => 'required',
      'gender_id' => 'required',
      'nationality_id' => 'required',
      'religion_id' => 'nullable',
      'marital_status_id' => 'nullable',
      'married_contract' => 'nullable',
      'special_need_id' => 'nullable',
      'date_of_birth' => 'required|date',
      'document_id1' => 'required|string|max:10|min:10',
      'place_of_issue1' => 'nullable',
      'date_of_issue1' => 'nullable',
      'date_of_expiry1' => 'required',
      'document_id2' => 'nullable',
      'place_of_issue2' => 'nullable',
      'date_of_issue2' => 'nullable',
      'date_of_expiry2' => 'nullable',
      'section_id' => 'required',
      'position_id' => 'nullable',
      'category_id' => 'required',
      'sponsorship_id' => 'required',
      'joining_date' => 'required|date',
      'resignation_date' => 'nullable',
      'vacation_class' => 'nullable',
      'cost_center' => 'nullable',
      'salary' => 'nullable',
      'fingerprint' => 'nullable',
      'basic' => 'nullable',
      'housing' => 'nullable',
      'trans' => 'nullable',
      'food' => 'nullable',
      'ticket' => 'nullable',
      'iban' => 'nullable',
      'bank_code' => 'nullable',
      'notes' => 'nullable'
    ];
  }

  public function messages()
  {
    return [
      'empid.required' => 'الرقم الوظيفي مطلوب',
      'empid.unique' => 'الرقم موجود مسبقاً',
      'first_name_en.required' => __('admin/staff.first_name_en.required'),
      'family_name_en.required' => __('admin/staff.family_name_en.required'),
      'first_name_ar.required' => __('admin/staff.first_name_ar.required'),
      'family_name_ar.required' => __('admin/staff.family_name_ar.required'),
      'email.required' => __('admin/staff.email.required'),
      'email.email' => __('admin/staff.email.email'),
      'email.unique' => __('admin/staff.unique'),
      'mobile.required' => __('admin/staff.mobile.required'),
      'gender_id.required' => __('admin/staff.gender.required'),
      'nationality_id.required' => __('admin/staff.nationality.required'),
      'date_of_birth.required' => __('admin/staff.dob.required'),
      'date_of_birth.date' => __('admin/staff.dob.date'),
      'document_id1.required' => __('admin/staff.document_id1.required'),
      'document_id1.max' => __('admin/staff.document_id1.invalid'),
      'document_id1.min' => __('admin/staff.document_id1.invalid'),
      'date_of_expiry1.required' => __('admin/staff.date_of_expiry1.required'),
      'section_id.required' => __('admin/staff.section.required'),
      'category_id.required' => __('admin/staff.category.required'),
      'sponsorship_id.required' => __('admin/staff.sponsorship.required'),
      'joining_date.required' => __('admin/staff.doj.required')
    ];
  }
}
