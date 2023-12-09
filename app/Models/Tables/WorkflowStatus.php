<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowStatus extends Model
{
  use HasFactory;

  protected $table = '_workflow_status';

  protected $fillable = [
    'workflow_status_en', 'workflow_status_ar', 'code'
  ];
}
