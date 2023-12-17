<?php

namespace App\Http\Controllers\Head;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index(){
    return view('head.staff.index', [
      'staff' => User::where('head', auth()->user()->id)->where('active', '1')->orderBy('joining_date', 'asc')->get()
    ]);
  }
}
