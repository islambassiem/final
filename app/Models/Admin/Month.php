<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
  use HasFactory;

  protected $table = 'months';

  protected $fillable = [
    'start_date', 'end_date', 'month', 'year' ,'user_id'
  ];

}
