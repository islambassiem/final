<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest;
use App\Models\Attachment;
use App\Models\Tables\AttachmentType;

class DocumentController extends Controller
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
    return view('documents.index', [
      'types' => AttachmentType::where('id', '>=', '5')->get(),
      'docNum' => Document::where('user_id', auth()->user()->id)->count(),
      'nationalIds' => Document::with('attachment')->where('user_id', auth()->user()->id)->where('document_type_id', 1)->get(),
      'passports' => Document::where('user_id', auth()->user()->id)->where('document_type_id', 2)->get(),
      'documents' => Document::where('user_id', auth()->user()->id)->where('document_type_id', '>', 2)->get()
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
  public function store(DocumentRequest $request)
  {
    $validated =  $request->validated();
    $validated['notification'] = $validated['notification'] == null ? '0' : $validated['notification'];
    $validated['user_id'] = auth()->user()->id;
    Document::create($validated);
    $latest = Document::latest('created_at')->first();
    if($request->hasFile('attachment')){
      $path = $request->file('attachment')->store(auth()->user()->id . '/documents', 'public');
      $latest->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => $request->document_type_id,
        'link' => $path,
        'title' => $request->description,
      ]);
    }
    return redirect()->route('documents.index')->with('success', 'You have added a document successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  public function editID(Request $request, string $id)
  {
    $nationalID = Document::find($id);
    $nationalID->update([
      'place_of_issue' => $request->input('place_of_issue_iqama_edit'),
      'date_of_issue' => $request->input('date_of_issue_iqama_edit'),
      'notification' => $request->input('notification_iqama_edit') ?? '0',
    ]);
    if($request->hasFile('attachment')){
      $path = $request->file('attachment')->store(auth()->user()->id . '/documents', 'public');
      $nationalID->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => 1,
        'link' => $path,
        'title' => 'national ID',
      ]);
    }
    return redirect()->back()->with('success', 'You have updated national ID information successfully');
  }

  public function editPassport(Request $request, string $id)
  {
    $validated = $request->validate([
      'place_of_issue_passport_edit' => 'nullable',
      'date_of_issue_passport_edit' => 'nullable',
      'date_of_expiry_passport_edit' => 'required',
      'notification_passport_edit' => 'nullable'
    ], [
      'date_of_expiry_passport_edit' => __('The expiry date is required')
    ]);
    $validated['notification_passport_edit'] = $validated['notification_passport_edit'] == null ? '0' : $validated['notification_passport_edit'];
    $passport = Document::find($id);
    $passport->update([
      'place_of_issue' => $request->input('place_of_issue_passport_edit'),
      'date_of_issue' => $request->input('date_of_issue_passport_edit'),
      'date_of_expiry' => $request->input('date_of_expiry_passport_edit'),
      'notification' => $request->input('notification_passport_edit') ?? '0',
    ]);
    if($request->hasFile('attachment')){
      $path = $request->file('attachment')->store(auth()->user()->id . '/documents', 'public');
      $passport->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => 2,
        'link' => $path,
        'title' => 'Passport',
      ]);
    }
    return redirect()->back()->with('success', 'You have updated your Passport successfully');
  }

  public function editDoc(Request $request, string $id)
  {
    $validated = $request->validate([
      'description_edit' => 'nullable',
      'document_id_edit' => 'nullable',
      'place_of_issue_edit' => 'nullable',
      'date_of_issue_edit' => 'nullable',
      'date_of_expiry_edit' => 'nullable',
      'notification_edit' => 'nullable'
    ]);
    $validated['notification_edit'] = $validated['notification_edit'] == null ? '0' : $validated['notification_edit'];
    $doc = Document::find($id);
    $doc->update([
      'description' => $request->input('description_edit'),
      'document_id' => $request->input('document_id_edit'),
      'place_of_issue' => $request->input('place_of_issue_edit'),
      'date_of_issue' => $request->input('date_of_issue_edit'),
      'date_of_expiry' => $request->input('date_of_expiry_edit'),
      'notification' => $request->input('notification_edit') ?? '0',
    ]);
    if($request->hasFile('attachment')){
      $path = $request->file('attachment')->store(auth()->user()->id . '/documents', 'public');
      $doc->attachment()->create([
        'user_id' => auth()->user()->id,
        'attachment_type' => $doc->document_type_id,
        'link' => $path,
        'title' => $request->input('description_edit'),
      ]);
    }
    return redirect()->back()->with('success', 'You have updated your Document successfully');
  }

  public function getLink(string $id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
      ->where('attachmentable_type', 'App\Models\Document')
      ->where('attachmentable_id', $id)
      ->first('link');
    if($link){
      return redirect();
    }
    return false;
  }

  public function getAttachment($id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
      ->where('attachmentable_type', 'App\Models\Document')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return redirect("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment; press edit icon to add one'));
  }
}
