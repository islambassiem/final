<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayDeduct extends Model
{
  use HasFactory;

  protected $table = 'pay_deduct';

  protected $fillable = [
    'user_id', 'month_id', 'amount', 'description', 'type'
  ];

  public function getAmountAttribute($value)
  {
    return number_format($value, 2);
  }
}
