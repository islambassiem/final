<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportation;
use Carbon\Carbon;

class TransportationController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('transportation.index', [
      'requests' => Transportation::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get()
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'destination' => 'required|string|max:255',
      'date' => 'required|date_format:Y-m-d|after:' . (Carbon::parse(Carbon::now()))->subDay(),
      'from' => 'required|date_format:H:i|before:to',
      'to' => 'required|date_format:H:i|after:from',
      'passengers' => 'required|numeric',
      'notes' => 'nullable|string|max:255'
    ], [
      'destination.required' => __('You need to mention the destination you are heading to'),
      'destination.string' => __('The destination you\'ve entered is invalid'),
      'destination.max' => __('The destination you\'ve entered is invalid'),
      'date.required' => __('You need to specify the trip\'s date'),
      'date.after' => __('The date is invalid'),
      'date.min' => __('You cannot apply retrospectively'),
      'from.required' => __('The start date of the trip is required'),
      'from.before' => __('The start time cannot be after the end time'),
      'to.required' => __('The end date of the trip is required'),
      'to.after' => __('The end time cannot be before the start time'),
      'passengers.required' => __('The number of passengers is required'),
    ]);
    $validated['user_id'] = auth()->user()->id;
    Transportation::create($validated);
    return redirect()->route('transportation.index')->with('success', 'Your request has been sent!');
  }
}
