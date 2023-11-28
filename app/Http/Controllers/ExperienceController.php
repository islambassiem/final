<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Tables\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\AcademicRank;
use App\Models\Tables\AcademicSection;
use App\Models\Tables\EmploymentStatus;
use App\Models\Tables\ProfessionalRank;
use App\Http\Requests\ExperienceRequest;
use App\Models\Tables\AppointmentStatus;
use App\Models\Tables\AccommodationStatus;
use App\Models\Tables\EducationalInstitution;

class ExperienceController extends Controller
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
    return view('experience.index', [
      'experiences' => Experience::where('user_id', auth()->user()->id)->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('experience.create', [
      'institutions' => DB::select('SELECT * FROM _educational_institutions WHERE LENGTH(`code`) = 1'),
      // 'regions' => DB::select(''),
      'cities' => City::all(),
      'sections' => AcademicSection::all(),
      'professional_ranks' => ProfessionalRank::all(),
      'academic_ranks' => AcademicRank::all(),
      'appointment_types' => AppointmentStatus::all(),
      'employment_status' => EmploymentStatus::all(),
      'accommodation_types' => AccommodationStatus::all()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ExperienceRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Experience $experience)
  {
    return view('experience.show', [
      'experience' => $experience
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Experience $experience)
  {
    return view('experience.edit', [
      'experience' => $experience
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ExperienceRequest $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Experience $experience)
  {
    $experience->delete();
    return redirect()->route('experience.index')->with('success', __('You have deleted the experience successfully'));
  }

  public function institutions($id){
    $institutions_id = DB::select('SELECT * FROM `_educational_institutions` WHERE code LIKE CONCAT(?, ?) AND LENGTH(`code`) > ?;', [$id, '%', '1']);
    return json_encode($institutions_id);
  }
}
