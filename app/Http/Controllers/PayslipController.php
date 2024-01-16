<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payslip;

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
}
