<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  protected $table = 'addresses';

  protected $fillable = [
    'user_id',
    'type',
    'building_no',
    'street_name',
    'district_name',
    'city',
    'country_id',
    'zip_code',
    'secondary_number'
  ];
}
