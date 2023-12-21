<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Document;
use App\Models\Vacation;
use Illuminate\Http\Request;
use App\Traits\VacationTrait;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  use VacationTrait;
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('dashboard', [
      'availedMonth' => $this->availedVacationThisMonth(),
      'availedYear' => $this->availedVacationThisYear(),
      'balance' => $this->balance(),
      'leaveMonth' => $this->AvailedLeaveThisMonth(),
      'leaveYear' => $this->AvailedLeaveThisYear(),
      'documents' => $this->documents(),
    ]);
  }

  private function documents()
  {
    return Document::where('user_id', auth()->user()->id)->orderBy('id')->get();
  }

  private function availedVacationThisMonth()
  {
    $start = Carbon::now()->startOfMonth()->format('Y-m-d');
    $end = Carbon::now()->endOfMonth()->format('Y-m-d');
    return $this->availedInDuration($start, $end);
  }

  private function AvailedLeaveThisMonth()
  {
    $start = Carbon::now()->startOfMonth()->format('Y-m-d');
    $end = Carbon::now()->endOfMonth()->format('Y-m-d');
    return $this->availedLeaveInDurtion($start, $end);
  }

  private function AvailedLeaveThisYear()
  {
    $start = Carbon::now()->startOfYear()->format('Y-m-d');
    $end = Carbon::now()->endOfYear()->format('Y-m-d');
    return $this->availedLeaveInDurtion($start, $end);
  }

  private function availedLeaveInDurtion($start, $end)
  {
    $leaves = Leave::where('user_id', auth()->user()->id)
      ->where('leave_type', 1)
      ->where('date', '>=', $start)
      ->where('date', '<=', $end)
      ->get();
    $total = 0;
    foreach ($leaves as $leave) {
      $from = Carbon::parse($leave->from);
      $to = Carbon::parse($leave->to);
      $diff = $to->diffInMinutes($from);
      $total += $diff;
    }
    return round($total / 60 , 0);
  }
}
