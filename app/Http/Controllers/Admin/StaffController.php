<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use App\Models\User;
use App\Models\Salary;
use App\Models\Ticket;
use App\Models\Contact;
use App\Models\Document;
use App\Exports\StaffExport;
use Illuminate\Http\Request;
use App\Models\Tables\Gender;
use App\Events\FacultyCreated;
use App\Models\Admin\TempUser;
use App\Models\Tables\Country;
use App\Models\Tables\Section;
use App\Events\EmployeeCreated;
use App\Events\FacultyResigned;
use App\Models\Tables\Category;
use App\Models\Tables\Position;
use App\Models\Tables\Religion;
use App\Events\EmployeeResigned;
use App\Models\Tables\SpecialNeed;
use App\Models\Tables\Sponsorship;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tables\MaritalStatus;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\AddEmployee;
use App\Models\Tables\Bank as TablesBank;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{

  public function index(Request $request)
  {
    $params = [
      'status' => request()->status ?? '',
      'gender' => request()->gender ?? '',
      'nationality' => request()->nationality ?? '',
      'saudization' => request()->saudization ?? '' ,
      'section' => implode(',', request()->section ?? []) ?? '' ,
      'category' => implode(',', request()->category ?? []) ?? '',
      'sponsorship' => implode(',', request()->sponsorship ?? []) ?? '' ,
      'from' => request()->from ?? '' ,
      'to' => request()->to ?? ''
    ];

    return view('admin.staff.index',[
      'staff' => $this->staff($request),
      'params' => $params,
      'sections' => Section::all(),
      'categories' => Category::all(),
      'genders' => Gender::all(),
      'nationalities' => Country::all(),
      'sponsorships' => Sponsorship::all()
    ]);
  }

  public function show(string $id)
  {
    return view('admin.staff.show', [
      'user' => User::find($id),
      'banks' => TablesBank::all(),
      'mobile' => Contact::where('user_id', $id)->where('type', '1')->first(),
      'email' => Contact::where('user_id', $id)->where('type', '2')->first(),
      'extension' => Contact::where('user_id', $id)->where('type', '3')->first(),
      'office' => Contact::where('user_id', $id)->where('type', '4')->first(),
      'salary' => Salary::where('user_id', $id)->orderByDesc('effective')->get(),
      'bank' => Bank::with('bank')->where('user_id', $id)->first(),
      'documents' => Document::where('user_id', $id)->get()
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
      , 'basic' => $request->basic ?? 0
      , 'housing' => $request->housing ?? 0
      , 'transportation' => $request->trans ?? 0
      , 'food' => $request->food ?? 0
      , 'ticket' => $request->ticket ?? 0
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
    if(!empty($temp)){
      $temp->update($data);
    }else{
      TempUser::create($data);
    }
    return redirect()->route('admin.staff')->with('success', __('admin/staff.draftSaved'));
  }

  public function store(AddEmployee $request)
  {
    $validated = $request->validated();
    $user = User::create([
      'empid' => $validated['empid'],
      'email' => $validated['email'],
      'password' => Hash::make($validated['document_id1']),
      'first_name_en' => $validated['first_name_en'],
      'middle_name_en' => $validated['middle_name_en'],
      'third_name_en' => $validated['third_name_en'],
      'family_name_en' => $validated['family_name_en'],
      'first_name_ar' => $validated['first_name_ar'],
      'middle_name_ar' => $validated['middle_name_ar'],
      'third_name_ar' => $validated['third_name_ar'],
      'family_name_ar' => $validated['family_name_ar'],
      'gender_id' => $validated['gender_id'],
      'nationality_id' => $validated['nationality_id'],
      'date_of_birth' => $validated['date_of_birth'],
      'section_id' => $validated['section_id'],
      'category_id' => $validated['category_id'],
      'position_id' => $validated['position_id'],
      'sponsorship_id' => $validated['sponsorship_id'],
      'joining_date' => $validated['joining_date'],
      'vacation_class' => $validated['vacation_class'],
      'cost_center' => $validated['cost_center'],
      'salary' => isset($validated['salary']) && $validated['salary']== "on" ? '1' : '0',
      'fingerprint' => isset($validated['fingerprint']) && $validated['fingerprint']== "on" ? '1' : '0',
      'married_contract' => isset($validated['married_contract']) && $validated['married_contract']== "on" ? '1' : '0',
      'notes' => $validated['notes'],
      'created_by' => auth()->user()->id,
      'updated_by' => auth()->user()->id
    ]);

    $latest_id = User::latest('id')->first()->id;

    Document::create([
      'user_id' => $latest_id,
      'document_type_id' => 1,
      'description' => 'National ID',
      'document_id' => $validated['document_id1'],
      'place_of_issue' => $validated['place_of_issue1'],
      'date_of_issue' => $validated['date_of_issue1'],
      'date_of_expiry' => $validated['date_of_expiry1'],
      'notification' => '30'
    ]);

    if($validated['document_id2'] != null){
      Document::create([
        'user_id' => $latest_id,
        'document_type_id' => 2,
        'description' => 'Passport',
        'document_id' => $validated['document_id2'],
        'place_of_issue' => $validated['place_of_issue2'],
        'date_of_issue' => $validated['date_of_issue2'],
        'date_of_expiry' => $validated['date_of_expiry2'],
        'notification' => '180'
      ]);
    }

    Contact::create([
      'user_id' => $latest_id,
      'contact' => $validated['mobile'],
      'type' => '1'
    ]);

    if($validated['personal_email'] != null){
      Contact::create([
        'user_id' => $latest_id,
        'contact' => $validated['personal_email'],
        'type' => '2'
      ]);
    }

    Salary::create([
      'user_id' => $latest_id,
      'basic' => $validated['basic'] ?? 0,
      'housing' => $validated['housing'] ?? 0,
      'transportation' => $validated['trans'] ?? 0,
      'food' => $validated['food'] ?? 0,
      'effective' => $validated['joining_date'],
    ]);

    if($validated['ticket'] != null){
      Ticket::create([
        'user_id' => $latest_id,
        'amount' => $validated['ticket'],
        'effective' => $validated['joining_date']
      ]);
    }

    if ($validated['iban'] != null && $validated['bank_code']!= null) {
      Bank::create([
        'user_id' =>  $latest_id,
        'bank_code' => $validated['bank_code'],
        'iban' => preg_replace('/\s+/', '', $validated['iban'])
      ]);
    }

    if(TempUser::latest()->first() != null){
      TempUser::latest()->first()->delete();
    }

    if($validated['category_id'] == 1){
      event(new FacultyCreated($user));
    }

    event(new EmployeeCreated($user));

    return redirect()->route('admin.staff')->with('success', __('admin/staff.userSaved'));
  }

  private function staff(Request $request)
  {
    return $this->requestFilter($request)
      ->paginate()
      ->withQueryString();
  }

  private function requestFilter(Request $request)
  {
    return User::when($request->status != '' ,function($q) use($request){
        $q->where('active', $request->status);
      })
      ->when($request->gender != '', function($q) use($request){
        $q->where('gender_id', $request->gender);
      })
      ->when($request->nationality != '', function($q) use($request){
        $q->where('nationality_id', $request->nationality);
      })
      ->when($request->saudization != '', function($q) use($request){
        if($request->saudization == '1'){
          $q->where('nationality_id', '=' ,'1');
        }else{
          $q->where('nationality_id', '!=' ,'1');
        }
      })
      ->when($request->section != [], function($q) use($request){
        $q->whereIn('section_id', $request->section);
      })
      ->when($request->category != [], function($q) use($request){
        $q->whereIn('category_id', $request->category);
      })
      ->when($request->sponsorship != [], function($q) use($request){
        $q->whereIn('sponsorship_id', $request->sponsorship);
      })
      ->when($request->search != '', function($q) use ($request){
        $q->where(function($q)use ($request){
          $q->orWhere('first_name_en', 'like', "%{$request->search}%")
          ->orWhere('middle_name_en', 'like', "%{$request->search}%")
          ->orWhere('third_name_en', 'like', "%{$request->search}%")
          ->orWhere('family_name_en', 'like', "%{$request->search}%")
          ->orWhere('first_name_ar', 'like', "%{$request->search}%")
          ->orWhere('middle_name_ar', 'like', "%{$request->search}%")
          ->orWhere('third_name_ar', 'like', "%{$request->search}%")
          ->orWhere('family_name_ar', 'like', "%{$request->search}%")
          ->orWhere('empid', 'like', "%{$request->search}%");
        });
      })
      ->when($request->from != '' && $request->to != '', function($q) use($request){
        $q->whereDate('joining_date', '<=', $request->to)
        ->where(function($q) use($request){
            $q->whereDate('resignation_date', '>=', $request->from)
            ->orWhere('active', '1');
          });
      });
  }
  public function download()
  {
    return (new StaffExport())->download('employees.xlsx');
  }

  public function addSalary(Request $request)
  {

    Validator::make($request->all(), [
      'user_id' => 'required',
      'basic' => 'required',
      'housing' => 'required',
      'transportation' => 'required',
      'food' => 'required',
      'effective' => 'required|date'
    ], attributes: [
      'basic' => __('salary.basic'),
      'housing' => __('salary.housing'),
      'transportation' => __('salary.transportation'),
      'food' => __('salary.food'),
      'effective' => __('salary.effective'),
    ])->validate();

    Salary::create([
      'user_id' => $request['user_id'],
      'basic' => $request['basic'],
      'housing' => $request['housing'],
      'transportation' => $request['transportation'],
      'food' => $request['food'],
      'effective' => $request['effective'],
    ]);

    return redirect()->back()->with('success', __('salary.success'));

  }

  public function editIBAN(Request $request)
  {
    Validator::make($request->only('user_id', 'iban', 'bank_id'), [
      'user_id' => 'required|exists:users,id',
      'iban' => 'required|min:24|max:24|starts_with:SA',
      'bank_id' => 'required|exists:_banks,id'
    ], messages: [
      'iban.min' => __('salary.ibanInvaild'),
      'iban.max' => __('salary.ibanInvaild'),
      'iban.starts_with' => __('salary.ibanInvaild'),
    ], attributes: [
      'iban' => __('salary.iban'),
      'bank_id' => __('salary.bankName'),
    ])->validate();

    $bank = Bank::where('user_id', $request->user_id)->first();
    if ($bank !== null) {
      $bank->update([
        'iban' => $request->iban,
        'bank_code' => $request->bank_id,
      ]);
    }else{
      Bank::create([
        'user_id' => $request->user_id,
        'iban' => $request->iban,
        'bank_code' => $request->bank_id,
      ]);
    }
    return redirect()->back()->with('success', __('salary.successIBAN'));
  }

  public function resign(string $id, Request $request)
  {

    Validator::make($request->only('resignation_date'), [
      'resignation_date' => 'required|date'
    ], messages: [
      'resignation_date.required' => __('admin/employee.resDateReq'),
      'resignation_date.date' => __('admin/employee.resDateInvalid')
    ] ,attributes: [
      'resignation_date' => __('admin/employee.resingnation_date')
    ])->validate();

    $user = User::find($id);
    $isFacultyStaff = in_array($user->category_id, ['1', '2']);

    $user->update([
      'active' => 0,
      'salary' => 0,
      'resignation_date' => $request->resignation_date
    ]);

    if ($isFacultyStaff) {
      event(new FacultyResigned($user));
    }
    event(new EmployeeResigned($user));

    return redirect()->back()->with('success', __('admin/employee.employeeResigned'));
  }
}

