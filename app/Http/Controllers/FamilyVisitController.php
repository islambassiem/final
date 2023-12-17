<?php

namespace App\Http\Controllers;

use App\Models\FamilyVisit;
use Illuminate\Http\Request;

class FamilyVisitController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }
  
  public function index()
  {
    return view('visits.index', [
      'visits' => FamilyVisit::where('user_id', auth()->user()->id)->get()
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'number' => 'required|numeric|max:9999999999',
      'deduction' => 'accepted'
    ], [
      'number.required' => __('The request number is required'),
      'number.max' => __('The maximum allowed characters is 10 characters'),
      'number.numeric' => __('The request number is invalid'),
      'deduction.accepted' => __('Please agree to fees deduction')
    ]);
    $validated['user_id'] = auth()->user()->id;
    $validated['deduction'] = $validated['deduction'] == "on" ? '1' : '0';
    FamilyVisit::create($validated);
    return redirect()->route('visits.index')->with('success', __('You have applied for a family visit successfully'));
  }
}
