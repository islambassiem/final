@extends('admin.layout.master')


@section('title')
  {{ __('head/staff.staff') }}
@endsection


@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}" />
  <style>
    .mt-15{
      margin-top: -15px;
    }
  </style>
@endsection

@section('h1')
{{ __('head/staff.staff') }}
@endsection


@section('breadcrumb')
{{ __('head/staff.staff') . ' / ' . __('global.add') }}
@endsection

@section('content')
  <section class="section">
    <form action="" method="post" id="form" autocomplete="false">
      @csrf
      <div class="card">
        <div class="card-body">


          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.empid') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-floating">
                <input type="number" class="form-control" name="empid" id="empid" placeholder="" min="{{ $empid + 1 }}" value="{{ $empid + 1 }}">
                <label for="empid">{{ __('admin/staff.empid') }}</label>
              </div>
            </div>
          </div>
          <hr>

          {{-- Name --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.name') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-floating">
                <input type="text" class="form-control" name="first_name_en" id="first_name_en" placeholder="" value="{{ old('first_name_en') }}">
                <label for="first_name_en">{{ __('admin/staff.first_name_en') }}</label>
              </div>
              <span class="text-danger">
                @error('first_name_en')
                  {{ $message }}
                @enderror
              </span>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="middle_name_en" id="middle_name_en" placeholder="" value="{{ old('middle_name_en') }}">
                <label for="middle_name_en">{{ __('admin/staff.middle_name_en') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="third_name_en" id="third_name_en" placeholder="" value="{{ old('third_name_en') }}">
                <label for="third_name_en">{{ __('admin/staff.third_name_en') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating">
                <input type="text" class="form-control" name="family_name_en" id="family_name_en" placeholder="" value="{{ old('family_name_en') }}">
                <label for="family_name_en">{{ __('admin/staff.family_name_en') }}</label>
              </div>
              <span class="text-danger">
                @error('family_name_en')
                  {{ $message }}
                @enderror
              </span>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="first_name_ar" id="first_name_ar" placeholder="" value="{{ old('first_name_ar') }}">
                <label for="first_name_ar">{{ __('admin/staff.first_name_ar') }}</label>
              </div>
              <span class="text-danger">
                @error('first_name_ar')
                  {{ $message }}
                @enderror
              </span>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="middle_name_ar" id="middle_name_ar" placeholder="" value="{{ old('middle_name_ar') }}">
                <label for="middle_name_ar">{{ __('admin/staff.middle_name_ar') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="third_name_ar" id="third_name_ar" placeholder="" value="{{ old('third_name_ar') }}">
                <label for="third_name_ar">{{ __('admin/staff.third_name_ar') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating">
                <input type="text" class="form-control" name="family_name_ar" id="family_name_ar" placeholder="" value="{{ old('family_name_ar') }}">
                <label for="family_name_ar">{{ __('admin/staff.family_name_ar') }}</label>
              </div>
              <span class="text-danger">
                @error('family_name_ar')
                  {{ $message }}
                @enderror
              </span>
            </div>

          </div>
          <hr>
          {{-- Contacts --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.contacts') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input type="email" class="form-control" name="personal_email" id="personal_email" placeholder="" value="{{ old('personal_email') }}">
                <label for="personal_email">{{ __('admin/staff.personal_email') }}</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <input type="email" class="form-control" name="email" id="email" placeholder="" value="{{ old('email') }}">
                <label for="email">{{ __('admin/staff.email') }}</label>
              </div>
              <span class="text-danger">
                @error('email')
                  {{ $message }}
                @enderror
              </span>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="" value="{{ old('mobile') }}">
                <label for="mobile">{{ __('admin/staff.mobile') }}</label>
              </div>
              <span class="text-danger">
                @error('mobile')
                  {{ $message }}
                @enderror
              </span>
            </div>
          </div>
          <hr>
          {{-- Personal --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.personal') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="">
                <label for="gender" class="form-label">{{ __('admin/staff.gender') }}</label>
                <select id="gender" name="gender_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}" @selected(old('gender_id') == $gender->id)>{{ $gender->{'gender' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
              <p class="text-danger mt-15">
                @error('gender_id')
                  {{ $message }}
                @enderror
              </p>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="nationality" class="form-label">{{ __('admin/staff.nationality') }}</label>
                <select id="nationality" name="nationality_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected(old('nationality_id') == $country->id)>{{ $country->{'country' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="religion" class="form-label">{{ __('admin/staff.religion') }}</label>
                <select id="religion" name="religion_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($religions as $religion)
                    <option value="{{ $religion->id }}" @selected(old('religion_id') == $religion->id)>{{ $religion->{'religion' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="mstatus" class="form-label">{{ __('admin/staff.mstatus') }}</label>
                <select id="mstatus" name="marital_status_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($mstatus as $value)
                    <option value="{{ $value->id }}" @selected(old('marital_status_id') == $value->id)>{{ $value->{'marital_status' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="disability" class="form-label">{{ __('admin/staff.disability') }}</label>
                <select id="disability" name="special_need_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($disability as $value)
                    <option value="{{ $value->id }}" @selected(old('special_need_id') == $value->id)>{{ $value->{'special_need' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="dob" class="form-label">{{ __('admin/staff.dob') }}</label>
                <input type="date" name="date_of_birth" id="dob" class="form-control" value="{{ old('date_of_birth') }}">
              </div>
              <p class="text-danger mt-15">
                @error('date_of_birth')
                  {{ $message }}
                @enderror
              </p>
            </div>
          </div>
          <hr>
          {{-- Official --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.official') }}
            </h5>
            <div class="row">
              <div class="col-md-5">
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="document_id1" id="document_id1" placeholder="" value="{{ old('document_id1') }}">
                    <label for="document_id1">{{ __('admin/staff.iqama') }}</label>
                  </div>
                  <p class="text-danger mt-15">
                    @error('document_id1')
                      {{ $message }}
                    @enderror
                  </p>
                </div>
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="place_of_issue1" id="place_of_issue1" placeholder="" value="{{ old('place_of_issue1') }}">
                    <label for="place_of_issue1">{{ __('admin/staff.place_of_issue') }}</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="date_of_issue1" class="form-label">{{ __('admin/staff.issue_date') }}</label>
                      <input type="date" name="date_of_issue1" id="date_of_issue1" class="form-control" value="{{ old('date_of_issue1') }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="expiry_date1" class="form-label">{{ __('admin/staff.expiry_date') }}</label>
                      <input type="date" name="date_of_expiry1" id="date_of_expiry1" class="form-control" value="{{ old('date_of_expiry1') }}">
                    </div>
                    <p class="text-danger mt-15">
                      @error('date_of_expiry1')
                        {{ $message }}
                      @enderror
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-2"></div>
              <div class="col-md-5">
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="document_id2" id="document_id2" placeholder="" value="{{ old('document_id2') }}">
                    <label for="document_id2">{{ __('admin/staff.passport') }}</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="place_of_issue2" id="place_of_issue2" placeholder="" value="{{ old('place_of_issue2') }}">
                    <label for="place_of_issue2">{{ __('admin/staff.place_of_issue') }}</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="date_of_issue2" class="form-label">{{ __('admin/staff.issue_date') }}</label>
                      <input type="date" name="date_of_issue2" id="date_of_issue2" class="form-control" value="{{ old('date_of_issue2') }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="date_of_expiry2" class="form-label">{{ __('admin/staff.expiry_date') }}</label>
                      <input type="date" name="date_of_expiry2" id="date_of_expiry2" class="form-control" value="{{ old('date_of_expiry2') }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          {{-- Employment --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.employment') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="">
                <label for="section" class="form-label">{{ __('admin/staff.department') }}</label>
                <select id="section" name="section_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($sections as $section)
                    <option value="{{ $section->id }}" @selected(old('section_id') == $section->id)>{{ $section->{'section' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
              <p class="text-danger mt-15">
                @error('section_id')
                  {{ $message }}
                @enderror
              </p>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="position" class="form-label">{{ __('admin/staff.position') }}</label>
                <select id="position" name="position_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}" @selected(old('position_id') == $position->id)>{{ $position->{'position' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
              <p class="text-danger mt-15">
                @error('position_id')
                  {{ $message }}
                @enderror
              </p>
            </div>
            <div class="col-md-3">
              <div class="">
                <label for="category" class="form-label">{{ __('admin/staff.category') }}</label>
                <select id="category" name="category_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->{'category'  . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
              <p class="text-danger mt-15">
                @error('category_id')
                  {{ $message }}
                @enderror
              </p>
            </div>
            <div class="col-md-3">
              <div class="">
                <label for="sponsorship" class="form-label">{{ __('admin/staff.sponsorship') }}</label>
                <select id="sponsorship" name="sponsorship_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($sponsorships as $sponsorship)
                    <option value="{{ $sponsorship->id }}" @selected(old('sponsorship_id') == $sponsorship->id)>{{ $sponsorship->{'sponsorship'  . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
              <p class="text-danger mt-15">
                @error('sponsorship_id')
                  {{ $message }}
                @enderror
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="mb-3">
                <label for="doj" class="form-label">{{ __('admin/staff.doj') }}</label>
                <input type="date" name="joining_date" id="doj" class="form-control" value="{{ old('joining_date') }}">
              </div>
              <p class="text-danger mt-15">
                @error('joining_date')
                  {{ $message }}
                @enderror
              </p>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="dor" class="form-label">{{ __('admin/staff.dor') }}</label>
                <input type="date" name="resignation_date" id="dor" class="form-control" value="{{ old('resignation_date') }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="vacation_class" class="form-label">{{ __('admin/staff.vacation_class') }}</label>
                <select id="vacation_class" name="vacation_class" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  <option value="0" @selected(old('vacation_class') == "0")>{{ __('admin/staff.noVac') }}</option>
                  <option value="21" @selected(old('vacation_class') == "21")>{{ __('admin/staff.21') }}</option>
                  <option value="30" @selected(old('vacation_class') == "30")>{{ __('admin/staff.30') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="cost_center" class="form-label">{{ __('admin/staff.cost_center') }}</label>
                <input type="text" name="cost_center" id="cost_center" class="form-control" value="{{ old('cost_center') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="salary" name="salary" @checked(old('salary') == 'on')>
                <label class="form-check-label" for="salary">{{ __('admin/staff.hasSalary') }}</label>
              </div>
            </div>
            <div class="col-md-12  mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="fingerprint" name="fingerprint" @checked(old('fingerprint') == 'on')>
                <label class="form-check-label" for="fingerprint">{{ __('admin/staff.fingerprint') }}</label>
              </div>
            </div>
            <div class="col-md-12  mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="married_contract" name="married_contract"  @checked(old('married_contract') == 'on')>
                <label class="form-check-label" for="married_contract">{{ __('admin/staff.married_contract') }}</label>
              </div>
            </div>
          </div>
          <hr>
          {{-- Financial --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.financial') }}
            </h5>
            <div class="row">
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="basic" class="form-label">{{ __('admin/staff.basic') }}</label>
                  <input type="number" min="0" name="basic" id="basic" class="form-control" value="{{ old('basic') }}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="housing" class="form-label">{{ __('admin/staff.housing') }}</label>
                  <input type="number" min="0" name="housing" id="housing" class="form-control" value="{{ old('housing') }}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="trans" class="form-label">{{ __('admin/staff.trans') }}</label>
                  <input type="number" min="0" name="trans" id="trans" class="form-control" value="{{ old('trans') }}">
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="food" class="form-label">{{ __('admin/staff.food') }}</label>
                  <input type="number" min="0" name="food" id="food" class="form-control" value="{{ old('food') }}" >
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="ticket" class="form-label">{{ __('admin/staff.ticket') }}</label>
                  <input type="number" min="0" name="ticket" id="ticket" class="form-control" value="{{ old('ticket') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="iban" class="form-label">{{ __('admin/staff.iban') }}</label>
                  <input type="text" name="iban" id="iban" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="bank" class="form-label">{{ __('admin/staff.bank') }}</label>
                  <select id="bank" name="bank_code" class="form-select" style="width: 100%">
                    <option disabled selected>{{ __('global.select') }}</option>
                    @foreach ($banks as $bank)
                      <option value="{{ $bank->id }}" @selected(old('bank_code') == $bank->id)>{{ $bank->{'bank_name' . session('_lang')}  }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          {{-- Notes --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.notes') }}
            </h5>
            <div class="row">
              <textarea name="notes" cols="30" rows="10"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="">
          <button type="submit" class="btn btn-danger" id="draftBtn">{{ __('admin/staff.save_draft') }}</button>
          <button type="submit" class="btn btn-primary" id="saveBtn">{{ __('admin/staff.save') }}</button>
        </div>
      </div>
    </form>
  </section>
@endsection


@section('script')
<script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script>
  $(document).ready(function(){
    let firstName = document.getElementById('first_name_en');
    let lastName = document.getElementById('family_name_en');
    let email = document.getElementById('email');
    let form = document.getElementById('form');
    $('select').select2();
    document.getElementById('draftBtn').addEventListener('click', function(e){
      e.preventDefault();
      form.action = "{{ route('admin.employee.draft') }}";
      form.submit();
    });
    document.getElementById('saveBtn').addEventListener('click', function(e){
      e.preventDefault();
      form.action = "{{ route('admin.employee.store') }}";
      form.submit();
    });

    lastName.addEventListener('blur', inaya);
    $('#category').on('change', shining);

    function shining(){
      if($('#category').val() == '4'){
        shiningEmail();
      }else{
        inaya();
      }
    }

    function inaya(){
      officail = firstName.value.toLowerCase().charAt(0)
        + lastName.value.toLowerCase()
        + '@inaya.edu.sa';
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ URL::to('admin/staff/email') }}/" + officail,
        method: "POST",
        dataType: "json",
        success: function(data){
          if(!data){
            email.value = firstName.value.toLowerCase().charAt(0)
              + '_'
              + lastName.value.toLowerCase()
              + '@inaya.edu.sa';
          }else if(data == 1){
            email.value = firstName.value.toLowerCase().charAt(0)
              + lastName.value.toLowerCase()
              + '@inaya.edu.sa';
          }
        }
      });
    }

    function shiningEmail(){
      officail = firstName.value.toLowerCase().charAt(0)
        + lastName.value.toLowerCase()
        + '.shdc'
        + '@inaya.edu.sa';
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ URL::to('admin/staff/email') }}/" + officail,
        method: "POST",
        dataType: "json",
        success: function(data){
          if(!data){
            email.value = firstName.value.toLowerCase().charAt(0)
              + '_'
              + lastName.value.toLowerCase()
              + '.shdc'
              + '@inaya.edu.sa';
          }else if(data == 1){
            email.value = firstName.value.toLowerCase().charAt(0)
              + lastName.value.toLowerCase()
              + '.shdc'
              + '@inaya.edu.sa';
          }
        }
      });
    }
  })
</script>
@endsection