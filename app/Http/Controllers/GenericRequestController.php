<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GenericRequest;
use App\Mail\GenericRequestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GenericRequestController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('requests.index', [
      'generics' => GenericRequest::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get()
    ]);
  }

  public function create()
  {
    return view('requests.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'subject' => 'required'
    ],[
      'title.required' => __('The title is required'),
      'subject.required' => __('The subject is required')
    ]);
    GenericRequest::create([
      'user_id' => auth()->user()->id,
      'title' => $validated['title'],
      'subject' => null
    ]);
    $latest = GenericRequest::latest('id')->first();
    Storage::disk('public')->put(auth()->user()->id . '//text/' . $latest->id . '_request.txt', $validated['subject']);
    $latest->update([
      'link' => auth()->user()->id . '/text/' . $latest->id . '_request.txt'
    ]);
    Mail::queue(new GenericRequestMail($latest));
    return redirect()->route('generics.index')->with('success', 'You request has been receive successfully');
  }

  public function show(string $id)
  {
    return view('requests.show', [
      'generic' => GenericRequest::find($id)
    ]);
  }
}
