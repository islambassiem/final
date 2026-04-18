<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zkbiotime extends Model
{
    use HasFactory;

    protected $table = 'zkbiotime';

    protected $fillable = ['empid', 'transaction'];
}
