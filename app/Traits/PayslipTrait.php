<?php

namespace App\Traits;

use App\Http\Requests\PayslipRequest;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Salary;
use App\Models\Admin\Month;
use App\Models\Admin\PayDeduct;
use App\Models\Admin\WorkingDays;
use App\Models\Tables\VacationType;
use App\Models\Admin\NonWorkingDays;

trait PayslipTrait{

  private string $month;
  private string $year;
  private Carbon $date;
  private User $user;
  private string $month_id;

  public function index($user_id, $month, $year){
    $this->user = User::find($user_id);
    $this->month = $month;
    $this->year = $year;
    $this->date = Carbon::create($this->year, $this->month)->endofMonth();
    $this->month_id = Month::where('month', $this->month)->where('year', $this->year)->first('id')->id;
    return floatval(str_replace(",", "", $this->net()));
  }


  private function data(PayslipRequest $request)
  {
    $this->user = $request->user_id == null ? User::find(auth()->user()->id) : User::find($request->user_id);
    $this->month = $request->month;
    $this->year = $request->year;
    $this->date = Carbon::create($this->year, $this->month)->endofMonth();
    $this->month_id = Month::where('month', $this->month)->where('year', $this->year)->first('id')->id;

    $data = [
      'user' => $this->user,
      'annual' => $this->noOfDays(['1']),
      'sick' => $this->noOfDays(['2']),
      'absent' => $this->noOfDays(['3']),
      'unpaid' => $this->noOfDays(['4']),
      'maternity' => $this->noOfDays(['5']),
      'paternity' => $this->noOfDays(['6']),
      'study' => $this->noOfDays(['7']),
      'pilgrimage' => $this->noOfDays(['8']),
      'death' => $this->noOfDays(['9']),
      'marriage' => $this->noOfDays(['10']),
      'other' => $this->noOfDays(['11']),
      'business' => $this->noOfDays(['12']),
      'paidDays' => $this->noOfDays($this->paidDaysIds()),
      'paidDaysAmount' => $this->paidDaysAmount(),
      'unpaidDays' => $this->noOfDays($this->unpaidDaysIds()),
      'unpaidDaysAmount' => $this->unpaidDaysAmount(),
			'workingDays' => $this->workingDays(),
      'workingDaysAmount' => $this->workingDaysAmount(),
      'date' => Carbon::create($this->year, $this->month)->endofMonth()->format('Y-m-d'),
      'month' => $this->date,
      'month_id' => $this->month_id,
      'salary' => $this->salary(),
      'package' => number_format($this->package(), 2),
      'start_date' => $this->startDate(),
      'end_date' => $this->endDate(),
      'payables' => $this->payables(),
      'deductables' => $this->deductables(),
      'net' => $this->net(),
    ];
    return $data;
  }

  private function startDate()
  {
    return Carbon::parse(Month::find($this->month_id)->start_date)->format('j/m/Y');
  }

  private function endDate()
  {
    return Carbon::parse(Month::find($this->month_id)->end_date)->format('j/m/Y');
  }

  private function net()
  {
    $payables = $this->floatval($this->workingDaysAmount())
      + $this->floatval($this->paidDaysAmount())
      + $this->floatval($this->payablesAmount());
    $deductables = $this->floatval($this->deductablesAmount());
    return number_format(round($payables - $deductables, 0), 2);
  }

  private function noOfDays($type = [])
  {
    $days = NonWorkingDays::where('user_id', $this->user->id)
      ->where('month_id', $this->month_id)
      ->when($type != [], function($q) use($type){
        $q->whereIn('type', $type);
      })
      ->sum('days');
    return $days;
  }

  private function workingDaysAmount()
  {
    return number_format($this->workingDays() * $this->package() / 30 , 2);
  }

  private function paidDaysAmount()
  {
    return number_format($this->noOfDays($this->paidDaysIds()) * $this->package() / 30 , 2);
  }

  private function unpaidDaysAmount()
  {
    return number_format($this->noOfDays($this->unpaidDaysIds()) * $this->package() / 30, 2);
  }

  private function package()
  {
    return $this->floatval($this->salary()->package());
  }

  private function floatval(string $string) :float
  {
    return floatval(str_replace(',', '', $string));
  }

  private function payables()
  {
    return PayDeduct::where('user_id', $this->user->id)
    ->where('month_id', $this->month_id)
    ->where('type', '1')
    ->get(['amount', 'description']);
  }

  private function payablesAmount()
  {
    return PayDeduct::where('user_id', $this->user->id)
    ->where('month_id', $this->month_id)
    ->where('type', '1')
    ->sum('amount');
  }

  private function deductables()
  {
    return PayDeduct::where('user_id', $this->user->id)
    ->where('month_id', $this->month_id)
    ->where('type', '0')
    ->get(['amount', 'description']);
  }

  private function deductablesAmount()
  {
    return PayDeduct::where('user_id', $this->user->id)
    ->where('month_id', $this->month_id)
    ->where('type', '0')
    ->sum('amount');
  }

  private function paidDaysIds()
  {
    $paidDaysIDs = [];
    $ids = VacationType::whereNotIn('id', ['3', '4'])->get('id');
    foreach ($ids as $id) {
      $paidDaysIDs[] = $id->id;
    }
    return $paidDaysIDs;
  }

  private function unpaidDaysIds()
  {
    $unpaidDaysIDs = [];
    $ids = VacationType::whereIn('id', ['3', '4'])->get('id');
    foreach ($ids as $id) {
      $unpaidDaysIDs[] = $id->id;
    }
    return $unpaidDaysIDs;
  }

	private function workingDays()
	{
    $month_id = Month::where('month', $this->month)->where('year', $this->year)->first()->id;
    $workingDays =  WorkingDays::where('user_id',  $this->user->id)
      ->where('month_id', $month_id)
      ->first('working_days');
    return $workingDays == null ? 0 : $workingDays->working_days;
	}

  private function salary()
  {
    return Salary::where('user_id', $this->user->id)
    ->where('effective', '<=', $this->date)
    ->orderByDesc('effective')
    ->first();
  }

  public function getMonth($year)
  {
    $months = Month::where('year',  $year)->where('status', '1')->orderByDesc('start_date')->get('month');
    return json_encode($months);
  }
}