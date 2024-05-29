<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Experience;
use App\Models\Tables\City;
use Illuminate\Http\Request;
use App\Models\Tables\College;
use App\Models\Tables\JobType;
use App\Models\Tables\Specialty;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\AcademicRank;
use App\Models\Tables\AcademicSection;
use App\Models\Tables\EmploymentStatus;
use App\Models\Tables\ProfessionalRank;
use App\Http\Requests\ExperienceRequest;
use App\Models\Tables\AppointmentStatus;
use App\Models\Tables\AccommodationStatus;
use Illuminate\Support\Facades\Storage;
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
      'regions' =>DB::select("SELECT * FROM _cities WHERE code LIKE (?)", ['0_00000']),
      'college_classification' => DB::select("SELECT * FROM _colleges WHERE LENGTH(code) = ?", ['1']),
      'department_domain' => DB::select("SELECT * FROM _academic_sections WHERE length(code)  = ?", ['1']),
      'professional_ranks' => ProfessionalRank::all(),
      'academic_ranks' => AcademicRank::all(),
      'appointment_types' => AppointmentStatus::all(),
      'employment_status' => EmploymentStatus::all(),
      'accommodation_types' => AccommodationStatus::all(),
      'job_types' => JobType::all(),
      'domains' => DB::select("SELECT * FROM _specialties WHERE LENGTH(code) = ?", ['1'])
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ExperienceRequest $request)
  {
    $validated = $request->validated();
    $validated['user_id'] =  auth()->user()->id;
    $validated['functional_tasks'] = substr(strip_tags($request->tasks),0, 500);
    Experience::create($validated);
    $latest = Experience::latest('created_at')->first();
    if($request->has('tasks') && $request->tasks != null){
      Storage::disk('public')->put(auth()->user()->id . '/text//'.$latest->id.'_experience.txt', $request->tasks);
    }
    if($request->hasFile('attachment')){
        $filepath = $request->file('attachment')->store(auth()->user()->id . '/experiences', 'public');
        $latest->attachment()->create([
          'user_id' => auth()->user()->id,
          'attachment_type' => '5',
          'link' => $filepath,
          'title' => 'experience'
        ]);
    }
    return redirect()->route('experience.index')->with('success', 'You have added your experience successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Experience $experience)
  {
    $link = $this->getLink($experience->id);
    return view('experience.show', [
      'experience' => $experience,
      'link' => $link
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Experience $experience)
  {
    return view('experience.edit', [
      'e' => $experience,
      'institutions' => DB::select('SELECT * FROM _educational_institutions WHERE LENGTH(`code`) = 1'),
      'regions' =>DB::select("SELECT * FROM _cities WHERE code LIKE (?)", ['0_00000']),
      'college_classification' => DB::select("SELECT * FROM _colleges WHERE LENGTH(code) = ?", ['1']),
      'department_domain' => DB::select("SELECT * FROM _academic_sections WHERE length(code)  = ?", ['1']),
      'professional_ranks' => ProfessionalRank::all(),
      'academic_ranks' => AcademicRank::all(),
      'appointment_types' => AppointmentStatus::all(),
      'employment_status' => EmploymentStatus::all(),
      'accommodation_types' => AccommodationStatus::all(),
      'job_types' => JobType::all(),
      'domains' => DB::select("SELECT * FROM _specialties WHERE LENGTH(code) = ?", ['1']),
      'link' => $this->getLink($experience->id),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ExperienceRequest $request, Experience $experience)
  {
    if($request->has('tasks') && $request->tasks != null){
      Storage::disk('public')->put(auth()->user()->id . '/text//'.$experience->id.'_experience.txt', $request->tasks);
    }
    $validated = $request->validated();
    $validated['user_id'] =  auth()->user()->id;
    $validated['functional_tasks'] = substr(strip_tags($request->asks), 0, 500);
    $experience->update($request->validated());
    return redirect()->route('experience.index')->with('success', 'You have updated the experience successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    Experience::find($id)->delete();
    $attachments = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\Experience')
    ->where('attachmentable_id', $id)->get();
    if($attachments){
      foreach ($attachments as $attachment) {
        $attachment->delete();
      }
    }
    return redirect()->route('experience.index')->with('success', __('You have deleted the experience successfully'));
  }

  public function institutions($id){
    $institutions_id = DB::select('SELECT * FROM `_educational_institutions` WHERE code LIKE CONCAT(?, ?) AND LENGTH(`code`) > ?;', [$id, '%', '1']);
    return json_encode($institutions_id);
  }

  public function governorate($id){
    $governorate = DB::select('SELECT * FROM _cities WHERE code LIKE CONCAT(?, ?) AND code NOT LIKE CONCAT(?, ?);', [$id, "__000", $id,"00000"]);
    return json_encode($governorate);
  }

  public function city($id){
    $cities = DB::select('SELECT * FROM _cities WHERE code LIKE CONCAT(?, ?);', [$id, '%']);
    return json_encode($cities);
  }

  public function colleges($id){
    $colleges = DB::select("SELECT * FROM _colleges WHERE`code` LIKE CONCAT(?, ?) AND LENGTH(code) > 1;", [$id, '%']);
    return json_encode($colleges);
  }

  public function department_major($id){
    $department_major = DB::select("SELECT * FROM _academic_sections WHERE `code` LIKE CONCAT(?, ?) OR `code` LIKE CONCAT(?, ?) AND LENGTH(`code`) > ?;", [$id, '%01', $id, 'Z99','1']);
    return json_encode($department_major);
  }

  public function department_minor($id){
    $code = DB::table('_academic_sections')->where('id', $id)->value('code');
    $code = substr($code, 0, 2);
    $department_minor = DB::select("SELECT * FROM _academic_sections WHERE `code` LIKE CONCAT(?, ?)", [$code, '%']);
    return json_encode($department_minor);
  }

  public function getLink(string $id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\Experience')
    ->where('attachmentable_id', $id)
    ->first('link');
    if($link){
      return "storage/" . $link->link;
    }
    return false;
  }

  public function getAttachment($id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
      ->where('attachmentable_type', 'App\Models\Experience')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return response()->download("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment; press edit icon to add one'));
  }
}
