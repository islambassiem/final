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
    <form action="" method="post" id="form">
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

          {{-- Name --}}
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
          {{-- Contacts --}}
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
          {{-- Personal --}}
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
          {{-- Official --}}
          <div class="row">
            <h5 class="card-title my-0 mx-3">
              {{ __('admin/staff.official') }}
            </h5>
            <div class="row">
              <div class="col-md-5">
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="document_id1" id="document_id1" placeholder="">
                    <label for="document_id1">{{ __('admin/staff.iqama') }}</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="date_of_issue1" id="date_of_issue1" placeholder="">
                    <label for="date_of_issue1">{{ __('admin/staff.place_of_issue') }}</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="issue_date1" class="form-label">{{ __('admin/staff.issue_date') }}</label>
                      <input type="date" name="issue_date1" id="issue_date1" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="expiry_date1" class="form-label">{{ __('admin/staff.expiry_date') }}</label>
                      <input type="date" name="expiry_date1" id="expiry_date1" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-2"></div>
              <div class="col-md-5">
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="document_id2" id="document_id2" placeholder="">
                    <label for="document_id2">{{ __('admin/staff.passport') }}</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="date_of_issue2" id="date_of_issue2" placeholder="">
                    <label for="date_of_issue2">{{ __('admin/staff.place_of_issue') }}</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="issue_date2" class="form-label">{{ __('admin/staff.issue_date') }}</label>
                      <input type="date" name="issue_date2" id="issue_date2" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="expiry_date2" class="form-label">{{ __('admin/staff.expiry_date') }}</label>
                      <input type="date" name="expiry_date2" id="expiry_date2" class="form-control">
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
              <div class="mb-3">
                <label for="section" class="form-label">{{ __('admin/staff.department') }}</label>
                <select id="section" name="section_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->{'section' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="position" class="form-label">{{ __('admin/staff.position') }}</label>
                <select id="position" name="position_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->{'position' . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="category" class="form-label">{{ __('admin/staff.category') }}</label>
                <select id="category" name="category_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->{'category'  . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="sponsorship" class="form-label">{{ __('admin/staff.sponsorship') }}</label>
                <select id="sponsorship" name="sponsorship_id" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  @foreach ($sponsorships as $sponsorship)
                    <option value="{{ $sponsorship->id }}">{{ $sponsorship->{'sponsorship'  . session('_lang')}  }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="mb-3">
                <label for="doj" class="form-label">{{ __('admin/staff.doj') }}</label>
                <input type="date" name="joining_date" id="doj" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="dor" class="form-label">{{ __('admin/staff.dor') }}</label>
                <input type="date" name="resignation_date" id="dor" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="vacation_class" class="form-label">{{ __('admin/staff.vacation_class') }}</label>
                <select id="vacation_class" name="vacation_class" class="form-select" style="width: 100%">
                  <option disabled selected>{{ __('global.select') }}</option>
                  <option value="0">{{ __('admin/staff.noVac') }}</option>
                  <option value="21">{{ __('admin/staff.21') }}</option>
                  <option value="30">{{ __('admin/staff.30') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="cost_center" class="form-label">{{ __('admin/staff.cost_center') }}</label>
                <input type="text" name="cost_center" id="cost_center" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="salary" name="salary">
                <label class="form-check-label" for="salary">{{ __('admin/staff.hasSalary') }}</label>
              </div>
            </div>
            <div class="col-md-12  mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="fingerprint" name="fingerprint">
                <label class="form-check-label" for="fingerprint">{{ __('admin/staff.fingerprint') }}</label>
              </div>
            </div>
            <div class="col-md-12  mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="married_contract" name="married_contract">
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
                  <input type="number" min="0" value="0" name="basic" id="basic" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="housing" class="form-label">{{ __('admin/staff.housing') }}</label>
                  <input type="number" min="0" value="0" name="housing" id="housing" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="trans" class="form-label">{{ __('admin/staff.trans') }}</label>
                  <input type="number" min="0" value="0" ame="trans" id="trans" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="food" class="form-label">{{ __('admin/staff.food') }}</label>
                  <input type="number" min="0" value="0" name="food" id="food" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="ticket" class="form-label">{{ __('admin/staff.ticket') }}</label>
                  <input type="number" min="0" value="0" name="ticket" id="ticket" class="form-control">
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
                      <option value="{{ $bank->id }}">{{ $bank->{'bank_name' . session('_lang')}  }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
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
    $('select').select2();
    let form = document.getElementById('form')
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
  })
</script>
@endsection