<?php

namespace App\Models;

use App\Models\Tables\Bank as TablesBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
  use HasFactory;

  protected $table = 'banks';

  protected $fillable = [
    'user_id', 'bank_code', 'iban'
  ];

  public function bank()
  {
    return $this->belongsTo(TablesBank::class, 'bank_code', 'id');
  }
}
