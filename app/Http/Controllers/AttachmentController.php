<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
  public function index()
  {
    $folders = Attachment::where('user_id', auth()->user()->id)->get()->unique('attachmentable_type');
    return view('attachments.index', [
      'folders' => $folders
    ]);
  }
}
