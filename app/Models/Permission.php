<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\PermissionDetail;
use App\Models\Tables\WorkflowStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'permissions';

  protected $fillable = [
    'user_id', 'permission_type', 'date', 'from', 'to', 'status_id'
  ];

  protected $appends = ['hours'];

  public function getHoursAttribute()
  {
    return $this->hours();
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function type()
  {
    return $this->belongsTo(PermissionType::class, 'permission_type', 'id');
  }

  public function status()
  {
    return $this->belongsTo(WorkflowStatus::class, 'status_id', 'code');
  }


  public function detail()
  {
    return $this->hasOne(PermissionDetail::class);
  }

  public function attachment()
  {
    return $this->morphOne(Attachment::class, 'attachmentable');
  }

  public function hours()
  {
    $start = Carbon::parse($this->from);
    $end = Carbon::parse($this->to);
    $diff = $end->floatDiffInHours($start);
    return $diff;
  }
}
