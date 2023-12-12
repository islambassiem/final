<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionType extends Model
{
  use HasFactory;

  protected $table = '_permission_types';

  protected $fillable = [
    'permission_type_en', 'permission_type_ar', 'permission_type_code'
  ];
}
