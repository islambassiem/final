<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPATypes extends Model
{
  use HasFactory;

  protected $table = '_gpa_types';

  protected $fillable = [
    'gpa_type_en', 'gpa_type_ar', 'code'
  ];
}
