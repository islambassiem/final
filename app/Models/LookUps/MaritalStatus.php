<?php

namespace App\Models\LookUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
  use HasFactory;

  protected $table = '_marital_stratuses';

  protected $fillable = [
    'marital_status_en', 'marital_status_ar', 'code'
  ];
}
