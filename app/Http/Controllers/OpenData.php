<?php

namespace App\Http\Controllers;

use App\Exports\TeachingStaffExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class OpenData extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    $users = User::with('ats')->where('active', '1')
      ->whereIn('category_id', [1, 2])
      ->get();
    return view('open-data.index', compact('users'));
  }

  public function export()
  {
    return Excel::download(new TeachingStaffExport, 'faculty_staff_active_list.xlsx');
  }
}
