<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use App\Models\User;
use App\Models\Salary;
use App\Models\Contact;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\TempUser;
use App\Models\Tables\Country;
use App\Models\Tables\Gender;
use App\Models\Tables\MaritalStatus;
use App\Models\Tables\Religion;
use App\Models\Tables\SpecialNeed;

class StaffController extends Controller
{
  public function index()
  {
    $staff = User::orderBy('empid')->get();
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
      'bank' => Bank::with('bank')->where('user_id', $id)->first(),
    ]);
  }

  public function create()
  {
    $draft = TempUser::count();
    if($draft == 1){
      // retrun the edit page
    }
    $empid = (User::orderByDesc('empid')->pluck('empid')->toArray())[1];
    return view('admin.staff.create', [
      'empid' => $empid,
      'genders' => Gender::all(),
      'countries' => Country::all(),
      'religions' => Religion::all(),
      'mstatus' => MaritalStatus::all(),
      'disability' => SpecialNeed::all(),
    ]);
  }

  public function draft(Request $request)
  {
    return $request->all();
  }
}
