<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  use HasFactory;

  protected $table = '_positions';

  protected $fillable = [
    'position_en', 'position_ar', 'code'
  ];
}
