<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tables\Gender;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tables\FamilyRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dependent extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'dependents';

  protected $fillable = [
    'user_id', 'name', 'identification', 'gender_id' ,'date_of_birth', 'relationship_id', 'ticket', 'insurance'
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
    $age = $now->diffInDays($this->date_of_birth) / 365;
    if($this->ticket == 0){
      return 0;
    }
    if($age < 2){
      return 0.2;
    }else if ($age < 11){
      return 0.8;
    }
    return 1;
  }

  public function gender()
  {
    return $this->belongsTo(Gender::class);
  }
}
