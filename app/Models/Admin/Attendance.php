<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Models\Admin\Month;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
  use HasFactory;

  protected $table = 'attendance';

  protected $fillable = [
    'user_id', 'month_id', 'type', 'days'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function month()
  {
    return $this->belongsTo(Month::class);
  }
}
