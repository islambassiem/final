<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use Illuminate\Http\Request;
use App\Models\Tables\FamilyRelationship;
use App\Http\Requests\DependentRequest;


class DependentController extends Controller
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
    return view('dependents.index', [
      'dependents' => Dependent::where('user_id', auth()->user()->id)->get(),
      'relationships' => FamilyRelationship::all()
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
  public function store(DependentRequest $request)
  {
    $validated = $request->validated();
    $validated['user_id'] = auth()->user()->id;
    Dependent::create($request->validated());
    return redirect()->route('dependents.index')->with('success', __('You have added a dependent successfully'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Dependent $dependent)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Dependent $dependent)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(DependentRequest $request, string $id)
  {
    $dependent = Dependent::find($id);
    $dependent->update($request->validated());
    return redirect()->route('dependents.index')
      ->with('success', 'You have updated the dependent successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Dependent $dependent)
  {
    $dependent->delete();
    return redirect()->route('dependents.index')->with('success', __('You have deleted the dependent successfully '));
  }

}
