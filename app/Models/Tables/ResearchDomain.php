<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchDomain extends Model
{
  use HasFactory;

  protected $table = '_research_domains';

  protected $fillable = [
    'research_domain_en', 'research_domain_ar', 'code'
  ];
}
