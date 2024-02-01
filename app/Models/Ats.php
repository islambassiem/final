<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ats extends Model
{
  use HasFactory;

  protected $table = 'ats';

  protected $fillable = [
    'user_id', 'ats'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
