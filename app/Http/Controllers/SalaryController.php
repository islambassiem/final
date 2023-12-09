<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('salary.index', [
      'salary' => Salary::where('user_id', auth()->user()->id)->orderBy('effective', 'desc')->get()
    ]);
  }
}
