<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
  use HasFactory;

  protected $table = '_banks';

  protected $fillable = [
    'bank_name_en', 'bank_name_ar', 'bank_code'
  ];
}
