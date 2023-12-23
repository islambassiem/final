@extends('layout.master')

@section('title')
  {{ __('Courses') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
  <style>
    .container{
      width: 800px;
    }
  </style>
@endsection

@section('h1')
  {{ __('Courses') }}
@endsection

@section('breadcrumb')
  {{ __('Courses / Add') }}
@endsection

@section('content')


<section class="section">
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('Course Details') }}</h5>

          <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
              <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="name" class="form-label required">{{ __('Course Name') }}</label>
                    <input type="text" class="form-control" name="name" maxlength="100" id="name" value="{{ old('name') }}">
                    <span class="text-secondary"><small id="nameSmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="issuer" class="form-label required">{{ __('Issuer') }}</label>
                    <input type="text" class="form-control" maxlength="100" name="issuer" id="issuer" value="{{ old('issuer') }}">
                    <span class="text-secondary"><small id="issuerSmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <label for="type" class="form-label required">{{ __('Course Type') }}</label>
                  <select class="form-select" id="type_add" name="type_id" style="width:100%">
                    <option selected disabled>{{ __('Select') }}</option>
                    @foreach ($types as $type)
                      <option value="{{ $type->id }}" @selected( $type->id == old('type->id'))>{{  $type->{'course_type' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <div class="mb-3">
                    <label for="courseDate" class="form-label required">{{ __('Couese Date') }}</label>
                    <input type="date" class="form-control" name="courseDate" value="{{ old('courseDate') }}">
                  </div>
                </div>
                <div class="col-4">
                  <div class="mb-3">
                    <label for="period" class="form-label">{{ __('Course Period') }}</label>
                    <input type="text" class="form-control" name="period" id="period" maxlength="20" value="{{ old('period') }}">
                    <span class="text-secondary"><small id="periodSmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <label for="country_id" class="form-label">{{ __('Country') }}</label>
                  <select class="form-select" id="country_id_add" name="country_id" style="width:100%">
                    <option selected disabled>{{ __('Select') }}</option>
                    @foreach ($countries as $country)
                      <option value="{{ $country->id }}" @selected( $country->id == old('country->id'))>{{  $country->{'country' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <div class="mb-3">
                    <label for="city" class="form-label">{{ __('City') }}</label>
                    <input type="text" class="form-control" name="city" maxlength="30" id="city" value="{{ old('city') }}">
                    <span class="text-secondary"><small id="citySmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <label for="attachment" class="col-sm-2 col-form-label">{{ __('Attachment') }}</label>
                  <div class="col-sm-12">
                    <input
                      type="file"
                      class="dropify"
                      id="attachment"
                      name="attachment"
                      data-height="100"
                      accept="image/*, .pdf">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col d-flex justify-content-end mt-3">
                  <button class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
  <script>
    $(document).ready(function (){
      $("#country_id_add").select2();
      $("#type_add").select2();

      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('Drag and drop or click to replace') }}",
          'remove':  "{{ __('Delete') }}",
          'error': "{{ __('Ooops, something wrong happended.') }}"
        }
      });

      let max = "{{ __('Max characters') }}";
      let name = document.getElementById('name');
      let nameSmall = document.getElementById('nameSmall');
      let issuer = document.getElementById('issuer');
      let issuerSmall = document.getElementById('issuerSmall');
      let period = document.getElementById('period');
      let periodSmall = document.getElementById('periodSmall');
      let city = document.getElementById('city');
      let citySmall = document.getElementById('citySmall');

      city.addEventListener('keyup', function(){
        let char = this.value.length;
        citySmall.innerHTML = `${max} ${char} / 30`;
      });
      citySmall.innerHTML = `${max} ${city.value.length} / 30`;

      period.addEventListener('keyup', function(){
        let char = this.value.length;
        periodSmall.innerHTML = `${max} ${char} / 20`;
      });
      periodSmall.innerHTML = `${max} ${period.value.length} / 20`;

      issuer.addEventListener('keyup', function(){
        let char = this.value.length;
        issuerSmall.innerHTML = `${max} ${char} / 100`;
      });
      issuerSmall.innerHTML = `${max} ${issuer.value.length} / 100`;

      name.addEventListener('keyup', function(){
        let char = this.value.length;
        nameSmall.innerHTML = `${max} ${char} / 100`;
      });
      nameSmall.innerHTML = `${max} ${name.value.length} / 100`;
    });

  </script>
@endsection