<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

  public function __construct()
  {
    // return $this->middleware('auth');
  }

  public function index($id)
  {
    if(view()->exists($id)){
      return view($id);
    }
  }
}
