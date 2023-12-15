<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExitReentry extends Model
{
  use HasFactory;

  protected $table = 'exit_reentries';

  protected $fillable = [
    'user_id' , 'from', 'to'
  ];

  public function days()
  {
    $start = Carbon::parse($this->from);
    $end = Carbon::parse($this->to);
    return $end->diffInDays($start) + 1;
  }
}
