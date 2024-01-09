<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FamilyVisit;
use Illuminate\Http\Request;

class FamilyVisitController extends Controller
{
  public function index()
  {
    return view('admin.family-visit.index', [
      'visits' => FamilyVisit::with('user')->orderByDesc('id')->get()
    ]);
  }
}
