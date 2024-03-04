@extends('admin.layout.master')


@section('title')
  {{ __('head/staff.staff') }}
@endsection


@section('style')
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

            </ul>
            <div class="tab-content pt-2">

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

              <div class="tab-pane fade" id="salary">

                <div class="row">
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




                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">{{ __('admin/employee.salary') }}</h5>
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
@endsection


@section('script')
@endsection