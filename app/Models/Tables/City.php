<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  use HasFactory;

  protected $table = '_cities';

  protected $fillable = [
    'city_ar', 'city_en', 'code'
  ];
}
