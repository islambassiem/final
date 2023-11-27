<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalInstitution extends Model
{
  use HasFactory;

  protected $table = '_educational_institutions';

  protected $fillable = [
    'institute_en', 'institute_ar', 'code'
  ];
}
