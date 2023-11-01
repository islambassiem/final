<?php

namespace App\Models\LookUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialNeeds extends Model
{
  use HasFactory;

  protected $table = '_special_needs';

  protected $fillable = [
    'special_need_en', 'special_need_ar', 'code'
  ];
}
