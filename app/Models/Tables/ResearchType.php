<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchType extends Model
{
  use HasFactory;

  protected $table = '_research_types';

  protected $fillable = [
    'research_type_en', 'research_type_ar', 'code'
  ];
}
