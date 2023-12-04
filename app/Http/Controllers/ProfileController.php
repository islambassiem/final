<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Tables\Country;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

  public function __construct()
  {
    return $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('profile.index', [
      'user' => User::find(auth()->user()->id),
      'national_address' => Address::where('user_id', auth()->user()->id)->where('type', 'national')->first(),
      'address' => Address::where('user_id', auth()->user()->id)->where('type', 'international')->first(),
      'countries' => Country::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function storeNationalAddress(Request $request)
  {
    $validated = $request->validate([
      'building_no' => 'nullable|string|max:10',
      'street_name' => 'nullable|string|max:50',
      'district_name' => 'nullable|string|max:50',
      'city' => 'nullable|string|max:50',
      'zip_code' => 'nullable|string|max:10',
      'secondary_number' => 'nullable|string|max:10'
    ]);
    $validated['user_id'] = auth()->user()->id;
    $validated['type'] = 'national';
    $validated['country_id'] = '1';
    Address::create($validated);
    return redirect('profile')->with('success', 'You have added your national address successfully');
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
      'country_id' => 'nullable'
    ]);
    $validated['user_id'] = auth()->user()->id;
    $validated['type'] = 'international';
    Address::create($validated);
    return redirect('profile')->with('success', 'You have added your address successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
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
    return redirect()->back()->with('success', 'You have updated your national address successfully');
  }

  public function updateAddress(Request $request, string $id)
  {
    $validated = $request->validate([
      'building_no' => 'nullable|string|max:10',
      'street_name' => 'nullable|string|max:50',
      'district_name' => 'nullable|string|max:50',
      'city' => 'nullable|string|max:50',
      'zip_code' => 'nullable|string|max:10',
      'secondary_number' => 'nullable|string|max:10',
      'country_id' => ''
    ],[
      'building_no.max' => __('The building number must not be greater than 10 characters.'),
      'street_name.max' => __('The street name must not be greater than 50 characters.'),
      'district_name.max' => __('The district name must not be greater than 50 characters.'),
      'city.max' => __('The city name must not be greater than 50 characters.'),
      'zip_code.max' => __('The postal code must not be greater than 10 characters.'),
      'secondary_number.max' => __('The secondary number must not be greater than 10 characters.'),
    ]);
    Address::find($id)->update($validated);
    return redirect()->back()->with('success', 'You have updated your address successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
