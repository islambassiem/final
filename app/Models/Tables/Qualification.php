<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
  use HasFactory;

  protected $table = '_qualifications';

  protected $fillable = [
    'qualification_en', 'qualification_ar', 'code'
  ];
}
