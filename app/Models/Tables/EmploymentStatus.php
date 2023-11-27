<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model
{
  use HasFactory;

  protected $table = '_employment_status';

  protected $fillable = [
    'employment_status_en', 'employment_status_ar', 'code'
  ];
}

