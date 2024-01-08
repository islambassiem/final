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
    'user_id' , 'from', 'to', 'deduction'
  ];

  public function boolToIcon($value)
  {
    if($value){
      return '<i class="bi bi-check-square-fill text-success"></i>';
    }
    return '<i class="bi bi-file-x-fill text-danger"></i>';
  }

  public function days()
  {
    $start = Carbon::parse($this->from);
    $end = Carbon::parse($this->to);
    return $end->diffInDays($start) + 1;
  }

  public function user(){
    return $this->belongsTo(User::class);
  }
}
