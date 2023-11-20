<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyRelationship extends Model
{
  use HasFactory;

  protected $table = '_family_relationships';

  protected $fillable = [
    'relationship_en', 'relationship_ar', 'code'
  ];
}
