<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Tables\AttachmentType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{

	public function __construct()
	{
		return $this->middleware('auth');
	}

  public function index()
  {
    $folders = Attachment::where('user_id', auth()->user()->id)->orderBy('attachmentable_type')->get()->unique('attachmentable_type');
    return view('attachments.index', [
      'folders' => $folders,
      'types' => AttachmentType::orderBy('code')->orderBy('attachment_type_en')->get()
    ]);
  }
  public function folderContent($folder)
  {
    $files = Attachment::where('user_id', auth()->user()->id)
      ->where('attachmentable_type', 'App\Models\\' . Str::ucfirst($folder))->get();
    return view('attachments.show', [
      'files' => $files,
    ]);
  }

  public function getAttachment($id)
  {
    $link = Attachment::where('user_id', auth()->user()->id)
      ->where('id', $id)
      ->first('link');
    if ($link) {
      return response()->download("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment'));
  }

  public function store(Request $request)
  {
    $latest = Attachment::latest('id')->first('id')->id;
    $validated = $request->validate([
      'attachment_type' => 'required',
      'title' => 'required|max:255',
      'attachment' => 'nullable|mimes:png,jpg,jpeg,png,pdf|max:2048'
    ], [
      'attachment_type.required' => __('The attachment type is required'),
      'title.required' => __('A title for the attachment is required'),
      'title.max' => __('The maximum characters for the title is 255 characters'),
      'attachment.mimetypes' => __('The file is invalid'),
      'attachment.max' => __('The maximum file upload is 2MBs'),
    ]);
    if($request->hasFile('attachment')){
      $validated['link'] = $request->file('attachment')->store(auth()->user()->id . '/attachments', 'public');
    }
    $validated['user_id'] = auth()->user()->id;
    $validated['attachmentable_type'] = 'App\Models\Attachment';
    $validated['attachmentable_id'] = $latest + 1;
    Attachment::create($validated);
    return redirect()->back()->with('success', 'You have added you attachment successfully');

  }

}
