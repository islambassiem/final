<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
  use HasFactory;

  protected $table = 'branches';

  protected $fillable = [
    'name_en', 'name_ar', 'code'
  ];
}
