<?php

namespace App\Models;

use App\Models\Tables\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherExperience extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'other_experiences';

  protected $fillable = [
    'user_id', 'profession', 'organization_name', 'city',
    'country_id', 'department', 'section', 'start_date',
    'end_date', 'functional_tasks'
  ];

  public function country(){
    return $this->belongsTo(Country::class);
  }

  public function attachment(){
    return $this->morphOne(Attachment::class, 'attachmentable');
  }

  public function tasksShow(){
    $file = public_path('storage/' . auth()->user()->id . '/text//'.$this->id.'_otherExperience.txt');
    if(file_exists($file))
    {
      echo file_get_contents($file);
    }
    return '';
  }

  public function tasksEdit(){
    $file = public_path('storage/' . auth()->user()->id . '/text//'.$this->id.'_otherExperience.txt');
    if(file_exists($file))
    {
      return file_get_contents($file);
    }
    return '';
  }
}
