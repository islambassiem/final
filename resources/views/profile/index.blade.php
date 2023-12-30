@extends('layout.master')

@section('title')
  {{ __('profile.profile') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
{{ __('profile.profile') }}
@endsection

@section('breadcrumb')
{{ __('profile.profile') }}
@endsection

@section('content')
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="{{ auth()->user()->picture() }}" alt="Profile" class="rounded-circle">
            <h2 class="mt-2">{{ $user->{'first_name' . session('_lang')} . ' ' . $user->{'family_name' . session('_lang')} }}</h2>
            <h3 class="mt-3">{{ $user->position->{'position'. session('_lang')} }}</h3>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">{{ __('profile.overview') }}</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">{{ __('profile.edit') }}</button>
              </li>

              @if (auth()->user()->nationality_id != 1)
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#address">{{ __('profile.address') }}</button>
                </li>
              @endif

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#national-address">{{ __('profile.national') }}</button>
              </li>

              {{-- <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li> --}}

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">{{ __('profile.details') }}</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">{{ __('profile.fullName') }}</div>
                  <div class="col-lg-9 col-md-8">{{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('profile.position') }}</div>
                  <div class="col-lg-9 col-md-8">{{ $user->position?->{'position' . session('_lang')} }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('profile.country') }}</div>
                  <div class="col-lg-9 col-md-8">{{ $user->nationality->{'country' . session('_lang')} }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('profile.mobile') }}</div>
                  <div class="col-lg-9 col-md-8">{{ blank($mobile?->contact) ? __('N/A') : $mobile->contact }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('profile.personalEmail') }}</div>
                  <div class="col-lg-9 col-md-8">{{ blank($email?->contact) ? __('N/A') : $email->contact }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('profile.officialEmail') }}</div>
                  <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('profile.office') }}</div>
                  <div class="col-lg-9 col-md-8">{{ blank($office?->contact) ? __('N/A') : $office?->contact}}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('profile.ext') }}</div>
                  <div class="col-lg-9 col-md-8">{{ blank($extension?->contact) ? __('N/A') : $extension?->contact }}</div>
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form action="{{ route('upload.picture', auth()->user()->empid) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row mb-3">
                    <div for="profileImage" class="col-md-4 col-lg-3 col-form-label" style="font-weight:600; color:rgba(1, 41, 112, 0.6); ">{{ __('profile.image') }}</div>
                    <div class="col-md-8 col-lg-9">
                      <img src="{{ auth()->user()->picture() }}" alt="Profile" id="profileImage">
                      <div class="pt-2">
                        <button type="submit" class="btn btn-primary btn-sm mx-2" title="Upload new profile image" id="upload"><i class="bi bi-upload"></i></button>
                        <input type="file" name="picture" id="profilePic" style="display: none;">
                        <button type="button" class="btn btn-danger btn-sm" title="Remove my profile image" data-bs-toggle="modal" data-bs-target="#removePicture"><i class="bi bi-trash"></i></button>
                      </div>
                    </div>
                  </div>
                </form>
                <form action="{{ route('profile.edit', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">{{ __('profile.phone') }}</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="Phone" value="{{ blank($mobile?->contact) ? __('N/A') : $mobile->contact }}" autocomplete="off">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">{{ __('profile.personalEmail') }}</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Email" value="{{ blank($email?->contact) ? __('N/A') : $email->contact }}" autocomplete="off">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">{{ __('profile.dob') }}</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="date_of_birth" type="date" class="form-control" id="dob" value="{{ $user->date_of_birth }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">{{ __('profile.status') }}</label>
                    <div class="col-md-8 col-lg-9">
                        <select class="form-select" name="marital_status_id" id="maritalStatus" style="width: 100%">
                          <option disabled selected>{{ __('global.select') }}</option>
                          @foreach ($status as $s)
                            <option value="{{ $s->id }}" @selected($s->id == $user->marital_status_id)>{{ $s->{'marital_status' . session('_lang')} }}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">{{ __('profile.placeOfBirth') }}</label>
                    <div class="col-md-8 col-lg-9">
                        <select class="form-select" name="place_of_birth_id" id="placeOfBirth" style="width: 100%">
                          <option disabled selected>{{ __('global.select') }}</option>
                          @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @selected($country->id == $user->place_of_birth_id)>{{ $country->{'country' . session('_lang')} }}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>

                  {{-- <div class="row mb-3">
                    <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="twitter" type="text" class="form-control" id="Twitter" value="https://twitter.com/#">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="facebook" type="text" class="form-control" id="Facebook" value="https://facebook.com/#">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="instagram" type="text" class="form-control" id="Instagram" value="https://instagram.com/#">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="linkedin" type="text" class="form-control" id="Linkedin" value="https://linkedin.com/#">
                    </div>
                  </div> --}}

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('global.save') }}</button>
                  </div>
                </form><!-- End Profile Edit Form -->

              </div>

              <div class="tab-pane fade" id="address">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">{{ __('profile.addressDetails') }}</h5>
                  @if (blank($address))
                    <div class="alert alert-danger">
                      {{ __('profile.noAddress') }}
                    </div>
                    <div class="row">
                      <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddress">{{ __('global.add') }}</button>
                      </div>
                    </div>
                  @else
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.homeCountryID') }}</div>
                      <div class="col-lg-9 col-md-8">{{ blank($user->home_country_id) ? 'N/A' : $user->home_country_id}}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.buildingNumber') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $address?->building_no }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.street') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $address?->street_name }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.district') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $address?->district_name }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('prifile.city') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $address?->city }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.country') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $address->country?->{'country' . session('_lang')} }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.postalCode') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $address?->zip_code }}</div>
                    </div>

                    <div class="row">
                      <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAddress">{{ __('global.edit') }}</button>
                      </div>
                    </div>
                  @endif
                </div>

              </div>

              <div class="tab-pane fade" id="national-address">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">{{ __('profile.nationalAddressDetails') }}</h5>
                  @if (blank($national_address))
                    <div class="alert alert-danger">
                      {{ __('profile.noNational') }}
                    </div>
                    <div class="row">
                      <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNationalAddress">{{ __('global.add') }}</button>
                      </div>
                    </div>
                  @else
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.buildingNumber') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $national_address?->building_no }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.street') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $national_address?->street_name }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.district') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $national_address?->district_name }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.city') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $national_address?->city }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.postalCode') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $national_address?->zip_code }}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">{{ __('profile.secondaryNumber') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $national_address?->secondary_number }}</div>
                    </div>

                    <div class="row">
                      <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editNationalAddress">{{ __('global.edit') }}</button>
                      </div>
                    </div>
                  @endif

                </div>

              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                {{-- <form>

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form> --}}
                <!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>


    <!-- Add National Adrress Modal -->
    <div class="modal fade" id="addNationalAddress" tabindex="-1" aria-labelledby="addNationalAddressLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="addNationalAddressLabel">{{ __('profile.addNAddress') }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('national.address') }}" id="addNationalAddressForm" method="POST">
              @csrf
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="buildingNoNational" name="building_noNational" placeholder="{{ __('profile.buildingNumber') }}" autocomplete="off">
                <label for="buildingNoNational">{{ __('profile.buildingNumber') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="streetNational" name="street_name" placeholder="{{ __('profile.street') }}" autocomplete="off">
                <label for="streetNational">{{ __('profile.street') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="districtNational" name="district_name" placeholder="{{ __('profile.district') }}" autocomplete="off">
                <label for="district">{{ __('profile.district') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cityNational" name="city" placeholder="{{ __('profile.city') }}" autocomplete="off">
                <label for="cityNational">{{ __('profile.city') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="zip_codeNational" name="zip_code" placeholder="{{ __('profile.postalCode') }}" autocomplete="off">
                <label for="zip_codeNational">{{ __('profile.postalCode') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="secondary_numberNational" name="secondary_number" placeholder="{{ __('profile.secondaryNumber') }}" autocomplete="off">
                <label for="secondary_numberNational">{{ __('profile.secondaryNumber') }}</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
            <button type="submit" class="btn btn-primary" form="addNationalAddressForm">{{ __('global.save') }}</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit National Adrress Modal -->
    @if (!blank($national_address))
    <div class="modal fade" id="editNationalAddress" tabindex="-1" aria-labelledby="editNationalAddressLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editNationalAddressLabel">{{ __('profile.addNAddress') }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('national.address.edit', $national_address->id) }}" id="editNationalAddressForm" method="POST">
              @csrf
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="buildingNoNationalEdit" name="building_no" placeholder="{{ __('profile.buildingNumber') }}" value="{{ $national_address->building_no }}" autocomplete="off">
                <label for="buildingNoNationalEdit">{{ __('profile.buildingNumber') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="streetNationalEdit" name="street_name" placeholder="{{ __('profile.street') }}" value="{{ $national_address->street_name }}" autocomplete="off">
                <label for="streetNationalEdit">{{ __('profile.street') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="districtNationalEdit" name="district_name" placeholder="{{ __('profile.district') }}" value="{{ $national_address->district_name }}" autocomplete="off">
                <label for="districtNationalEdit">{{ __('profile.district') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cityNationalEdit" name="city" placeholder="{{ __('profile.city') }}" value="{{ $national_address->city }}" autocomplete="off">
                <label for="cityNationalEdit">{{ __('profile.city') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="zip_codeNationalEdit" name="zip_code" placeholder="{{ __('profile.postalCode') }}" value="{{ $national_address->zip_code }}" autocomplete="off">
                <label for="zip_codeNationalEdit">{{ __('profile.postalCode') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="secondary_numberNationalEdit" name="secondary_number" placeholder="{{ __('profile.secondaryNumber') }}" value="{{ $national_address->secondary_number }}" autocomplete="off">
                <label for="secondary_numberNationalEdit">{{ __('profile.secondaryNumber') }}</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
            <button type="submit" class="btn btn-primary" form="editNationalAddressForm">{{ __('global.save') }}</button>
          </div>
        </div>
      </div>
    </div>
    @endif


    <!-- Add Adrress Modal -->
    <div class="modal fade" id="addAddress" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="addAddressLabel">{{ __('profile.addAddress') }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('address') }}" id="addAddressForm" method="POST">
              @csrf
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="homeCountryIdAdd" name="home_country_id" placeholder="{{ __('profile.homeCountryID') }}" autocomplete="off">
                <label for="homeCountryIdAdd">{{ __('profile.homeCountryID') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="buildingNo" name="building_no" placeholder="{{ __('profile.buildingNumber') }}" autocomplete="off">
                <label for="buildingNo">{{ __('profile.buildingNumber') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="street" name="street_name" placeholder="{{ __('profile.street') }}" autocomplete="off">
                <label for="street">{{ __('profile.street') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="district" name="district_name" placeholder="{{ __('profile.district') }}" autocomplete="off">
                <label for="district">{{ __('profile.district') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="city" name="city" placeholder="{{ __('profile.city') }}" autocomplete="off">
                <label for="city">{{ __('profile.city') }}</label>
              </div>
              <div class="mb-3">
                <label for="countryAdd">{{ __('profile.country') }}</label>
                <select class="form-select" name="country_id" id="countryAdd" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->{'country' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="{{ __('profile.postalCode') }}" autocomplete="off">
                <label for="zip_code">{{ __('profile.postalCode') }}</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
            <button type="submit" class="btn btn-primary" form="addAddressForm">{{ __('global.save') }}</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit National Adrress Modal -->
    @if (!blank($address))
    <div class="modal fade" id="editAddress" tabindex="-1" aria-labelledby="editAddressLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editAddressLabel">{{ __('profile.addressDetails') }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('address.edit', $address->id) }}" id="editAddressForm" method="POST">
              @csrf
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="homeCountryIdEdit" name="home_country_id" placeholder="{{ __('profile.homeCountryID') }}" value="{{ $user->home_country_id }}" autocomplete="off">
                <label for="homeCountryIdEdit">{{ __('profile.homeCountryID') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="buildingNoEdit" name="building_no" placeholder="{{ __('profile.buildingNumber') }}" value="{{ $address->building_no }}" autocomplete="off">
                <label for="buildingNoEdit">{{ __('profile.buildingNumber') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="streetEdit" name="street_name" placeholder="{{ __('profile.street') }}" value="{{ $address->street_name }}" autocomplete="off">
                <label for="streetEdit">{{ __('profile.street') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="districtEdit" name="district_name" placeholder="{{ __('profile.district') }}" value="{{ $address->district_name }}" autocomplete="off">
                <label for="districtEdit">{{ __('profile.district') }}</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cityEdit" name="city" placeholder="{{ __('profile.city') }}" value="{{ $address->city }}" autocomplete="off">
                <label for="cityEdit">{{ __('profile.city') }}</label>
              </div>
              <div class="mb-3">
                <label for="countryEdit">{{ __('profile.country') }}</label>
                <select class="form-select" name="country_id" id="countryEdit" style="width: 100%">
                  <option disabled>{{ __('global.select') }}</option>
                  @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected($country->id == $address->country_id)>{{ $country->{'country' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="zip_codeEdit" name="zip_code" placeholder="{{ __('profile.postalCode') }}" value="{{ $address->zip_code }}" autocomplete="off">
                <label for="zip_codeEdit">{{ __('profile.postalCode') }}</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
            <button type="submit" class="btn btn-primary" form="editAddressForm">{{ __('global.save') }}</button>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Remove Picture Modal -->
    <div class="modal fade" id="removePicture" tabindex="-1" aria-labelledby="removePictureLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="removePictureLabel">{{ __('profile.removepic') }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('delete.picture', auth()->user()->empid) }}" method="post" id="deleteForm">
              @csrf
              @method('delete')
              {{ __('global.deleteConfirmation') }}
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.cancel') }}</button>
            <button type="submit" class="btn btn-danger" form="deleteForm">{{ __('global.delete') }}</button>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script>
    $("#countryAdd").select2({
      dropdownParent: $('#addAddress')
    });
    $("#countryEdit").select2({
      dropdownParent: $('#editAddress')
    });

    $("#placeOfBirth").select2();
    $("#maritalStatus").select2();

    document.getElementById('profileImage').onclick = function (){
      document.getElementById('profilePic').click()
    }

    document.getElementById('profilePic').addEventListener('change', function(){
      const file = this.files[0];
      if(file){
        const reader = new FileReader();
        reader.addEventListener('load', function(){
          document.getElementById('profileImage').setAttribute('src', this.result)
        });
        reader.readAsDataURL(file);

      }
    });
  </script>
@endsection