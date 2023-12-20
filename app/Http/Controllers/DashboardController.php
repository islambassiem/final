<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
      'balance' => $this->balance()
    ]);
  }

  private function availedVacationThisMonth()
  {
    $start = Carbon::now()->startOfMonth()->format('Y-m-d');
    $end = Carbon::now()->endOfMonth()->format('Y-m-d');
    return $this->availedInDuration($start, $end);
  }

  private function availedVacationThisYear()
  {
    $start = Carbon::now()->startOfYear()->format('Y-m-d');
    $end = Carbon::now()->endOfYear()->format('Y-m-d');
    return $this->availedInDuration($start, $end);
  }

  private function availedInDuration($start, $end)
  {
    $vacations = Vacation::where('user_id', auth()->user()->id)
    ->where('status_id', '1')
    ->where('start_date', '<=', $end)
    ->where('end_date', '>=', $start)
    ->get();
    $total = 0;
    foreach ($vacations as $vacation) {
      if($vacation->start_date >= $start){
        $start_date = $vacation->start_date;
        if($vacation->end_date >= $end){
          $end_date = $end;
        }else{
          $end_date = $vacation->end_date;
        }
      }else{
        $start_date = $start;
        if($vacation->end_date <= $end){
          $end_date = $vacation->end_date;
        }else{
          $end_date = $end;
        }
      }
      $diff = Carbon::parse($end_date)->diffIndays(Carbon::parse($start_date)) + 1;
      $total += $diff;
    }
    return $total ;
  }
}
