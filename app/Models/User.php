<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\LookUps\Country;
use App\Models\LookUps\Gender;
use App\Models\LookUps\MaritalStatus;
use App\Models\LookUps\Position;
use App\Models\LookUps\Religion;
use App\Models\LookUps\Section;
use App\Models\LookUps\SpecialNeeds;
use App\Models\LookUps\Sponsorship;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPUnit\Framework\Constraint\Count;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'email','password', 'empid', 'head',
    'first_name_en', 'middle_name_en', 'third_name_en', 'family_name_en',
    'first_name_ar', 'middle_name_ar', 'third_name_ar', 'family_name_ar',
    'gender', 'nationality', 'religion', 'date_of_birth', 'place_of_birth', 'marital_status',
    'joining_date', 'resignation_date', 'position', 'sponsorship', 'section', 'category',
    'active', 'salary', 'fingerprint', 'saturday', 'cost_center', 'married_contract',
    'vacation_class', 'notes', 'special_need', 'home_country_id', 'created_by', 'updated_by'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];


  public function picture(){
    $path = 'assets/imgs/profile/' . auth()->user()->empid . '.jpeg';
    if(file_exists($path)){
      return asset($path);
    }
    return 'assets/imgs/profile/default.jpeg';
  }

  public function full_name_en(): Attribute
  {
    return new Attribute(
      get: fn () => ucwords($this->first_name_en . ' ' . $this->middle_name_en . ' ' . $this->third_name_en . ' ' . $this->family_name_en),
    );
  }

  public function full_name_ar(): Attribute
  {
    return new Attribute(
      get: fn () => $this->first_name_ar . ' ' . $this->middle_name_ar . ' ' . $this->third_name_ar . ' ' . $this->family_name_ar,
    );
  }

  public function first_name_en(): Attribute
  {
    return new Attribute(
      set: fn (string $value) => strtolower($value),
      get: fn(string $value)  => ucfirst($value)
    );
  }

  public function middle_name_en(): Attribute
  {
    return new Attribute(
      set: fn (string $value) => strtolower($value),
      get: fn(string $value)  => ucfirst($value)
    );
  }

  public function third_name_en(): Attribute
  {
    return new Attribute(
      set: fn (string $value) => strtolower($value),
      get: fn(string $value)  => ucfirst($value)
    );
  }

  public function family_name_en(): Attribute
  {
    return new Attribute(
      set: fn (string $value) => strtolower($value),
      get: fn(string $value)  => ucfirst($value)
    );
  }

  public function gender()
  {
    return $this->belongsTo(Gender::class);
  }

  public function nationality(){
    return $this->belongsTo(Country::class);
  }

  public function religion(){
    return $this->belongsTo(Religion::class);
  }

  public function placeOfBirth(){
    return $this->belongsTo(Country::class);
  }

  public function MaritalStatus(){
    return $this->belongsTo(MaritalStatus::class);
  }

  public function position(){
    return $this->belongsTo(Position::class);
  }

  public function sponsorship(){
    return $this->belongsTo(Sponsorship::class);
  }

  public function section(){
    return $this->belongsTo(Section::class);
  }

  public function category(){
    return $this->belongsTo(category::class);
  }

  public function SpecialNeed(){
    return $this->belongsTo(SpecialNeeds::class);
  }
}