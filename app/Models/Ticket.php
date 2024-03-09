<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  use HasFactory;

  protected $table = 'tickets';

  protected $fillable = [
    'user_id', 'amount', 'effective'
  ];

  public function getTicketAttribute()
  {
    return number_format($this->attributes['amount'], 2);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
