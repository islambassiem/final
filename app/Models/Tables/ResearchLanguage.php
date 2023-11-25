<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchLanguage extends Model
{
  use HasFactory;

  protected $table = '_research_languages';

  protected $fillable = [
    'research_language_en', 'research_language_ar', 'code'
  ];
}
