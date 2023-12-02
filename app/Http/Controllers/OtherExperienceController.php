<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
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
    $latest = OtherExperience::latest('created_at')->first();
    if($request->hasFile('attachment')){
      foreach ($request->file('attachment') as $attachment) {
        $filepath = $attachment->store(auth()->user()->id . '/otherExperience', 'public');
        $latest->attachment()->create([
          'user_id' => auth()->user()->id,
          'attachment_type' => '5',
          'link' => $filepath,
          'title' => 'Other Experience'
        ]);
      }
    }
    return redirect()->route('other_experience.index')->with('success', __('You have added an experience outside KSA successfully'));
  }

  /**
   * Display the specified resource.
   */
  public function show(OtherExperience $otherExperience)
  {
    return view('otherExperience.show', [
      'experience' => $otherExperience,
      'link' => $this->getLink($otherExperience->id)
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(OtherExperience $otherExperience)
  {
    return view('otherExperience.edit', [
      'experience' => $otherExperience,
      'countries' => Country::all(),
      'link' => $this->getLink($otherExperience->id),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(OtherExperienceRequest $request, OtherExperience $otherExperience)
  {
    $otherExperience->update($request->validated());
    if($request->hasFile('attachment')){
      $filepath = $request->file('attachment')->store(auth()->user()->id, 'public');
      OtherExperience::find($otherExperience->id)->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '5',
        'link' => $filepath,
        'title' => 'Other Experience'
      ]);
    }
    return redirect()->route('other_experience.index')->with('success', __('You have updated the experience outside KSA successfully'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(OtherExperience $otherExperience)
  {
    $otherExperience->delete();
    $file = $this->getLink($otherExperience->id);
    $attachments = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\OtherExperience')
    ->where('attachmentable_id', $otherExperience->id)->get();
    if($attachments){
      foreach ($attachments as $attachment) {
        $attachment->delete();
      }
    }
    if($file){
      unlink($file);
    }
    return redirect()->route('other_experience.index')->with('success', __('You have deleted the experience outside KSA successfully'));
  }

  public function getLink(string $id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\OtherExperience')
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
      ->where('attachmentable_type', 'App\Models\OtherExperience')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return redirect("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment; press edit icon to add one'));
  }
}
