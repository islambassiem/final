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
}
