<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
  use HasFactory;

  protected $table = 'letters';

  protected $fillable = [
    'user_id', 'addressee', 'english', 'salary', 'loan', 'attested', 'deduction'
  ];

  public function boolToIcon($value)
  {
    if($value){
      return '<i class="bi bi-check-square-fill text-success"></i>';
    }
    return '<i class="bi bi-file-x-fill text-danger"></i>';
  }
}
