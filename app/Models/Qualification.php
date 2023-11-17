<?php

namespace App\Models;

use App\Models\Tables\GPATypes;
use App\Models\Tables\Qualification as TablesQualification;
use App\Models\Tables\StudyNature;
use App\Models\Tables\Rating;
use App\Models\Tables\Specialty;
use App\Models\Tables\StudyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Qualification extends Model
{
  use HasFactory;

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
    return $this->belongsTo(TablesQualification::class, 'qualification', 'code');
  }

  public function major(){
    return $this->belongsTo(Specialty::class, 'major_id', 'code');
  }

  public function minor(){
    return $this->belongsTo(Specialty::class, 'minor_id', 'code');
  }

  public function studyType(){
    return $this->belongsTo(StudyType::class, 'study_type', 'code');
  }

  public function studyNature(){
    return $this->belongsTo(StudyNature::class, 'study_nature', 'code');
  }

  public function GPAType(){
    return $this->belongsTo(GPATypes::class, 'gpa_type', 'code');
  }

  public function ratings(){
    return $this->belongsTo(Rating::class, 'rating', 'code');
  }

  public function attachment(){
    return $this->morphOne(Attachment::class, 'attachmentable');
  }
}

