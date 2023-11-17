<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
  use HasFactory;

  protected $table = '_sections';

  protected $fillable = [
    'section_en', 'section_ar', 'code'
  ];
}
