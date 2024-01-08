<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExitReentry;
use Illuminate\Http\Request;

class ExitReentryController extends Controller
{
  public function index()
  {
    return view('admin.exit-reentry.index', [
      'visas' => ExitReentry::with('user')->orderByDesc('id')->get()
    ]);
  }
}
