<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\PayslipTrait;
use App\Http\Requests\PayslipRequest;

class PayslipController extends Controller
{
  use PayslipTrait;

  public function __construct()
  {
    return  $this->middleware('auth');
  }

  public function index(PayslipRequest $request)
  {
    $data = $this->data($request);

    if($this->date->lessThan(Carbon::parse($this->user->joining_date)))
      return redirect()->back()->with('error', __('payslip.error'));

    if ($request->view == null)
      return view('salary.payslip', $data);
    else
      return view($request->view, $data);
  }
}
