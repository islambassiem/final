<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payslip;
use App\Models\Vacation;
use App\Models\Admin\Month;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PayslipRequest;

class PayslipController extends Controller
{

  private $month;
  private $year;

  public function __construct()
  {
    return  $this->middleware('auth');
  }

  public function index(PayslipRequest $request, string $id = null)
  {
    $user = $id == null ? User::find(auth()->user()->id) : User::find($id);
    $userMonth = $request->month;
    $userYear = $request->year;
    $month = Month::where('month', $userMonth)
      ->where('year', $userYear)
      ->first();
    $payslip = Payslip::where('user_id', $user->id)
      ->where('month_id', $month->id)
      ->get();
    return view('salary.payslip', [
      'user' => $user,
      'month' => Carbon::create($userYear, $userMonth),
      'start_date' => Carbon::parse($month->start_date)->format('j/m/Y'),
      'end_date' => Carbon::parse($month->end_date)->format('j/m/Y'),
      'payables' => $payslip->where('transaction_type', '1'),
      'deductables' => $payslip->where('transaction_type', '0'),
    ]);
  }


  public function getMonth($year)
  {
    $months = Month::where('year',  $year)->get('month');
    return json_encode($months);
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
