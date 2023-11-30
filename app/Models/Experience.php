<?php

namespace App\Models;

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
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
  use HasFactory;

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
    return $this->belongsTo(EducationalInstitution::class, 'institution_id', 'id');
  }

  public function college()
  {
    return $this->belongsTo(College::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function section()
  {
    return $this->belongsTo(AcademicSection::class);
  }

  public function major()
  {
    return $this->belongsTo(Specialty::class, 'major_id', 'id');
  }

  public function minor()
  {
    return $this->belongsTo(Specialty::class, 'minor_id', 'id');
  }

  public function academicRank()
  {
    return $this->belongsTo(AcademicRank::class);
  }

  public function professionalRank()
  {
    return $this->belongsTo(ProfessionalRank::class);
  }

  public function appointment()
  {
    return $this->belongsTo(AppointmentStatus::class, 'appointment_type_id', 'id');
  }

  public function employment()
  {
    return $this->belongsTo(EmploymentStatus::class, 'employment_status_id', 'id');
  }

  public function jobType()
  {
    return $this->belongsTo(JobType::class, 'job_type_id', 'id');
  }

  public function accommodation()
  {
    return $this->belongsTo(AccommodationStatus::class, 'accommodation_status_id', 'id');
  }
}
