<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Achievement;
use App\Http\Requests\AchievementRequest;

class AchievementController extends Controller
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
    return view('achievement.index', [
      'achievements' => Achievement::where('user_id', auth()->user()->id)->get()
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
  public function store(AchievementRequest $request)
  {
    // return dd($request->validated());
    Achievement::create($request->validated());
    if($request->hasFile('attachment')){
      $latest = Achievement::latest('id')->first();
      $path = $request->file('attachment')->store(auth()->user()->id . '/achievement', 'public');
      $latest->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '10',
        'link' => $path,
        'title' => 'achievement',
      ]);
    }
    return redirect()->route('achievements.index')->with('success', __('You have created an achievement successfully'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Achievement $achievement)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Achievement $achievement)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(AchievementRequest $request, Achievement $achievement)
  {
    $achievement->update($request->validated());
    return redirect()->route('achievements.index')->with('success', __('You have updated the achievement successfully'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Achievement $achievement)
  {
    $achievement->delete();
    return redirect()->route('achievements.index')->with('success', __('You have deleted the achievement successfully'));
  }
  public function getLink($id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\Achievement')
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
      ->where('attachmentable_type', 'App\Models\Achievement')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return response()->download("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment; press edit icon to add one'));
  }
}
