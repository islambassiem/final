<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
  use HasFactory;

  protected $table = 'salaries';

  protected $fillable = [
    'user_id', 'basic', 'housing', 'transportation', 'food', 'effective'
  ];


  public function package(){
    return $this->basic + $this->housing + $this->transportation + $this->food;
  }
}
