<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportationDeduction extends Model
{
  use HasFactory;

  protected $tabel = 'transportation_deductions';

  protected $fillable = [
    'user_id', 'from', 'to'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
