<?php

namespace App\Models;

use App\Models\Tables\FamilyRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
  use HasFactory;

  protected $table = 'dependents';

  protected $fillable = [
    'user_id', 'name', 'identification', 'date_of_birth', 'relationship_id', 'ticket'
  ];

  public function relationship(){
    return $this->belongsTo(FamilyRelationship::class);
  }
}
