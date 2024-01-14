<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
  use HasFactory;

  protected $table = 'temp_users';

  protected $fillable = [
    'empid'
    ,'email'
    ,'head'
    ,'first_name_en'
    , 'middle_name_en'
    , 'third_name_en'
    , 'family_name_en'
    , 'first_name_ar'
    , 'middle_name_ar'
    , 'third_name_ar'
    , 'family_name_ar'
    , 'gender_id'
    , 'nationality_id'
    , 'religion_id'
    , 'date_of_birth'
    , 'place_of_birth_id'
    , 'marital_status_id'
    , 'joining_date'
    , 'resignation_date'
    , 'position_id'
    , 'sponsorship_id'
    , 'section_id'
    , 'category_id'
    , 'active'
    , 'salary'
    , 'fingerprint'
    , 'saturday'
    , 'cost_center'
    , 'married_contract'
    , 'vacation_class'
    , 'notes'
    , 'special_need_id'
    , 'home_country_id'
    , 'document_id'
    , 'basic'
    , 'housing'
    , 'transportation'
    , 'food'
    , 'bank_code'
    , 'iban'
    , 'mobile'
    , 'personal_email'
    , 'created_by'
    , 'updated_by'
    , 'place_of_issue1'
    , 'date_of_issue1'
    , 'date_of_expiry1'
    , 'document_id2'
    , 'place_of_issue2'
    , 'date_of_issue2'
    , 'date_of_expiry2'
    , 'ticket'
  ];

}
