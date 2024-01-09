<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyVisit extends Model
{
  use HasFactory;

  protected $table = 'family_visits';

  protected $fillable = [
    'user_id', 'number', 'deduction'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function boolToIcon($value)
  {
    if($value){
      return '<i class="bi bi-check-square-fill text-success"></i>';
    }
    return '<i class="bi bi-file-x-fill text-danger"></i>';
  }
}
