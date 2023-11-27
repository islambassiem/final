<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
  use HasFactory;

  protected $table = '_job_types';

  protected $fillable = [
    'job_type_en', 'job_type_ar', 'code'
  ];
}
