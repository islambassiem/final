<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
  use HasFactory;

  protected $table = '_genders';

  protected $fillable = [
    'gender_en', 'gender_ar', 'code'
  ];
}
