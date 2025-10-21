<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurnaceClass extends Model
{
    use HasFactory;

    protected $fillalbe = [
      'name_en',
      'name_ar',
    ];
}
