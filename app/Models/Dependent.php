<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tables\FamilyRelationship;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
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


  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function relationship(){
    return $this->belongsTo(FamilyRelationship::class);
  }

  public function ticketRate()
  {
    $now = Carbon::now();
    $age = $now->diffInYears($this->date_of_birth);
    if($this->ticket == 0){
      return 0;
    }
    if($age <= 2){
      return 0.2;
    }else if ($age <= 11){
      return 0.8;
    }
    return 1;
  }
}
