<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
  use HasFactory;

  protected $table = '_colleges';

  protected $fillable = [
    'college_en', 'college_ar', 'code'
  ];
}
