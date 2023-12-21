<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitationType extends Model
{
  use HasFactory;

  protected $table = '_citation_types';

  protected $fillable = [
    'name', 'code'
  ];
}
