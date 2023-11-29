@extends('layout.master')

@section('title')
  {{ __('Experience') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/qualifications.form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
@endsection

@section('h1')
  {{ __('Experience') }}
@endsection

@section('breadcrumb')
  {{ __('Experience / Add') }}
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
            <h5 class="card-title">{{ __('Experience Details') }}</h5>

            <div class="progress my-3">
              <div class="progress-bar progress-bar-striped bg-success progress-bar-animated"
                role="progressbar"
                id="progressBar"
                aria-valuemin="0"
                aria-valuemax="100">33%</div>
            </div>


            <form action="{{ route('qualifications.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row g-3 mt-3" id="phase1">

                <div class="row py-2">
                  <div class="col-md-4">
                    <label for="profession" class="form-label">{{ __('Possition') }}</label>
                    <input type="text" class="form-control" id="profession" name="profession" value="{{ old('profession') }}">
                  </div>
                </div>

                <div class="row py-2">
                  <div class="col-md-4">
                    <label for="institutions" class="form-label">{{ __('Insitiution Sector') }}</label>
                    <select id="institutions" class="form-select">
                      <option selected disabled>{{ __('Choose...') }}</option>
                      @foreach ($institutions as $institution)
                        <option value="{{ $institution->code }}">{{  $institution->{'institute' . session('_lang') ?? 'en' } }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-8">
                    <label for="institution_id" class="form-label">{{ __('Educational Insitiution') }}</label>
                    <select id="institution_id" class="form-select" name="institution_id"></select>
                  </div>
                </div>

                <div class="row py-2">
                  <div class="col-md-6">
                    <label for="college_classification" class="form-label">{{ __('College Classifications') }}</label>
                    <select id="college_classification" class="form-select">
                      <option selected disabled>{{ __('Choose...') }}</option>
                      @foreach ($college_classification as $college)
                        <option value="{{ $college->code }}">{{  $college->{'college' . session('_lang') ?? 'en' } }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="college_id" class="form-label">{{ __('College') }}</label>
                    <select id="college_id" class="form-select" name="college_id"></select>
                  </div>
                </div>

                <div class="row py-2">
                  <div class="col-md-4">
                    <label for="department_domain" class="form-label">{{ __('Level 1') }}</label>
                    <select id="department_domain" class="form-select">
                      <option selected disabled>{{ __('Choose...') }}</option>
                      @foreach ($department_domain as $department)
                        <option value="{{ $department->code }}">{{  $department->{'section' . session('_lang') ?? 'en' } }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="department_major" class="form-label">{{ __('Level 2') }}</label>
                    <select id="department_major" class="form-select"></select>
                  </div>
                  <div class="col-md-4">
                    <label for="department_minor" class="form-label">{{ __('Level 3') }}</label>
                    <select id="department_minor" class="form-select" name="section_id"></select>
                  </div>
                </div>

                <div class="row py-2">
                  <div class="col-md-4">
                    <label for="regions" class="form-label">{{ __('Region') }}</label>
                    <select id="regions" class="form-select">
                      <option selected disabled>{{ __('Choose...') }}</option>
                      @foreach ($regions as $region)
                        <option value="{{ $region->code }}">{{  $region->{'city' . session('_lang') ?? 'en' } }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="governorate" class="form-label">{{ __('Governorates') }}</label>
                    <select id="governorate" class="form-select"></select>
                  </div>
                  <div class="col-md-4">
                    <label for="city" class="form-label">{{ __('City') }}</label>
                    <select id="city" class="form-select" name="city_id"></select>
                  </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                  <button type="button" class="btn btn-primary" id="next1">{{ __("Next") }}</button>
                </div>
              </div>

              <div class="row g-3 mt-3" id="phase2">
                <div class="d-flex justify-content-between my-3">
                  <button type="button" class="btn btn-danger" id="back1">{{ __("Back") }}</button>
                  <button type="button" class="btn btn-primary" id="next2">{{ __("Next") }}</button>
                </div>
              </div>

              <div class="row g-3 mt-3" id="phase3">
                <div class="d-flex justify-content-between my-3">
                  <button type="button" class="btn btn-danger" id="back2">{{ __("Back") }}</button>
                  <button type="submit" class="btn btn-primary" id="submit">{{ __("Submit") }}</button>
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
  <script src="{{ asset('assets/js/qualifications.form.js') }}"></script>
  <script>
    $(document).ready(function (){
      $('#institutions').on('change.select2', function(e){
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        if(this.value){
          $.ajax({
            url: "{{ URL::to('institutions') }}/" + this.value,
            method: "POST",
            dataType: "json",
            success: function(data){
              $('#institution_id').empty();
              $('#institution_id').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < data.length; i++) {
                const element = data[i];
                let institute = element.institute_en;
                if("{{ session('_lang') }}" == "_ar"){
                  institute = element.institute_ar
                }
                $('#institution_id').append("<option value="+element.code+">"+institute+"</option>");
              }
            }
          });
        }
      });

      $('#regions').on('change.select2', function(e){
        let code = (this.value).substring(0,2)
        if(code){
          $.ajax({
            url: "{{ URL::to('governorate') }}/" + code,
            data: {
              "_token": "{{ csrf_token() }}",
            },
            method: "POST",
            dataType: "json",
            success: function (data){
              $('#governorate').empty();
              $('#city').empty();
              $('#governorate').append("<option selected disabled>{{ __('Choose...') }}</option>");
              $('#city').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < data.length; i++) {
                const element = data[i];
                let governorate = element.city_en;
                if("{{ session('_lang') }}" == "_ar"){
                  governorate = element.city_ar
                }
                $('#governorate').append("<option value="+element.code+">"+governorate+"</option>")
              }
            }
          });
        }
      });

      $('#governorate').on('change.select2', function(e){
        let code = (this.value).substring(0,4)
        if(code){
          $.ajax({
            url: "{{ URL::to('city') }}/" + code,
            data: {
              "_token": "{{ csrf_token() }}",
            },
            method: "POST",
            dataType: "json",
            success: function (data){
              $('#city').empty();
              $('#city').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < data.length; i++) {
                const element = data[i];
                let city = element.city_en;
                if("{{ session('_lang') }}" == "_ar"){
                  city = element.city_ar
                }
                $('#city').append("<option value="+element.code+">"+city+"</option>")
              }
            }
          });
        }
      });

      $("#college_classification").on('change.select2', function(e){
        if(this.value){
          $.ajax({
            url: "{{ URL::to('colleges/') }}/"+ this.value,
            method: "POST",
            data:{
              "_token": "{{ csrf_token() }}"
            },
            dataType: 'JSON',
            success:function(response){
              $('#college_id').empty();
              $('#college_id').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < response.length; i++) {
                const element = response[i];
                let college = element.college_en;
                if("{{ session('_lang') }}" == "_ar"){
                  college = element.college_ar
                }
                $('#college_id').append("<option value="+element.code+">"+college+"</option>")
              }

            }
          });
        }
      });

      $("#department_domain").on('change.select2', function(e){
        if(this.value){
          $.ajax({
            url: "{{ URL::to('department_major/') }}/"+ this.value,
            method: "POST",
            data:{
              "_token": "{{ csrf_token() }}"
            },
            dataType: 'JSON',
            success:function(response){
              $('#department_major').empty();
              $('#department_major').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < response.length; i++) {
                const element = response[i];
                let section = element.section_en;
                if("{{ session('_lang') }}" == "_ar"){
                  section = element.section_ar
                }
                $('#department_major').append("<option value="+element.code+">"+section+"</option>")
              }

            }
          });
        }
      });

      $("#department_major").on('change.select2', function(e){
        if(this.value){
          let code = (this.value).substring(0,2);
          $.ajax({
            url: "{{ URL::to('department_minor/') }}/"+ code,
            method: "POST",
            data:{
              "_token": "{{ csrf_token() }}"
            },
            dataType: 'JSON',
            success:function(response){
              console.log(response)
              $('#department_minor').empty();
              $('#department_minor').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < response.length; i++) {
                const element = response[i];
                let section = element.section_en;
                if("{{ session('_lang') }}" == "_ar"){
                  section = element.section_ar
                }
                $('#department_minor').append("<option value="+element.code+">"+section+"</option>")
              }
            }
          });
        }
      });



      $('select').append("<option selected disabled>{{ __('Choose...') }}</option>");
    });
  </script>
@endsection
