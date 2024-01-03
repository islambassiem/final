<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
  public function index()
  {
    $staff = User::where('active', '1')->orderBy('empid')->get();
    return view('admin.staff.index',[
      'staff' => $staff
    ]);
  }

  public function show(User $user)
  {
    return view('admin.staff.show', [
      'employee' => $user
    ]);
  }
}
