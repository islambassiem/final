<?php

namespace App\Models\LookUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
  use HasFactory;

  protected $table = '_sponsorships';

  protected $fillable = [
    'sponsorship_en', 'sponsorship_ar', 'code'
  ];
}
