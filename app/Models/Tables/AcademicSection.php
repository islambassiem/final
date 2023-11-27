<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSection extends Model
{
  use HasFactory;

  protected $table = '_academic_sections';

  protected $fillable = [
    'section_en', 'section_ar', 'code'
  ];
}
