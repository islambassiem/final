<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tables\FamilyRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dependent extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'dependents';

  protected $fillable = [
    'user_id', 'name', 'identification', 'date_of_birth', 'relationship_id', 'ticket'
  ];

  public function relationship(){
    return $this->belongsTo(FamilyRelationship::class);
  }
}
