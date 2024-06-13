<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDiff extends Model
{
  use HasFactory;

  protected $table = 'salary_diff';

  protected $fillable = [
    'empid', 'name', 'month', 'year', 'finance', 'hr'
  ];
}
