<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievement extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'achievements';

  protected $fillable = [
    'user_id', 'title', 'donor', 'year'
  ];
}
