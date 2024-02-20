<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingDays extends Model
{
  use HasFactory;

  protected $table = 'working_days';

  protected $fillable = [
    'user_id', 'month_id', 'working_days'
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
