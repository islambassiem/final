<?php

namespace App\Models;

use App\Models\Attachment;
use App\Models\Tables\City;
use App\Models\Tables\College;
use App\Models\Tables\JobType;
use App\Models\Tables\Specialty;
use App\Models\Tables\AcademicRank;
use App\Models\Tables\AcademicSection;
use App\Models\Tables\EmploymentStatus;
use App\Models\Tables\ProfessionalRank;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tables\AppointmentStatus;
use App\Models\Tables\AccommodationStatus;
use App\Models\Tables\EducationalInstitution;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'experiences';

  protected $fillable = [
    'user_id', 'position', 'institution_id', 'college_id',
    'city_id', 'section_id', 'major_id', 'minor_id', 'academic_rank_id',
    'professional_rank_id', 'hiring_date', 'joining_date', 'resignation_date',
    'appointment_type_id', 'employment_status_id', 'tasks', 'job_type_id',
    'accommodation_status_id'
  ];

  public function institution()
  {
    return $this->belongsTo(EducationalInstitution::class, 'institution_id', 'id')->withDefault([
      'institute' . session('_lang') => __('N/A')
    ]);
  }

  public function college()
  {
    return $this->belongsTo(College::class)->withDefault([
      'college' . session('_lang') => __('N/A')
    ]);
  }

  public function city()
  {
    return $this->belongsTo(City::class)->withDefault([
      'city' . session('_lang') => __('N/A')
    ]);
  }

  public function section()
  {
    return $this->belongsTo(AcademicSection::class)->withDefault([
      'section' . session('_lang') => __('N/A')
    ]);
  }

  public function major()
  {
    return $this->belongsTo(Specialty::class, 'major_id', 'id')->withDefault([
      'specialty' . session('_lang') => __('N/A')
    ]);
  }

  public function minor()
  {
    return $this->belongsTo(Specialty::class, 'minor_id', 'id')->withDefault([
      'specialty' . session('_lang') => __('N/A')
    ]);
  }

  public function academicRank()
  {
    return $this->belongsTo(AcademicRank::class)->withDefault([
      'rank' . session('_lang') => __('N/A')
    ]);
  }

  public function professionalRank()
  {
    return $this->belongsTo(ProfessionalRank::class)->withDefault([
      'rank' . session('_lang') => __('N/A')
    ]);
  }

  public function appointment()
  {
    return $this->belongsTo(AppointmentStatus::class, 'appointment_type_id', 'id')->withDefault([
      'appointment_type' . session('_lang') => __('N/A')
    ]);
  }

  public function employment()
  {
    return $this->belongsTo(EmploymentStatus::class, 'employment_status_id', 'id')->withDefault([
      'employment_status' . session('_lang') => __('N/A')
    ]);
  }

  public function jobType()
  {
    return $this->belongsTo(JobType::class, 'job_type_id', 'id')->withDefault([
      'job_type' . session('_lang') => __('N/A')
    ]);
  }

  public function accommodation()
  {
    return $this->belongsTo(AccommodationStatus::class, 'accommodation_status_id', 'id')->withDefault([
      'accommodation_status' . session('_lang') => __('N/A')
    ]);
  }

  public function attachment(){
    return $this->morphOne(Attachment::class, 'attachmentable');
  }
}
