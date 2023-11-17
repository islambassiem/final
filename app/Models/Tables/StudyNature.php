<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyNature extends Model
{
  use HasFactory;

  protected $table = '_study_natures';

  protected $fillable = [
    'study_nature_en', 'study_nature_ar', 'code'
  ];
}
