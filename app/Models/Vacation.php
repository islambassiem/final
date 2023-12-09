<?php

namespace App\Models;

use App\Models\Tables\VacationType;
use App\Models\Tables\WorkflowStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacation extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'vacations';

  protected $fillable = [
    'user_id', 'vacation_type', 'start_date', 'end_date', 'status_id'
  ];

  protected $appends = ['days'];

  public function getDaysAttribute()
  {
    return $this->days();
  }

  public function type()
  {
    return $this->belongsTo(VacationType::class, 'vacation_type', 'id');
  }

  public function status()
  {
    return $this->belongsTo(WorkflowStatus::class, 'status_id', 'code');
  }

  public function attachment()
  {
    return $this->morphOne(Attachment::class, 'attachmentable');
  }

  public function detail()
  {
    return $this->hasOne(VacationDetail::class);
  }

  public function days()
  {
    $start = Carbon::parse($this->start_date);
    $end = Carbon::parse($this->end_date);
    return $end->diffInDays($start) + 1;
  }
}
