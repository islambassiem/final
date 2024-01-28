<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payslip;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class PayslipController extends Controller
{

  private $month;
  private $year;

  public function __construct()
  {
    return  $this->middleware('auth');
  }

  public function index()
  {
    // $payslip = Payslip::with('month', 'user')
    //   ->where('user_id', auth()->user()->id)
    //   ->where('month_id')
    //   ->get();
    return view('salary.payslip');
  }

  public function test($start = null, $end = null)
  {
    $start = '2023-12-19';
    $end = '2024-01-20';
    $vacations = Vacation::where('start_date' , '<=', $end)
      ->where('end_date', '>=', $start)
      ->where('status_id', '1')
      ->get()
      ->map(function(Vacation $vacation) use($start, $end){
        $vacation->start_date = $vacation->start_date <= $start ? $vacation->start_date = $start : $vacation->start_date;
        $vacation->end_date = $vacation->end_date >= $end ? $vacation->end_date = $end : $vacation->end_date;
        return $vacation;
      })
      ->groupBy(['user_id', 'vacation_type'])
      ->map(function($type){
        return $type->map(function($item){
          $total = $item->sum('days');
					return $total >= 30 ? 30 :  $total;
        });
      });
    return $vacations;
  }
}
