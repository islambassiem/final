<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sgr extends Model
{
    use HasFactory;

    protected $table = 'sgrs';

    protected $fillable = [
        'name_ar',
        'name_en',
    ];
}
