<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
  use HasFactory;

  protected $table = '_specialties';

  protected $fillable = [
    'specialty_en', 'specialty_ar', 'code'
  ];
}
