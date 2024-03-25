<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Models\Admin\Month;
use App\Models\Tables\VacationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NonWorkingDays extends Model
{
  use HasFactory;

  protected $table = 'non_working_days';

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

  public function vacationType()
  {
    return $this->belongsTo(VacationType::class, 'type', 'id');
  }
}
