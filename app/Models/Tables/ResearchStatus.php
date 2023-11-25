<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchStatus extends Model
{
  use HasFactory;

  protected $table = '_research_status';

  protected $fillable = [
    'research_status_en', 'research_status_ar', 'code'
  ];
}
