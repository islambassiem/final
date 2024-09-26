<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeesImpersonateController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }


  public function index()
  {
    return view('employees.index', [
      'staff' => User::where('active', 1)->get()
    ]);
  }
}
