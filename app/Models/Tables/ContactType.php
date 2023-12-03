<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
  use HasFactory;

  protected $table = '_contact_types';

  protected $fillable = [
    'type_en', 'type_ar', 'code'
  ];
}
