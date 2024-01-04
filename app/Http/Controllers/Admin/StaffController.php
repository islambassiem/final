<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Salary;
use App\Models\Contact;
use App\Models\Document;
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

  public function show(string $id)
  {
    return view('admin.staff.show', [
      'user' => User::find($id),
      'mobile' => Contact::where('user_id', $id)->where('type', '1')->first(),
      'email' => Contact::where('user_id', $id)->where('type', '2')->first(),
      'extension' => Contact::where('user_id', $id)->where('type', '3')->first(),
      'office' => Contact::where('user_id', $id)->where('type', '4')->first(),
      'salary' => Salary::where('user_id', $id)->orderByDesc('effective')->get(),
    ]);
  }
}
