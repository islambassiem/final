<?php

namespace App\Models;

use App\Models\Tables\WorkflowStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveDetail extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'leave_details';

  protected $fillable = [
    'leave_id',
    'employee_notes',
    'employee_time',
    'head_status',
    'head_notes',
    'head_time',
    'hr_status',
    'hr_notes',
    'hr_time',
    'action_by'
  ];

  public function  headStatus()
  {
    return $this->belongsTo(WorkflowStatus::class, 'head_status', 'code');
  }

  public function hrStatus()
  {
    return $this->belongsTo(WorkflowStatus::class, 'hr_status', 'code');
  }
}
