<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;

class LetterController extends Controller
{
  public function index()
  {
    return view('admin.letters.index', [
      'letters' => Letter::with('user')->orderByDesc('id')->get()
    ]);
  }
}
