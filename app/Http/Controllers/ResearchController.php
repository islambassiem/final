<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;
use App\Models\Tables\Country;
use App\Models\Tables\ResearchType;
use App\Models\Tables\ResearchDomain;
use App\Models\Tables\ResearchNature;
use App\Models\Tables\ResearchStatus;
use App\Models\Tables\ResearchLanguage;
use App\Models\Tables\ResearchProgress;
use App\Http\Requests\ResearchRequest;
use App\Models\Tables\CitationType;
use Illuminate\Support\Facades\Storage;

class ResearchController extends Controller
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
    return view('research.index', [
      'research' => Research::where('user_id', auth()->user()->id)->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('research.create', [
      'type' => ResearchType::all(),
      'status' => ResearchStatus::all(),
      'progress' => ResearchProgress::all(),
      'nature' => ResearchNature::all(),
      'domain' => ResearchDomain::all(),
      'location' => Country::all(),
      'language' => ResearchLanguage::all(),
      'citations' => CitationType::all()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ResearchRequest $request)
  {
    if($request->has('title') && $request->title != null){
      Storage::disk('public')->put(auth()->user()->id . '/text/research_title.txt', $request->title);
    }
    if($request->has('research_summary') && $request->research_summary != null){
      Storage::disk('public')->put(auth()->user()->id . '/text/research_summary.txt', $request->summary);
    }
    $validated = $request->validated();
    $validated['user_id'] =  auth()->user()->id;
    $validated['title'] = strip_tags($request->title);
    $validated['summary'] = strip_tags($request->summary);
    Research::create($validated);
    return redirect()->route('research.index')->with('success', __('You have added research successfully'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Research $research)
  {
    return view('research.show', [
      'research' => $research
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Research $research)
  {
    return view('research.edit', [
      'research' => $research,
      'type' => ResearchType::all(),
      'status' => ResearchStatus::all(),
      'progress' => ResearchProgress::all(),
      'nature' => ResearchNature::all(),
      'domain' => ResearchDomain::all(),
      'location' => Country::all(),
      'language' => ResearchLanguage::all(),
      'citations' => CitationType::all()
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ResearchRequest $request, Research $research)
  {
    Storage::disk('public')->put(auth()->user()->id . '/text/research_title.txt', $request->title);
    Storage::disk('public')->put(auth()->user()->id . '/text/research_summary.txt', $request->summary);
    $validated = $request->validated();
    $validated['user_id'] =  auth()->user()->id;
    $validated['title'] = strip_tags($request->title);
    $validated['summary'] = strip_tags($request->summary);
    $research->update($request->validated());
    return redirect()->route('research.index')->with('success', __('You have updated research successfully'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Research $research)
  {
    $research->delete();
    return redirect()->route('research.index')->with('success', __('You have deleted the research successfully'));
  }
}
