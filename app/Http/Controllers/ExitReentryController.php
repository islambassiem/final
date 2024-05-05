<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ExitReentry;
use Illuminate\Http\Request;
use App\Models\Admin\PayDeduct;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Admin\Salaries\OpenMonth;

class ExitReentryController extends Controller
{

  use OpenMonth;

  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('reentry.index', [
      'visas' => ExitReentry::where('user_id', auth()->user()->id)->get()
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'from' => 'date|before:to',
      'to' => 'date|after:from',
      'deduction' => Rule::requiredIf($this->check($request->from, $request->to))
    ], [
      'from.date' => __('The departure date is invalid'),
      'from.before' => __('The departure date must be before the return date'),
      'to.date' => __('The return date is invalid'),
      'to.after' => __('The return date must be after the departure date'),
      'deduction.required' => __('Kindly agree to the deduction for extra days')
    ]);
    $validated['user_id'] = auth()->user()->id;
      if(isset($validated['deduction'])){
        if($validated['deduction'] == "on"){
          $validated['deduction'] = $this->check($request->from, $request->to) > 60 ? "1" : '0';
        }
      }
    ExitReentry::create($validated);
    if($this->noOfDays($request->from, $request->to) > 60)
    {
      $month  = $this->openMonth();
      $amount = (ceil($this->noOfDays($request->from, $request->to) / 30) - 2 ) * 100 ;
      PayDeduct::insert([
        'user_id' => auth()->user()->id,
        'month_id' => $month->id,
        'amount' => $amount,
        'description' => 'Exit Re-entry Extra amount',
        'type' => '0',
        'code' => '1533',
        'created_at' => now(),
        'updated_at' => now()
      ]);
    }
    return redirect()->route('reentry.index')->with('success', __('You have applied for an exit re-entry visa successfully'));
  }

  private function check($from, $to)
  {
    $start = Carbon::parse($from);
    $end = Carbon::parse($to);
    $diff = $end->diffInDays($start) + 1;
    return $diff > 60 ? true : false;
  }

  private function noOfDays($from, $to)
  {
    $start = Carbon::parse($from);
    $end = Carbon::parse($to);
    return  $end->diffInDays($start) + 1;
  }
}