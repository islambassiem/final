@extends('admin.layout.master')


@section('title')
  {{ __('head/staff.staff') }}
@endsection


@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}" />
@endsection

@section('h1')
{{ __('head/staff.staff') }}
@endsection


@section('breadcrumb')
{{ __('head/staff.staff') . ' / ' . __('global.add') }}
@endsection

@section('content')
  <section class="section">
    <form action="{{ route('admin.employee.draft') }}" method="post">
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
              <div class="form-floating mb-3">
                <input type="number" class="form-control" name="empid" id="empid" placeholder="" min="{{ $empid + 1 }}" value="{{ $empid + 1 }}">
                <label for="empid">{{ __('admin/staff.empid') }}</label>
              </div>
            </div>
          </div>
          <hr>


          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.name') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="first_name_en" id="first_name_en" placeholder="">
                <label for="first_name_en">{{ __('admin/staff.first_name_en') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="second_name_en" id="second_name_en" placeholder="">
                <label for="second_name_en">{{ __('admin/staff.second_name_en') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="third_name_en" id="third_name_en" placeholder="">
                <label for="third_name_en">{{ __('admin/staff.third_name_en') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="family_name_en" id="family_name_en" placeholder="">
                <label for="family_name_en">{{ __('admin/staff.family_name_en') }}</label>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="first_name_ar" id="first_name_ar" placeholder="">
                <label for="first_name_ar">{{ __('admin/staff.first_name_ar') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="second_name_ar" id="second_name_ar" placeholder="">
                <label for="second_name_ar">{{ __('admin/staff.second_name_ar') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="third_name_ar" id="third_name_ar" placeholder="">
                <label for="third_name_ar">{{ __('admin/staff.third_name_ar') }}</label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="family_name_ar" id="family_name_ar" placeholder="">
                <label for="family_name_ar">{{ __('admin/staff.family_name_ar') }}</label>
              </div>
            </div>

          </div>
          <hr>

          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.contacts') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input type="email" class="form-control" name="personal_email" id="personal_email" placeholder="">
                <label for="personal_email">{{ __('admin/staff.personal_email') }}</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="">
                <label for="email">{{ __('admin/staff.email') }}</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="">
                <label for="mobile">{{ __('admin/staff.mobile') }}</label>
              </div>
            </div>
          </div>
          <hr>

          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.personal') }}
            </h5>
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="mb-3">
                <label for="gender" class="form-label">{{ __('admin/staff.gender') }}</label>
                <select id="gender" name="gender_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}">{{ $gender->{'gender' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="nationality" class="form-label">{{ __('admin/staff.nationality') }}</label>
                <select id="nationality" name="nationality_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->{'country' . session('_lang')}  }}</option>
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
                    <option value="{{ $religion->id }}">{{ $religion->{'religion' . session('_lang')}  }}</option>
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
                    <option value="{{ $value->id }}">{{ $value->{'marital_status' . session('_lang')}  }}</option>
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
                    <option value="{{ $value->id }}">{{ $value->{'special_need' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="dob" class="form-label">{{ __('admin/staff.dob') }}</label>
                <input type="date" name="date_of_birth" id="dob" class="form-control">
              </div>
            </div>
          </div>
          <hr>


        </div>
      </div>
      <div class="row">
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">{{ __('admin/staff.save_draft') }}</button>
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
    $('select').select2();
  })
</script>
@endsection