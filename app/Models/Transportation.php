<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transportation extends Model
{
  use HasFactory;

  protected $table = 'transportation_requests';

  protected $fillable = [
    'user_id', 'destination', 'date', 'from', 'to', 'passengers', 'notes'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
