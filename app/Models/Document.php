<?php

namespace App\Models;

use App\Models\Tables\AttachmentType;
use App\Models\Tables\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
  use HasFactory;

  protected $table = 'documents';

  protected  $fillable = [
    'user_id',
    'document_type_id',
    'description',
    'document_id',
    'place_of_issue',
    'date_of_issue',
    'date_of_expiry',
    'notification'
  ];

  public function document()
  {
    return $this->belongsTo(AttachmentType::class, 'document_type_id', 'id');
  }

  public function attachment(){
    return $this->morphOne(Attachment::class, 'attachmentable');
  }
}
