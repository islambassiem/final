<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Tables\Country;
use App\Models\Tables\CourseType;

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
      'countries' => Country::all(),
      'types' => CourseType::all()
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
  public function store(CourseRequest $request)
  {
    Course::create($request->validated());
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
    //
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
}
