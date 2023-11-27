<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
  use HasFactory;

  protected $table = '_appointment_types';

  protected $fillable = [
    'appointment_type_en', 'appointment_type_ar', 'code'
  ];
}
