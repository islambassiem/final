<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tables\Country;
use App\Models\Tables\ResearchType;
use App\Models\Tables\ResearchDomain;
use App\Models\Tables\ResearchNature;
use App\Models\Tables\ResearchStatus;
use App\Models\Tables\ResearchLanguage;
use App\Models\Tables\ResearchProgress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Research extends Model
{
  use HasFactory;

  protected $table = 'research';

  protected $fillable = [
    'user_id', 'type_id', 'status_id', 'progress_id', 'nature_id', 'domain_id',
    'category_code', 'title', 'publishing_date', 'publisher', 'isbn', 'magazine',
    'edition', 'publication_location', 'summary', 'lang_id', 'publishing_url',
    'key_words', 'pages_number'
  ];

  public function user(){
    return $this->belongsTo(User::class);
  }

  public function type(){
    return $this->belongsTo(ResearchType::class, 'type_id', 'id');
  }

  public function status(){
    return $this->belongsTo(ResearchStatus::class, 'status_id', 'id');
  }

  public function progress(){
    return $this->belongsTo(ResearchProgress::class, 'progress_id', 'id');
  }

  public function nature(){
    return $this->belongsTo(ResearchNature::class, 'nature_id', 'id');
  }

  public function domain(){
    return $this->belongsTo(ResearchDomain::class, 'domain_id', 'id');
  }

  public function location(){
    return $this->belongsTo(Country::class, 'publication_location', 'id');
  }

  public function language(){
    return $this->belongsTo(ResearchLanguage::class, 'lang_id', 'id');
  }
}