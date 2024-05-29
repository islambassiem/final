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
use App\Models\Tables\Specialty;

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
    $validated = $request->validated();
    $validated['user_id'] = auth()->user()->id;
    $validated['attested'] = $request->attested == 'on' ? '1' : '0';
    Qualification::create($validated);
    $latest = Qualification::latest('created_at')->first();
    if($request->hasFile('attachment')){
      foreach ($request->file('attachment') as $attachment) {
        $filepath = $attachment->store(auth()->user()->id . '/qualifications', 'public');
        $latest->attachment()->create([
          'user_id' => auth()->user()->id,
          'attachment_type' => '3',
          'link' => $filepath,
          'title' => 'qualification'
        ]);
      }
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
    $validated = $request->validated();
    $validated['user_id'] = auth()->user()->id;
    $validated['attested'] = $request->attested == 'on' ? '1' : '0';
    Qualification::find($id)->update($validated);
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
    return redirect()->route('qualifications.index')->with('success', 'You have deleted the qualification successfully');
  }

  public function getLink(string $id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\Qualification')
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
      ->where('attachmentable_type', 'App\Models\Qualification')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return response()->download("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment; press edit icon to add one'));
  }

  public function major($code)
  {
    $major = DB::select('SELECT * FROM `_specialties` WHERE `code` LIKE CONCAT(?,?) OR `code` LIKE CONCAT(?,?);', [$code,"%01", $code, 'Z99']);
    return json_encode($major);
  }

  public function minor($id)
  {
    $code = DB::table('_specialties')->where('id', $id)->value('code');
    $code = substr($code, 0, 2);
    $minor = DB::select("SELECT * FROM `_specialties` WHERE `code` LIKE CONCAT(?, ?);", [$code, "%"]);
    return json_encode($minor);
  }
}
