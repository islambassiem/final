<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentType extends Model
{
  use HasFactory;

  protected $table = '_attachment_types';

  protected $fillable = [
    'attachment_type_en', 'attachment_type_ar', 'code'
  ];
}
