<?php

namespace App\Models\LookUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
  use HasFactory;

  protected $table = '_religions';

  protected $fillable = [
    'religion_en', 'religion_ar', 'code'
  ];
}
