<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationType extends Model
{
  use HasFactory;

  protected $table = '_vacation_types';

  protected $fillable = [
    'vacation_type_en', 'vacation_type_ar', 'vacation_type_code', 'ordering'
  ];
}
