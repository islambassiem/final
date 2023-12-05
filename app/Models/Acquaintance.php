<?php

namespace App\Models;

use App\Models\LookUps\Relationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acquaintance extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'acquaintance';

  protected $fillable = [
    'user_id', 'name', 'email', 'mobile', 'position', 'created_by', 'updated_by'
  ];

  protected function name(): Attribute
  {
    return Attribute::make(
      get: fn (string $value) => ucwords($value),
      set: fn (string $value) => strtolower($value)
    );
  }
}
