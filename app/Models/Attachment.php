<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'attachments';

  protected $fillable = [
    'user_id', 'attachment_type', 'link', 'title', 'attachmentable_type', 'attachmentable_id'
  ];

  public function attachmentable(){
    return $this->morphTo();
  }
}
