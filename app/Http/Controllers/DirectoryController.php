<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    $users = User::with('ats')->where('active', '1')
      ->where('category_id', '!=', 8)
      ->get();
    return view('directory.index', compact('users'));
  }
}
