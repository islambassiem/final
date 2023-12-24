<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Tables\Country;
use App\Models\Tables\MaritalStatus;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }

  public function index()
  {
    return view('profile.index', [
      'user' => User::find(auth()->user()->id),
      'national_address' => Address::where('user_id', auth()->user()->id)->where('type', 'national')->first(),
      'address' => Address::where('user_id', auth()->user()->id)->where('type', 'international')->first(),
      'countries' => Country::all(),
      'mobile' => Contact::where('user_id', auth()->user()->id)->where('type', '1')->first(),
      'email' => Contact::where('user_id', auth()->user()->id)->where('type', '2')->first(),
      'extension' => Contact::where('user_id', auth()->user()->id)->where('type', '3')->first(),
      'office' => Contact::where('user_id', auth()->user()->id)->where('type', '4')->first(),
      'status' => MaritalStatus::all()
    ]);
  }

  public function storeNationalAddress(Request $request)
  {
    $validated = $request->validate([
      'building_no' => 'nullable|string|max:10',
      'street_name' => 'nullable|string|max:50',
      'district_name' => 'nullable|string|max:50',
      'city' => 'nullable|string|max:50',
      'zip_code' => 'nullable|string|max:10',
      'secondary_number' => 'nullable|string|max:10',
    ]);
    $validated['user_id'] = auth()->user()->id;
    $validated['type'] = 'national';
    $validated['country_id'] = '1';
    Address::create($validated);
    return redirect('profile')->with('success', __('profile.nAddressSuccess'));
  }

  public function storeAddress(Request $request)
  {
    $validated = $request->validate([
      'building_no' => 'nullable|string|max:10',
      'street_name' => 'nullable|string|max:50',
      'district_name' => 'nullable|string|max:50',
      'city' => 'nullable|string|max:50',
      'zip_code' => 'nullable|string|max:10',
      'secondary_number' => 'nullable|string|max:10',
      'country_id' => 'nullable',
      'home_country_id' => 'nullable'
    ]);
    $validated['user_id'] = auth()->user()->id;
    $validated['type'] = 'international';
    Address::create($validated);
    return redirect('profile')->with('success', __('prfile.addressSuccess'));
  }

  public function updateNationalAddress(Request $request, string $id)
  {
    $validated = $request->validate([
      'building_no' => 'nullable|string|max:10',
      'street_name' => 'nullable|string|max:50',
      'district_name' => 'nullable|string|max:50',
      'city' => 'nullable|string|max:50',
      'zip_code' => 'nullable|string|max:10',
      'secondary_number' => 'nullable|string|max:10'
    ],[
      'building_no.max' => __('The building number must not be greater than 10 characters.'),
      'street_name.max' => __('The street name must not be greater than 50 characters.'),
      'district_name.max' => __('The district name must not be greater than 50 characters.'),
      'city.max' => __('The city name must not be greater than 50 characters.'),
      'zip_code.max' => __('The postal code must not be greater than 10 characters.'),
      'secondary_number.max' => __('The secondary number must not be greater than 10 characters.'),
    ]);
    Address::find($id)->update($validated);
    return redirect()->back()->with('success', __('profile.nAddressUpdated'));
  }

  public function updateAddress(Request $request, string $id)
  {
    $validated = $request->validate([
      'building_no' => 'nullable|string|max:10',
      'street_name' => 'nullable|string|max:50',
      'district_name' => 'nullable|string|max:50',
      'city' => 'nullable|string|max:50',
      'zip_code' => 'nullable|string|max:10',
      'secondary_number' => '',
      'country_id' => '',
      'home_country_id' => 'nullable'
    ],[
      'building_no.max' => __('The building number must not be greater than 10 characters.'),
      'street_name.max' => __('The street name must not be greater than 50 characters.'),
      'district_name.max' => __('The district name must not be greater than 50 characters.'),
      'city.max' => __('The city name must not be greater than 50 characters.'),
      'zip_code.max' => __('The postal code must not be greater than 10 characters.'),
    ]);
    // return dd(['home_country_id' => $validated['home_country_id']]);
    Address::find($id)->update($validated);
    User::find(auth()->user()->id)->update(['home_country_id' => $validated['home_country_id']]);
    return redirect()->back()->with('success', __('profile.addressUpdated'));
  }

  public function editProfile(Request $request, string $id)
  {
    // return dd($request->all(),$id);
    User::find($id)->update([
      'date_of_birth' => $request->date_of_birth,
      'place_of_birth_id' => $request->place_of_birth_id,
      'marital_status_id' => $request->marital_status_id
    ]);
    $mobile = Contact::where('user_id', auth()->user()->id)->where('type', '1')->first();
    if($mobile){
      $mobile->update([
        'contact' => $request->phone,
      ]);
    }else{
      Contact::create([
        'user_id' => auth()->user()->id,
        'contact' => $request->phone,
        'type' => '1'
      ]);
    }
    $email = Contact::where('user_id', auth()->user()->id)->where('type', '2')->first();
    if($email){
      $email->update([
        'contact' => $request->email,
      ]);
    }else{
      Contact::create([
        'user_id' => auth()->user()->id,
        'contact' => $request->email,
        'type' => '2'
      ]);
    }
    if($request->hasFile('picture')){
      $path = 'storage/profile/' . auth()->user()->empid . '.jpeg';
      if(file_exists($path)){
        unlink($path);
      }
      $request->file('picture')->storeAs('profile/', auth()->user()->empid . '.jpeg','public');
    }
    return redirect()->back()->with('success', __('profile.profileUpdated'));
  }

  public function deletePicture($id)
  {
    $path = 'storage/profile/' . auth()->user()->empid . '.jpeg';
    if(file_exists($path)){
      unlink($path);
    }
    return redirect()->back()->with('success', __('profile.imageDeleted'));
  }

  public function uploadPicture(Request $request)
  {
    if($request->hasFile('picture')){
      $path = 'storage/profile/' . auth()->user()->empid . '.jpeg';
      if(file_exists($path)){
        unlink($path);
      }
      $request->file('picture')->storeAs('profile/', auth()->user()->empid . '.jpeg','public');
      return redirect()->back()->with('success', 'You have updated your profile successfully');
    }
    return redirect()->back()->with('error', __('profile.noChosenImage'));
  }
}
