<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\Tables\Rating;
use App\Models\Tables\Country;
use App\Models\Tables\GPATypes;
use App\Models\Tables\StudyType;
use App\Models\Tables\StudyNature;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\QualificationRequest;
use App\Models\Attachment;
use App\Models\Tables\Qualification as QualificationLookUp;

class QualificationController extends Controller
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
    return view('qualifications.index', [
      'qualifications' => Qualification::with(['major'])->where('user_id', auth()->user()->id)->get()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('qualifications.create', [
      'qualifications' => QualificationLookUp::all(),
      'study_types' => StudyType::all(),
      'study_natures' => StudyNature::all(),
      'countries' => Country::all(),
      'ratings' => Rating::all(),
      'gpa_types' => GPATypes::all(),
      'domains' => DB::select('SELECT * FROM `_specialties` WHERE length(`code`) = 1;')
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(QualificationRequest $request)
  {
    Qualification::create([
      "user_id" => auth()->user()->id,
      "qualification" => $request->qualification,
      "study_type" => $request->study_type,
      "study_nature" => $request->study_natures,
      "graduation_date" => $request->graduation_date,
      "graduation_university" => $request->graduation_university,
      "graduation_college"=> $request->graduation_college,
      "graduation_country"=> $request->graduation_country,
      "city"=> $request->city,
      "attested"=> $request->attested == 'on' ? '1' : '0',
      "thesis"=> $request->thesis,
      "major_id"=> $request->major_id,
      "minor_id"=> $request->minor_id,
      "gpa"=> $request->gpa,
      "gpa_type"=> $request->gpa_type,
      "rating"=> $request->rating,
    ]);
    if($request->hasFile('attachment')){
      $latest = Qualification::latest('created_at')->first();
      $filepath = $request->file('attachment')->store(auth()->user()->id, 'public');
      $latest->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '4',
        'link' => $filepath,
        'title' => 'qualification'
      ]);
    }
    return redirect()->route('qualifications.index')
      ->with('success', __('You have added your qualification successfully'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Qualification $qualification)
  {
    return view('qualifications.show', [
      'qualification' => $qualification,
      'link' => $this->getLink($qualification->id)
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Qualification $qualification)
  {
    return view('qualifications.edit', [
      'q' =>  $qualification,
      'qualifications' => QualificationLookUp::all(),
      'study_types' => StudyType::all(),
      'study_natures' => StudyNature::all(),
      'countries' => Country::all(),
      'ratings' => Rating::all(),
      'gpa_types' => GPATypes::all(),
      'link' => $this->getLink($qualification->id),
      'domains' => DB::select('SELECT * FROM `_specialties` WHERE length(`code`) = 1;')
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(QualificationRequest $request, string $id)
  {
    // return dd($request->thesis);
    Qualification::find($id)->update([
      "qualification" => $request->qualification,
      "study_type"=> $request->study_type,
      "study_nature" => $request->study_natures,
      "graduation_date"=> $request->graduation_date,
      "graduation_university"=> $request->graduation_university,
      "graduation_college"=> $request->graduation_college,
      "graduation_country"=> $request->graduation_country,
      "city"=> $request->city,
      "attested"=> $request->attested == 'on' ? '1' : '0',
      "thesis"=> $request->thesis,
      "major_id"=> $request->major_id,
      "minor_id"=> $request->minor_id,
      "gpa"=> $request->gpa,
      "gpa_type"=> $request->gpa_type,
      "rating"=> $request->rating,
    ]);
    if($request->hasFile('attachment')){
      $filepath = $request->file('attachment')->store(auth()->user()->id, 'public');
      Qualification::find($id)->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '4',
        'link' => $filepath,
        'title' => 'qualification'
      ]);
    }
    return redirect()->route('qualifications.index')->with('success', __('You have updated the qualification successfully'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    Qualification::find($id)->delete();
    $file = $this->getLink($id);
    $attachment = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\Qualification')
    ->where('attachmentable_id', $id)->first();
      $attachment->delete();
    if($file){
      unlink($file);
    }
    return redirect()->route('qualifications.index')->with('success', 'You have deleted the qualification successfully');
  }

  /**
   * Get the major based on the domain selecting using ajax
   */
  public function major($firstLetter){
    $major = DB::select('SELECT * FROM `_specialties` WHERE `code` LIKE CONCAT(?,?);', [$firstLetter,"%01"]);
    return json_encode($major);
  }

  public function minor($code){
    $minor = DB::select("SELECT * FROM `_specialties` WHERE `code` LIKE CONCAT(?, ?);", [$code, "%"]);
    return json_encode($minor);
  }

  public function getLink(string $id){
    $link = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\Qualification')
    ->where('attachmentable_id', $id)
    ->first('link');
    if($link){
      return "storage/" . $link->link;
    }
    return false;
  }
}