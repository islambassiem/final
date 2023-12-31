<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyVisit extends Model
{
  use HasFactory;

  protected $table = 'family_visits';

  protected $fillable = [
    'user_id', 'number', 'deduction'
  ];
}
