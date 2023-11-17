<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
  use HasFactory;

  protected $table = 'attachments';

  protected $fillable = [
    'user_id', 'attachment_type', 'link', 'title'
  ];

  public function attachmentable(){
    return $this->morphTo();
  }
}
