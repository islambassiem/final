<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\TransportationDeduction;
use App\Models\Bank;
use App\Models\Ticket;
use App\Models\Tables\Gender;
use App\Models\Tables\Country;
use App\Models\Tables\Section;
use App\Models\Tables\Category;
use App\Models\Tables\Position;
use App\Models\Tables\Religion;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Tables\SpecialNeed;
use App\Models\Tables\Sponsorship;
use App\Models\Tables\MaritalStatus;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'empid', 'email', 'email_verified_at', 'password', 'remember_token', 'head',
    'first_name_en', 'middle_name_en', 'third_name_en', 'family_name_en',
    'first_name_ar', 'middle_name_ar', 'third_name_ar', 'family_name_ar',
    'gender_id', 'nationality_id', 'religion_id', 'date_of_birth',
    'place_of_birth_id', 'marital_status_id', 'joining_date',
    'resignation_date', 'position_id', 'sponsorship_id', 'section_id',
    'category_id', 'active', 'salary', 'fingerprint', 'saturday', 'cost_center',
    'married_contract', 'vacation_class', 'notes', 'special_need_id',
    'home_country_id', 'created_by', 'updated_by'
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
    $path = 'storage/profile/' . auth()->user()->empid . '.jpeg';
    if(file_exists($path)){
      return asset($path);
    }
    return 'storage/profile/default.jpeg';
  }

  public function employeePicture(string $empid)
  {
    $path = 'storage/profile/' . $empid . '.jpeg';
    if(file_exists($path)){
      return asset($path);
    }
    return asset('storage/profile/default.jpeg');
  }

  public function name()
  {
    return ucwords($this->first_name_en) . ' ' . ucwords($this->family_name_en);
  }

  public function getFullEnglishNameAttribute(): Attribute
  {
    return new Attribute(
      get: fn () => $this->first_name_en . ' ' . $this->middle_name_en . ' ' . $this->third_name_en . ' ' . $this->family_name_en,
    );
  }

  public function getFullArabicNameAttribute(): Attribute
  {
    return new Attribute(
      get: fn () => $this->first_name_ar . ' ' . $this->middle_name_ar . ' ' . $this->third_name_ar . ' ' . $this->family_name_ar,
    );
  }

  public function firstNameEn(): Attribute
  {
    return Attribute::make(
      set: fn (string $value) => ucfirst(strtolower($value)),
      get: fn(string $value)  => ucfirst(strtolower($value))
    );
  }

  public function middleNameEn(): Attribute
  {
    return Attribute::make(
      set: fn (?string $value = null) => ucfirst(strtolower($value)),
      get: fn(?string $value = null)  => ucfirst(strtolower($value))
    );
  }

  public function thirdNameEn(): Attribute
  {
    return Attribute::make(
      set: fn (?string $value = null) => ucfirst(strtolower($value)),
      get: fn(?string $value = null)  => ucfirst(strtolower($value))
    );
  }

  public function familyNameEn(): Attribute
  {
    return Attribute::make(
      set: fn (string $value) => ucfirst(strtolower($value)),
      get: fn(string $value)  => ucfirst(strtolower($value))
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

  public function maritalStatus(){
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
    return $this->belongsTo(Category::class);
  }

  public function specialNeed(){
    return $this->belongsTo(SpecialNeed::class);
  }

  public function mobile($user)
  {
    return Contact::where('user_id', $user)->where('type', '1')->first()?->contact;
  }

  public function email($user)
  {
    return Contact::where('user_id', $user)->where('type', '2')->first()?->contact;
  }

  public function extension(string $user_id)
  {
    return Contact::where('user_id', $user_id)->where('type', '3')->first()?->contact;
  }

  public function vacations(){
    return $this->hasMany(Vacation::class);
  }

  public function leaves(){
    return $this->hasMany(Leave::class);
  }

  public function basic(string $user_id){
    return Salary::where('user_id', $user_id)->orderByDesc('effective')->first()->getBasicAttribute();
  }

  public function housing(string $user_id){
    return Salary::where('user_id', $user_id)->orderByDesc('effective')->first()->getHousingAttribute();
  }

  public function transportation(string $user_id){
    return Salary::where('user_id', $user_id)->orderByDesc('effective')->first()->getTransportationAttribute();
  }

  public function food(string $user_id){
    return Salary::where('user_id', $user_id)->orderByDesc('effective')->first()->getFoodAttribute();
  }

  public function ticket(string $user_id){
    $ticket = Ticket::where('user_id', $user_id)?->orderByDesc('effective')->first();
    return isset($ticket) ? $ticket->getTicketAttribute() : number_format(0, 2);
  }

  public function tickets()
  {
    return $this->hasMany(Ticket::class);
  }

  public function latestSalary(string $user_id){
    return Salary::where('user_id', $user_id)->orderByDesc('effective')->first()->package();
  }

  public function iqama(string $user_id){
    return Document::where('user_id', $user_id)->where('document_type_id', '1')->first();
  }

  public function passport(string $user_id){
    return Document::where('user_id', $user_id)->where('document_type_id', '2')->first();
  }

  public function bank(string $user_id){
    return Bank::where('user_id', $user_id)->first();
  }

  public function ats(){
    return $this->hasOne(Ats::class);
  }

  public function dependents()
  {
    return $this->hasMany(Dependent::class);
  }

  public function salaries()
  {
    return $this->hasMany(Salary::class);
  }

  public function transportationDeduction()
  {
    return $this->hasMany(TransportationDeduction::class);
  }
}