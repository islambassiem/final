<?php

namespace App\Models;

use App\Models\Admin\Month;
use App\Models\Tables\VacationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
  use HasFactory;

  protected $table = 'payslips';

  protected $fillable = [
    'user_id', 'month_id', 'days', 'type',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function month()
  {
    return $this->belongsTo(Month::class);
  }

  public function type()
  {
    return $this->belongsTo(VacationType::class);
  }
}
