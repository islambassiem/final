<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
  use HasFactory;

  protected $table = '_ratings';

  protected $fillable = [
    'rating_en', 'rating_ar', 'code'
  ];
}
