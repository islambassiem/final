<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
  use HasFactory;

  protected $table = 'transportation_requests';

  protected $fillable = [
    'user_id', 'destination', 'date', 'from', 'to', 'passengers', 'notes'
  ];
}
