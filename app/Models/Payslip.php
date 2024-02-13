<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin\Month;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payslip extends Model
{
  use HasFactory;

  protected $table = 'payslips';

  protected $fillable = [
    'user_id', 'month_id', 'transaction_amount', 'transaction_type', 'transaction_description'
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
