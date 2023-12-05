<?php

namespace App\Models;

use App\Models\Tables\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
  use HasFactory;
  use SoftDeletes;

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

  public function country()
  {
    return $this->belongsTo(Country::class);
  }
}
