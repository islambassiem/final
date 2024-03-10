<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
