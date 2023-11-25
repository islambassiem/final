<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchProgress extends Model
{
  use HasFactory;

  protected $table = '_research_progress';

  protected $fillable = [
    'research_progress_en', 'research_progress_ar', 'code'
  ];
}
