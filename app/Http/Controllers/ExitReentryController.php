<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ExitReentry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExitReentryController extends Controller
{
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
    ExitReentry::create($validated);
    return redirect()->route('reentry.index')->with('success', __('You have applied for an exit re-entry visa successfully'));
  }

  private function check($from, $to)
  {
    $start = Carbon::parse($from);
    $end = Carbon::parse($to);
    $diff = $end->diffInDays($start) + 1;
    return $diff > 60 ? true : false;
  }
}