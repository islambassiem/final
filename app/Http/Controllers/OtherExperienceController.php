<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tables\Country;
use App\Models\OtherExperience;
use App\Http\Requests\OtherExperienceRequest;

class OtherExperienceController extends Controller
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
    return view('otherExperience.index', [
      'experiences' => OtherExperience::where('user_id', auth()->user()->id)->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('otherExperience.create', [
      'countries' => Country::all()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(OtherExperienceRequest $request)
  {
    $validated = $request->validated();
    $validated['user_id'] =  auth()->user()->id;
    OtherExperience::create($validated);
    return redirect()->route('other_experience.index')->with('success', __('You have added an experience outside KSA successfully'));
  }

  /**
   * Display the specified resource.
   */
  public function show(OtherExperience $otherExperience)
  {
    return view('otherExperience.show', [
      'experience' => $otherExperience
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(OtherExperience $otherExperience)
  {
    return view('otherExperience.edit', [
      'experience' => $otherExperience,
      'countries' => Country::all()
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(OtherExperienceRequest $request, OtherExperience $otherExperience)
  {
    $otherExperience->update($request->validated());
    return redirect()->route('other_experience.index')->with('success', __('You have updated the experience outside KSA successfully'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(OtherExperience $otherExperience)
  {
    $otherExperience->delete();
    return redirect()->route('other_experience.index')->with('success', __('You have deleted the experience outside KSA successfully'));
  }
}
