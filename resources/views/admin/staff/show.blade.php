@extends('admin.layout.master')


@section('title')
  {{ __('head/staff.staff') }}
@endsection


@section('style')
  <style>
    .profile-pic{
      max-height: 250px;
      min-width: 200px;
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
    <div class="row">
      <div class="col-md-6">
        <div class="card py-2">
          <div class="card-body pb-0">
            <div class="card-title mb-0 py-2">
              {{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}
            </div>
          </div>
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
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">{{ __('profile.edit') }}</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#address">{{ __('profile.address') }}</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#national-address">{{ __('profile.national') }}</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">{{ __('profile.details') }}</h5>

                <div class="row">
                  <div class="col-8">
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.fullName') }}</div>
                      <div class="col-lg-9 col-md-8">{{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}</div>
                    </div>
{{-- 
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">{{ __('profile.position') }}</div>
                      <div class="col-lg-9 col-md-8">{{ $user->position?->{'position' . session('_lang')} }}</div>
                    </div> --}}

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
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
              </div>

              <div class="tab-pane fade" id="address">
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">{{ __('profile.addressDetails') }}</h5>
                </div>
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