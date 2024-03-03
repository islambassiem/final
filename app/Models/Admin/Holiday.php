<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
  use HasFactory;

  protected $table = 'holidays';

  protected $fillable = [
    'from', 'to', 'description', 'branch_id', 'user_id'
  ];

  public function branch()
  {
    return $this->belongsTo(Branch::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function days()
  {
    $start = Carbon::parse($this->from);
    $end = Carbon::parse($this->to);
    return $end->diffInDays($start) + 1;
  }

}
