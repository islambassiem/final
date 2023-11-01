<?php

namespace App\Models\LookUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  use HasFactory;

  protected $table = '_countries';

  protected $fillable = [
    'country_en', 'country_ar', 'code'
  ];
}
