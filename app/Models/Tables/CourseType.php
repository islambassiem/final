<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
  use HasFactory;

  protected $table = '_course_types';

  protected $fillable = [
    'course_type_en', 'course_type_ar', 'code'
  ];
}
