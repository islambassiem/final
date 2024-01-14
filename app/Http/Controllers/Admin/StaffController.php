<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use App\Models\User;
use App\Models\Salary;
use App\Models\Contact;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\Tables\Gender;
use App\Models\Admin\TempUser;
use App\Models\Tables\Country;
use App\Models\Tables\Section;
use App\Models\Tables\Category;
use App\Models\Tables\Position;
use App\Models\Tables\Religion;
use App\Models\Tables\SpecialNeed;
use App\Models\Tables\Sponsorship;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tables\MaritalStatus;
use App\Models\Tables\Bank as TablesBank;

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
    $draft = TempUser::first();
    $empid = (User::orderByDesc('empid')->pluck('empid')->toArray())[1];
    if(!empty($draft)){
      return view('admin.staff.store', [
        'empid' => $empid,
        'user' => $draft,
        'genders' => Gender::all(),
        'countries' => Country::all(),
        'religions' => Religion::all(),
        'mstatus' => MaritalStatus::all(),
        'disability' => SpecialNeed::all(),
        'sections' => Section::all(),
        'positions' => Position::all(),
        'categories' => Category::all(),
        'sponsorships' => Sponsorship::all(),
        'banks' => TablesBank::all(),
      ]);
    }
    return view('admin.staff.create', [
      'empid' => $empid,
      'genders' => Gender::all(),
      'countries' => Country::all(),
      'religions' => Religion::all(),
      'mstatus' => MaritalStatus::all(),
      'disability' => SpecialNeed::all(),
      'sections' => Section::all(),
      'positions' => Position::all(),
      'categories' => Category::all(),
      'sponsorships' => Sponsorship::all(),
      'banks' => TablesBank::all(),
    ]);
  }

  public function email($email)
  {
    return User::where('email', $email)->count() == 0 ? 1 : 0;
  }

  public function draft(Request $request)
  {
    $data = [
      'empid' => $request->empid
      , 'email' => $request->email
      , 'head' => null
      , 'first_name_en' => $request->first_name_en
      , 'middle_name_en' => $request->second_name_en
      , 'third_name_en' => $request->third_name_en
      , 'family_name_en' => $request->family_name_en
      , 'first_name_ar' => $request->first_name_ar
      , 'middle_name_ar' => $request->middle_name_ar
      , 'third_name_ar' => $request->third_name_ar
      , 'family_name_ar' => $request->family_name_ar
      , 'gender_id' => $request->gender_id
      , 'nationality_id' => $request->nationality_id
      , 'religion_id' => $request->religion_id
      , 'date_of_birth' => $request->date_of_birth
      , 'place_of_birth_id' => null
      , 'marital_status_id' => $request->marital_status_id
      , 'joining_date' => $request->joining_date
      , 'resignation_date' => $request->resignation_date
      , 'position_id' => $request->position_id
      , 'sponsorship_id' => $request->sponsorship_id
      , 'section_id' => $request->section_id
      , 'category_id' => $request->category_id
      , 'active' => 1
      , 'salary' => $request->salary == 'on' ? '1' : '0'
      , 'fingerprint' => $request->fingerprint == 'on' ? '1' : '0'
      , 'saturday' => 1
      , 'cost_center' => $request->cost_center
      , 'married_contract' => $request->married_contract == 'on' ? '1' : '0'
      , 'vacation_class' => $request->vacation_class ?? 0
      , 'notes' => $request->notes
      , 'special_need_id' => $request->special_need_id
      , 'home_country_id' => null
      , 'document_id' => $request->document_id1
      , 'basic' => $request->basic
      , 'housing' => $request->housing
      , 'transportation' => $request->trans
      , 'food' => $request->food
      , 'ticket' => $request->ticket
      , 'bank_code' => $request->bank_code
      , 'iban' => $request->iban
      , 'mobile' => $request->mobile
      , 'personal_email' => $request->personal_email
      , 'created_by' => auth()->user()->id
      , 'updated_by' => auth()->user()->id
      , 'place_of_issue1' => $request->place_of_issue1
      , 'date_of_issue1' => $request->date_of_issue1
      , 'date_of_expiry1' => $request->date_of_expiry1
      , 'document_id2' => $request->document_id2
      , 'place_of_issue2' => $request->place_of_issue2
      , 'date_of_issue2' => $request->date_of_issue2
      , 'date_of_expiry2' => $request->date_of_expiry2
    ];
    $temp = TempUser::first();
    if($temp){
      $temp->update($data);
    }else{
      TempUser::create($data);
    }
    return redirect()->route('admin.staff')->with('success', __('admin/staff.draftSaved'));
  }

  public function store(Request $request)
  {
    return 'store method';
  }
}
