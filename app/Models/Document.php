<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tables\DocumentType;
use App\Models\Tables\AttachmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

  public function getExpiryAttribute()
  {
    $start = Carbon::createMidnightDate(date('Y-m-d'));
    $end = Carbon::parse($this->date_of_expiry);
    return  $start->diffInDays($end, false);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
