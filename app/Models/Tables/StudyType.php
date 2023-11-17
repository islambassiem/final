<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyType extends Model
{
  use HasFactory;

  protected $table = '_study_types';

  protected $fillable = [
    'study_type_en', 'study_type_ar', 'code'
  ];
}
