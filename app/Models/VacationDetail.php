<?php

namespace App\Models;

use App\Models\Tables\WorkflowStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacationDetail extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'vacation_details';

  protected $fillable = [
    'vacation_id',
    'employee_notes',
    'employee_time',
    'head_status',
    'head_notes',
    'head_time',
    'hr_status',
    'hr_notes',
    'hr_time'
  ];

  public function headStatus()
  {
    return $this->belongsTo(WorkflowStatus::class, 'head_status', 'code');
  }

  public function hrStatus()
  {
    return $this->belongsTo(WorkflowStatus::class, 'hr_status', 'code');
  }
}
