<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
  use HasFactory;

  protected $table = '_relationships';

  protected $fillable = [
    'relationship_en', 'relationship_ar', 'code'
  ];
}
