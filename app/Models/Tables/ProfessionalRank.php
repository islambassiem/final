<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalRank extends Model
{
  use HasFactory;

  protected $table = '_professional_ranks';

  protected $fillable = [
    'rank_en', 'rank_ar', 'code'
  ];
}
