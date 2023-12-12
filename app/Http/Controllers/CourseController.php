<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Attachment;
use App\Models\Tables\Country;
use App\Models\Tables\CourseType;
use App\Http\Requests\CourseRequest;

class CourseController extends Controller
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
    return view('courses.index', [
      'courses' => Course::where('user_id', auth()->user()->id)->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('courses.create', [
      'countries' => Country::all(),
      'types' => CourseType::all()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CourseRequest $request)
  {
    Course::create($request->validated());
    if($request->hasFile('attachment')){
      $latest = Course::latest('id')->first();
      $path = $request->file('attachment')->store(auth()->user()->id . '/courses', 'public');
      $latest->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => '11',
        'link' => $path,
        'title' => 'course',
      ]);
    }
    return redirect()->route('courses.index')->with('success', 'You have added the course successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Course $course)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Course $course)
  {
    return view('courses.edit', [
      'course' => $course,
      'countries' => Country::all(),
      'types' => CourseType::all(),
      'link' => $this->getLink($course->id)
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CourseRequest $request, Course $course)
  {
    $course->update($request->validated());
    return redirect()->route('courses.index')->with('success', 'You have updated the course successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Course $course)
  {
    $course->delete();
    return redirect()->route('courses.index')->with('success', __('You have deleted the course successfully'));
  }

  public function getLink($id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
    ->where('attachmentable_type', 'App\Models\Course')
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
      ->where('attachmentable_type', 'App\Models\Course')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return response()->download("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment; press edit icon to add one'));
  }
}
