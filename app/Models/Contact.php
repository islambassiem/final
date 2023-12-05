<?php

namespace App\Models;

use App\Models\Tables\ContactType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'contacts';

  protected $fillable = [
    'user_id', 'contact', 'type'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function type()
  {
    return $this->belongsTo(ContactType::class, 'type', 'id');
  }
}
