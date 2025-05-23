<?php

namespace App\Http\Controllers\Admin\Salaries;

use App\Models\User;
use App\Models\Salary;
use App\Models\Admin\Month;
use App\Traits\SalaryTrait;
use Illuminate\Http\Request;
use App\Models\Admin\PayDeduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditPayableRequest;
use App\Http\Requests\EditDeductableRequest;
use App\Http\Requests\Admin\Salaries\PayDeductRequest;

class PayDeductController extends Controller
{
  use SalaryTrait;

  public function payables($month_id)
  {
    $payables = PayDeduct::with('user')
      ->where('month_id', $month_id)
      ->where('type', '1')
      ->get();
    $users = User::where('active', '1')
      ->where('salary', '1')
      ->get();
    $month = Month::find($month_id);
    return view('admin.salaries.payables', [
      'month_id' => $month_id,
      'status' => $month->status,
      'sent' => $month->sent,
      'payables' => $payables,
      'users' => $users,
    ]);
  }

  public function storePayables(PayDeductRequest $request)
  {
    $package = $this->package($request->user_id, $this->end_date($request->month_id));
    $amount =  $this->amount($package, $request->number, $request->unit);
    $data = [
      'user_id'     => $request->user_id,
      'month_id'    => $request->month_id,
      'amount'      => $amount,
      'description' => $request->description,
      'type'        => '1',
      'code'        => '1237',
    ];
    PayDeduct::create($data);
    return redirect()->back()->with('success', __('admin/salaries.payableSuccess'));
  }


  public function editpayables(EditPayableRequest $request)
  {
    $payable = PayDeduct::find($request->id);
    $package = $this->package($payable->user_id, $this->end_date($payable->month_id));
    $amount =  $this->amount($package, $request->numberEdit, $request->unitEdit);
    $payable->amount = $amount;
    $payable->description = $request->descriptionEdit;
    $payable->save();
    return redirect()->back()->with('success', __('admin/salaries.editPayableSuccess'));
  }

  public function deductables($month_id)
  {
    $deductables = PayDeduct::with('user')
      ->where('month_id', $month_id)
      ->where('type', '0')
      ->get();
    $users = User::where('active', '1')
      ->where('salary', '1')
      ->get();
    $month = Month::find($month_id);
    return view('admin.salaries.deductables', [
      'month_id' => $month_id,
      'status' => $month->status,
      'sent' => $month->sent,
      'deductables' => $deductables,
      'users' => $users,
    ]);
  }

  public function storeDeductables(PayDeductRequest $request)
  {
    $package = $this->package($request->user_id, $this->end_date($request->month_id));
    $amount =  $this->amount($package, $request->number, $request->unit);
    $data = [
      'user_id'     => $request->user_id,
      'month_id'    => $request->month_id,
      'amount'      => $amount,
      'description' => $request->description,
      'type'        => '0',
      'code'        => '1531'
    ];
    PayDeduct::create($data);
    return redirect()->back()->with('success', __('admin/salaries.deductableSuccess'));
  }

  public function editdeductables(EditDeductableRequest $request)
  {
    $deductable = PayDeduct::find($request->id);
    $package = $this->package($deductable->user_id, $this->end_date($deductable->month_id));
    $amount =  $this->amount($package, $request->numberEdit, $request->unitEdit);
    $deductable->amount = $amount;
    $deductable->description = $request->descriptionEdit;
    $deductable->save();
    return redirect()->back()->with('success', __('admin/salaries.editDeductableSuccess'));
  }


  private function end_date($month_id)
  {
    return (Month::find($month_id))->end_date;
  }

  private function amount($package, $number, $unit)
  {
    if($unit == 'day')
    {
      return round($package * $number  / 30, 0);
    }
    if($unit == 'hour')
    {
      return round($package * $number  / 240, 0);
    }
    return $number;
  }

  public function destroydeductable(PayDeduct $deductable)
  {
    $deductable->delete();
    return redirect()->back()->with('success', __('admin/salaries.deductableDelete'));
  }

  public function destroypayable(PayDeduct $payable)
  {
    $payable->delete();
    return redirect()->back()->with('success', __('admin/salaries.payableDelete'));
  }
}
