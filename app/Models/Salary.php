<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
  use HasFactory;

  protected $table = 'salaries';

  protected $fillable = [
    'user_id', 'basic', 'housing', 'transportation', 'food', 'effective'
  ];

  public function getBasicAttribute()
  {
    return number_format($this->attributes['basic'], 2);
  }

  public function getHousingAttribute()
  {
    return number_format($this->attributes['housing'], 2);
  }

  public function getTransportationAttribute()
  {
    return number_format($this->attributes['transportation'], 2);
  }


  public function getFoodAttribute()
  {
    return number_format($this->attributes['food'], 2);
  }

  public function package()
  {
    $package =  $this->attributes['basic']
      + $this->attributes['housing']
      + $this->attributes['transportation']
      + $this->attributes['food'];
    return number_format($package, 2);
  }
}
