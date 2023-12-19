<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
  use HasFactory;

  protected $table = '_leave_types';

  protected $fillable = [
    'leave_type_en', 'leave_type_ar', 'leave_type_code'
  ];
}
