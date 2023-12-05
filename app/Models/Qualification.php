<?php

namespace App\Models;

use App\Models\Tables\Rating;
use App\Models\Tables\GPATypes;
use App\Models\Tables\Specialty;
use App\Models\Tables\StudyType;
use App\Models\Tables\StudyNature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tables\Qualification as TablesQualification;


class Qualification extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'qualifications';

  protected $fillable = [
    'user_id',
    'qualification',
    'major_id',
    'minor_id',
    'rating',
    'gpa',
    'gpa_type',
    'study_type',
    'graduation_university',
    'graduation_college',
    'graduation_date',
    'city',
    'thesis',
    'graduation_country',
    'study_nature',
    'attested',
  ];

  public function qualificationName(){
    return $this->belongsTo(TablesQualification::class, 'qualification', 'id');
  }

  public function major(){
    return $this->belongsTo(Specialty::class, 'major_id', 'id');
  }

  public function minor(){
    return $this->belongsTo(Specialty::class, 'minor_id', 'id');
  }

  public function studyType(){
    return $this->belongsTo(StudyType::class, 'study_type', 'id');
  }

  public function studyNature(){
    return $this->belongsTo(StudyNature::class, 'study_nature', 'id');
  }

  public function GPAType(){
    return $this->belongsTo(GPATypes::class, 'gpa_type', 'id');
  }

  public function ratings(){
    return $this->belongsTo(Rating::class, 'rating', 'id');
  }

  public function attachment(){
    return $this->morphOne(Attachment::class, 'attachmentable');
  }
}

