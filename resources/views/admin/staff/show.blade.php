@extends('admin.layout.master')


@section('title')
  {{ __('head/staff.staff') }}
@endsection


@section('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <style>
    .profile-pic{
      max-height: 350px;
      min-width: 300px;
    }

    .label{
      font-weight: 600;
      color: rgba(1, 41, 112, 0.6);
      padding-top: 1rem;
      padding-bottom: 1rem
    }
  </style>
@endsection

@section('h1')
{{ __('head/staff.staff') }}
@endsection


@section('breadcrumb')
{{ __('head/staff.staff') }}
@endsection

@section('content')
  <section class="section">
    <div class="row d-flex align-items-center justify-content-between">
      <div class="col-md-6">
        <div class="card py-2">
          <div class="card-body pb-0">
            <div class="card-title mb-0">
              {{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.staff') }}" class="btn btn-danger">{{ __('global.back') }}</a>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">{{ __('profile.overview') }}</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#official">{{ __('admin/employee.professionalInformation') }}</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#salary">{{ __('admin/employee.salary') }}</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documents">{{ __('admin/employee.documents') }}</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              {{--  Profile Overview  --}}
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">{{ __('profile.details') }}</h5>

                <div class="row">
                  <div class="col-8">
                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.fullName') }}</div>
                      <div class="col-lg-9 col-md-8">{{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.country') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->nationality->{'country' . session('_lang')} }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.dob') }}</div>
                      <div class="col-lg-9 col-md-8">{{ date('d/m/Y', strtotime($user->date_of_birth)) }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.mobile') }}</div>
                      <div class="col-lg-9 col-md-8">{{ blank($mobile?->contact) ? __('N/A') : $mobile->contact }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.personalEmail') }}</div>
                      <div class="col-lg-9 col-md-8">{{ blank($email?->contact) ? __('N/A') : $email->contact }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.officialEmail') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.office') }}</div>
                      <div class="col-lg-9 col-md-8">{{ blank($office?->contact) ? __('N/A') : $office?->contact}}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.ext') }}</div>
                      <div class="col-lg-9 col-md-8">{{ blank($extension?->contact) ? __('N/A') : $extension?->contact }}</div>
                    </div>
                  </div>
                  <div class="col-4">
                    <img src="{{ $user->employeePicture($user->empid) }}" alt="" class="profile-pic">
                  </div>
                </div>

              </div>

              {{--  Official Information  --}}
              <div class="tab-pane fade profile-edit pt-3" id="official">

                <div class="row">
                  <div class="col-md-4">
                    <h5 class="card-title">{{ __('admin/employee.officialInformation') }}</h5>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.position') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->position?->position_ar }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.joiningDate') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->joining_date }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.department') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->section->{'section' . session('_lang')} }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.expiry') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->resignation_date }}</div>
                    </div>

                  </div>
                  <div class="col-4">
                    <h5 class="card-title">{{ __('admin/employee.natiobalID') }}</h5>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.ID') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->iqama($user->id)?->document_id }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.issue') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->iqama($user->id)?->place_of_issue }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.issueDate') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->iqama($user->id)?->date_of_issue }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.expiry') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->iqama($user->id)?->date_of_expiry }}</div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <h5 class="card-title">{{ __('admin/employee.passport') }}</h5>
                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.ID') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->passport($user->id)?->document_id }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.issue') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->passport($user->id)?->place_of_issue }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.issueDate') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->passport($user->id)?->date_of_issue }}</div>
                    </div>

                    <div class="row d-flex align-items-center">
                      <div class="col-lg-3 col-md-4 label">{{ __('admin/employee.expiry') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->passport($user->id)?->date_of_expiry }}</div>
                    </div>
                  </div>
                </div>
              </div>

              {{--  Salary  --}}
              <div class="tab-pane fade" id="salary">

                <div class="row d-flex align-items-center justifiy-content-between">
                  <div class="d-flex col-md-10 gap-3">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="title" class="fs-5">{{ __('salary.iban') }}</label>
                        <input type="text" name="" id="" class="form-control" readonly value="{{ $bank->iban ?? 'N/A' }}">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="title" class="fs-5">{{ __('salary.bankName') }}</label>
                        <input type="text" name="" id="" class="form-control" readonly value="{{ $bank?->bank->{'bank_name' . session('_lang')} }}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2 mt-3 d-flex flex-row-reverse">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editIBAN">{{ __('global.edit') }}</button>
                  </div>
                </div>




                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">{{ __('admin/employee.salary') }}</h5>
                </div>
                <div class="row">
                  <div class="col d-flex flex-row-reverse">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSalary">+ {{ __('global.add') }}</button>
                  </div>
                </div>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">{{ __('salary.basic') }}</th>
                      <th scope="col">{{ __('salary.housing') }}</th>
                      <th scope="col">{{ __('salary.transportation') }}</th>
                      <th scope="col">{{ __('salary.food') }}</th>
                      <th scope="col">{{ __('salary.package') }}</th>
                      <th scope="col">{{ __('salary.effective') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $c = 1; @endphp
                    @foreach ($salary as $item)
                      <tr>
                        <td>{{ $c }}</td>
                        <td>{{ $item->basic }}</td>
                        <td>{{ $item->housing }}</td>
                        <td>{{ $item->transportation }}</td>
                        <td>{{ $item->food }}</td>
                        <td>{{ $item->package() }}</td>
                        <td>{{ $item->effective }}</td>
                      </tr>
                      @php $c++; @endphp
                    @endforeach
                  </tbody>
                </table>
              </div>

              {{--  Documents  --}}
              <div class="tab-pane fade" id="documents">

                <div class="tab-pane fade show active profile-overview">
                  <h5 class="card-title">{{ __('admin/employee.documents') }}</h5>
                </div>
                <table class="table table-striped text-center">
                  <thead>
                    <tr>
                      <th scope="col" class="fw-bold">{{ __('documents.document') }}</th>
                      <th scope="col" class="fw-bold">{{ __('documents.docNum') }}</th>
                      <th scope="col" class="fw-bold">{{ __('documents.place') }}</th>
                      <th scope="col" class="fw-bold">{{ __('documents.issue') }}</th>
                      <th scope="col" class="fw-bold">{{ __('documents.expiry') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($documents as $document)
                      <tr>
                        <td>{{ $document->document_type_id >= 6 ? $document->description : $document->document->{'attachment_type' . session('_lang')} }}</td>
                        <td>{{ $document->document_id }}</td>
                        <td>{{ blank($document->place_of_issue) ? __("N/A") : $document->place_of_issue }}</td>
                        <td>{{ blank($document->date_of_issue) ? __("N/A") : $document->date_of_issue }}</td>
                        <td>{{ $document->date_of_expiry }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="tab-pane fade" id="national-address">
              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>
      </div>
    </div>
  </section>


{{--  Add Salary Modal  --}}
<div class="modal fade" id="addSalary" tabindex="-1" aria-labelledby="addSalaryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addSalaryLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.addSalary') }}" method="post" id="addSalaryForm">
          @csrf
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="basic" name="basic" placeholder="basic" value="{{ old('basic') }}">
            <label for="basic">{{ __('salary.basic') }}</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="housing" name="housing" placeholder="housing" value="{{ old('housing') }}">
            <label for="housing">{{ __('salary.housing') }}</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="transportation" placeholder="transportation" name="transportation" value="{{ old('transportation') }}">
            <label for="transportation">{{ __('salary.transportation') }}</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="food" name="food" placeholder="food" value="{{ old('food') }}">
            <label for="food">{{ __('salary.food') }}</label>
          </div>
          <div class="form-floating mb-3">
            <input type="date" class="form-control" id="effective" name="effective" placeholder="effective" value="{{ old('effective') }}">
            <label for="effective">{{ __('salary.effective') }}</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
        <button type="submit" form="addSalaryForm" class="btn btn-primary">{{ __('global.submit') }}</button>
      </div>
    </div>
  </div>
</div>

{{--  Edit IBAN Modal  --}}
<div class="modal fade" id="editIBAN" tabindex="-1" aria-labelledby="editIBANLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editIBANLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.editIBAN') }}" method="post" id="editIBANForm">
          @csrf
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="IBAN" name="iban" placeholder="IBAN" value="{{ old('IBAN', $bank->iban ?? '') }}">
            <label for="IBAN">{{ __('salary.iban') }}</label>
          </div>
          <div class="col-12 mb-3">
            <label for="bank" class="form-label">{{ __('salary.bankName') }}</label>
            <select class="form-select" id="bank" name="bank_id" style="width:100%">
              <option selected disabled>{{ __('global.select') }}</option>
                @foreach ($banks as $user_bank)
                  <option value="{{ $user_bank->id }}" @selected($user_bank->id == $bank?->bank_code)>{{ session('_lang') == '_en' ? $user_bank->bank_name_en : $user_bank->bank_name_ar }}</option>
                @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
        <button type="submit" form="editIBANForm" class="btn btn-primary">{{ __('global.submit') }}</button>
      </div>
    </div>
  </div>
</div>

@endsection


@section('script')
<script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('#bank').select2({
      dropdownParent: $('#editIBAN')
    });
  });
</script>
@endsection