<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationStatus extends Model
{
  use HasFactory;

  protected $table = '_accommodation_status';

  protected $fillable = [
    'accommodation_status_en', 'accommodation_status_ar', 'code'
  ];
}
