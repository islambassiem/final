@extends('layout.master')

@section('title')
  {{ __('Qualifications') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/qualifications.form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
@endsection

@section('h1')
  {{ __('Qualifications') }}
@endsection

@section('breadcrumb')
  {{ __('Qualifications / Add') }}
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
            <h5 class="card-title">{{ __('Qualification Details') }}</h5>

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

                <div class="row">
                  <div class="col-md-4">
                    <label for="qualification" class="form-label">{{ __('Qualification') }}</label>
                    <select id="qualification" class="form-select" name="qualification">
                      <option selected disabled>{{ __('Choose...') }}</option>
                      @foreach ($qualifications as $qualification)
                        <option value="{{ $qualification->id }}" @selected($qualification->id == old('qualification', $qualification->qualification))>{{  $qualification->{'qualification' . session('_lang') ?? 'en' } }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="qualification_type" class="form-label">{{ __('Study Type') }}</label>
                  <div></div>
                  <select id="qualification_type" class="form-select" name="study_type">
                    <option selected disabled>{{ __('Choose...') }}</option>
                    @foreach ($study_types as $type)
                      <option value="{{ $type->id }}" @selected($type->id == old('study_type', $qualification->study_type))>{{  $type->{'study_type' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="study_natures" class="form-label">{{ __('Study Nature') }}</label>
                  <select id="study_natures" class="form-select" name="study_natures">
                    <option selected disabled>{{ __('Choose...') }}</option>
                    @foreach ($study_natures as $type)
                      <option value="{{ $type->id }}" @selected($type->id == old('study_natures', $qualification->study_nature))>{{  $type->{'study_nature' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="date" class="form-label">{{ __('Graduation Date') }}</label>
                  <div class="col-sm-12">
                    <input type="date" class="form-control" id="date" name="graduation_date" value="{{ old('graduation_date',$qualification->graduation_date) }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="university" class="form-label">{{ __('University') }}</label>
                  <input type="text" class="form-control" id="university" name="graduation_university" value="{{ old('graduation_university', $qualification->graduation_university) }}">
                </div>

                <div class="col-md-6">
                  <label for="college" class="form-label">{{ __('College') }}</label>
                  <input type="text" class="form-control" id="college" name="graduation_college" value="{{ old('graduation_college',$qualification->graduation_college) }}">
                </div>

                <div class="col-md-6">
                  <label for="country" class="form-label">{{ __('Graduation Country') }}</label>
                  <select id="country" class="form-select" name="graduation_country">
                    <option selected disabled>{{ __('Choose...') }}</option>
                    @foreach ($countries as $country)
                      <option value="{{ $country->id }}" @selected($country->id ==  old('graduation_country',$qualification->graduation_country) )>{{  $country->{'country' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="city" class="form-label">{{ __('City') }}</label>
                  <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $qualification->city) }}">
                </div>

                <div class="col-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="attested" name="attested" @if (old('attested',$qualification->attested)) checked  @endif>
                    <label class="form-check-label" for="attested">{{ __('Attested for the Saudi Cultural Attache') }}</label>
                  </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                  <button type="button" class="btn btn-primary" id="next1">{{ __("Next") }}</button>
                </div>
              </div>

              <div class="row g-3 mt-3" id="phase2">

                <div class="col-md-12">
                  <label for="thesis" class="form-label">{{ __('Thesis / Disertation') }}</label>
                  <input type="text" class="form-control" id="thesis" name="thesis" value="{{ old('thesis',$qualification->thesis) }}">
                </div>

                <div class="col-md-7 offset-md-3">
                  <label for="domain" class="form-label">{{ __('Doamain') }}</label>
                  <select id="domain" class="form-select">
                    <option selected disabled>{{ __('Choose...') }}</option>
                    @foreach ($domains as $domain)
                      <option value="{{ $domain->code }}">{{  $domain->{'specialty' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-7 offset-md-3">
                  <label for="major" class="form-label">{{ __('Major') }}</label>
                  <select id="major" class="form-select"  name="major_id"></select>
                </div>

                <div class="col-md-7 offset-md-3">
                  <label for="minor" class="form-label">{{ __('Minor') }}</label>
                  <select id="minor" class="form-select" name="minor_id"></select>
                </div>

                <div class="d-flex justify-content-between my-3">
                  <button type="button" class="btn btn-danger" id="back1">{{ __("Back") }}</button>
                  <button type="button" class="btn btn-primary" id="next2">{{ __("Next") }}</button>
                </div>
              </div>

              <div class="row g-3 mt-3" id="phase3">
                <div class="col-md-3 offset-md-4">
                  <label for="gpa" class="form-label">{{ __('GPA') }}</label>
                  <div class="col-sm-12">
                    <input type="number" class="form-control" id="gpa" name="gpa" step="0.01" value="{{ old('gpa',$qualification->gpa) }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="gpa_type" class="form-label">{{ __('GPA Type') }}</label>
                  <select id="gpa_type" class="form-select" name="gpa_type">
                    <option selected disabled>{{ __('Choose...') }}</option>
                    @foreach ($gpa_types as $type)
                      <option value="{{ $type->id }}" @selected($type->id == old('gpa_type',$qualification->gpa_type))>{{  $type->{'gpa_type' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="rating" class="form-label">{{ __('Rating') }}</label>
                  <select id="rating" class="form-select" name="rating">
                    <option selected disabled>{{ __('Choose...') }}</option>
                    @foreach ($ratings as $rating)
                      <option value="{{ $rating->id }}" @selected($rating->id == old('rating', $qualification->rating))>{{  $rating->{'rating' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-12">
                  <label for="attachment" class="col-sm-2 col-form-label">{{ __('Attachment') }}</label>
                  <div class="col-sm-12">
                    <input class="form-control" type="file" id="attachment" name="attachment">
                  </div>
                </div>

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
      $('#domain').on('change.select2', function(e){
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        if(this.value){
          $.ajax({
            url: "{{ URL::to('major') }}/" + this.value,
            method: "POST",
            dataType: "json",
            success: function(data){
              $('#major').empty();
              $('#major').append("<option selected disabled>{{ __('Choose...') }}</option>");
              $('#minor').empty();
              $('#minor').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < data.length; i++) {
                const element = data[i];
                let major = element.specialty_en;
                if("{{ session('_lang') }}" == "_ar"){
                  major = element.specialty_ar
                }
                $('#major').append("<option value="+element.code+">"+major+"</option>");
              }
            }
          });
        }
      });
      $('#major').on('change.select2', function(e){
        let code = (this.value).substring(0,2)
        if(code){
          $.ajax({
            url: "{{ URL::to('minor') }}/" + code,
            method: "POST",
            dataType: "json",
            success: function (data){
              $('#minor').empty();
              $('#minor').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < data.length; i++) {
                const element = data[i];
                let minor = element.specialty_en;
                if("{{ session('_lang') }}" == "_ar"){
                  minor = element.specialty_ar
                }
                $('#minor').append("<option value="+element.code+">"+minor+"</option>")
              }
            }
          });
        }
      })
      $('#major').append("<option selected disabled>{{ __('Choose...') }}</option>");
      $('#minor').append("<option selected disabled>{{ __('Choose...') }}</option>");
    });
  </script>
@endsection
