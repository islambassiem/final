<?php

namespace App\Http\Controllers;

use App\Models\Acquaintance;
use Illuminate\Http\Request;
use App\Http\Requests\AcquaintanceRequest;

class AcquaintanceController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('acquaintance.index', [
      'acquaintances' => Acquaintance::where('user_id', auth()->user()->id)->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(AcquaintanceRequest $request)
  {
    $validated = $request->validated();
    $validated['user_id'] = auth()->user()->id;
    Acquaintance::create($request->validated());
    return redirect()->route('acquaintances.index')->with('success', __('You have added an acquaintance successfully'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Acquaintance $acquaintance)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Acquaintance $acquaintance)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(AcquaintanceRequest $request, Acquaintance $acquaintance)
  {
    $acquaintance->update($request->validated());
    return redirect()->route('acquaintances.index')->with('success', __('You have updated the acquaintance successfully'));
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Acquaintance $acquaintance)
  {
    $acquaintance->delete();
    return redirect()->route('acquaintances.index')->with('success', __('You have deleted the acquaintance successfully'));
  }
}
