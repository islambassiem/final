<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tables\Country;
use App\Models\Tables\CourseType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'courses';

  protected $fillable = [
    'user_id', 'name', 'type_id', 'issuer', 'courseDate', 'period', 'city', 'country_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function type()
  {
    return $this->belongsTo(CourseType::class);
  }

  public function country()
  {
    return $this->belongsTo(Country::class);
  }
}
