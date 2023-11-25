<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchNature extends Model
{
  use HasFactory;

  protected $table = '_research_nature';

  protected $fillable = [
    'research_nature_en', 'research_nature_ar', 'code'
  ];
}
