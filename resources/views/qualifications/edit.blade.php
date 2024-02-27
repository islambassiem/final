@extends('layout.master')

@section('title')
  {{ __('qualifications.qualifications') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/qualifications.form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
  {{ __('qualifications.qualifications') }}
@endsection

@section('breadcrumb')
  {{ __('qualifications.qualifications') . ' / ' . __('global.edit') }}
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
      <div class="col d-flex justify-content-end mb-3">
        <a href="{{ route('qualifications.index') }}"
          class="btn btn-danger">
          <i class="bi bi-x-octagon-fill me-1"></i>
          {{ __('global.cancel') }}
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('qualifications.details') }}</h5>

            <div class="progress my-3">
              <div class="progress-bar progress-bar-striped bg-success progress-bar-animated"
                role="progressbar"
                id="progressBar"
                aria-valuemin="0"
                aria-valuemax="100">33%</div>
            </div>


            <form action="{{ route('qualifications.update', $q->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row g-3 mt-3" id="phase1">

                <div class="row">
                  <div class="col-md-4">
                    <label for="qualification" class="form-label required">{{ __('qualifications.qualification') }}</label>
                    <select id="qualification" class="form-select" name="qualification">
                      <option disabled>{{ __('global.select') }}</option>
                      @foreach ($qualifications as $qualification)
                        <option value="{{ $qualification->code }}" @selected($qualification->code == old('qualification', $q->qualification))>{{  $qualification->{'qualification' . session('_lang') ?? 'en' } }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="qualification_type" class="form-label">{{ __('qualifications.type') }}</label>
                  <div></div>
                  <select id="qualification_type" class="form-select" name="study_type">
                    <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($study_types as $type)
                      <option value="{{ $type->code }}" @selected($type->code == old('study_type', $q->study_type))>{{  $type->{'study_type' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="study_natures" class="form-label">{{ __('qualifications.nature') }}</label>
                  <select id="study_natures" class="form-select" name="study_nature">
                    <option disabled>{{ __('global.select') }}</option>
                    @foreach ($study_natures as $type)
                      <option value="{{ $type->code }}" @selected($type->code == old('study_nature', $q->study_nature))>{{  $type->{'study_nature' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="date" class="form-label">{{ __('qualifications.date') }}</label>
                  <div class="col-sm-12">
                    <input type="date" class="form-control" id="date" name="graduation_date" value="{{ old('graduation_date',$q->graduation_date) }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="university" class="form-label">{{ __('qualifications.university') }}</label>
                  <input type="text" class="form-control" id="university" name="graduation_university" maxlength="100" value="{{ old('graduation_university', $q->graduation_university) }}">
                  <span class="text-secondary"><small id="universitySmall"></small></span>
                </div>

                <div class="col-md-6">
                  <label for="college" class="form-label">{{ __('qualifications.college') }}</label>
                  <input type="text" class="form-control" id="college" name="graduation_college" maxlength="100" value="{{ old('graduation_college',$q->graduation_college) }}">
                  <span class="text-secondary"><small id="collegeSmall"></small></span>
                </div>

                <div class="col-md-6">
                  <label for="country" class="form-label required">{{ __('qualifications.country') }}</label>
                  <select id="country" class="form-select" name="graduation_country">
                    <option disabled>{{ __('global.select') }}</option>
                    @foreach ($countries as $country)
                      <option value="{{ $country->code }}" @selected($country->code ==  old('graduation_country',$q->graduation_country) )>{{  $country->{'country' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="city" class="form-label">{{ __('qualifications.city') }}</label>
                  <input type="text" class="form-control" id="city" name="city" maxlength="30" value="{{ old('city', $q->city) }}">
                  <span class="text-secondary"><small id="citySmall"></small></span>
                </div>

                <div class="col-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="attested" name="attested" @if (old('attested',$q->attested)) checked  @endif>
                    <label class="form-check-label" for="attested">{{ __('qualifications.attested') }}</label>
                  </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                  <button type="button" class="btn btn-primary" id="next1">{{ __('global.next') }}</button>
                </div>
              </div>

              <div class="row g-3 mt-3" id="phase2">

                <div class="col-md-12">
                  <label for="thesis" class="form-label">{{ __('qualifications.thesis') }}</label>
                  <input type="text" class="form-control" id="thesis" maxlength="255" name="thesis" value="{{ old('thesis',$q->thesis) }}">
                  <span class="text-secondary"><small id="thesisSmall"></small></span>
                </div>

                <div class="col-md-7 offset-md-3">
                  <label for="domain" class="form-label">{{ __('qualifications.domain') }}</label>
                  <select id="domain" class="form-select">
                    <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($domains as $domain)
                      <option value="{{ $domain->code }}">{{  $domain->{'specialty' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-7 offset-md-3">
                  <label for="major" class="form-label required">{{ __('qualifications.major') }}</label>
                  <select id="major" class="form-select" name="major_id"></select>
                </div>

                <div class="col-md-7 offset-md-3">
                  <label for="minor" class="form-label">{{ __('qualifications.minor') }}</label>
                  <select id="minor" class="form-select" name="minor_id"></select>
                </div>

                <div class="d-flex justify-content-between my-3">
                  <button type="button" class="btn btn-danger" id="back1">{{ __('global.back') }}</button>
                  <button type="button" class="btn btn-primary" id="next2">{{ __('global.next') }}</button>
                </div>
              </div>

              <div class="row g-3 mt-3" id="phase3">
                <div class="col-md-3 offset-md-4">
                  <label for="gpa" class="form-label">{{ __('qualifications.gpa') }}</label>
                  <div class="col-sm-12">
                    <input type="number" class="form-control" id="gpa" name="gpa" step="0.01" value="{{ old('gpa',$q->gpa) }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="gpa_type" class="form-label">{{ __('qualifications.gpaType') }}</label>
                  <select id="gpa_type" class="form-select" name="gpa_type">
                    <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($gpa_types as $type)
                      <option value="{{ $type->code }}" @selected($type->code == old('gpa_type',$q->gpa_type))>{{  $type->{'gpa_type' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="rating" class="form-label">{{ __('qualifications.rating') }}</label>
                  <select id="rating" class="form-select" name="rating">
                    <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($ratings as $rating)
                      <option value="{{ $rating->code }}" @selected($rating->code == old('rating', $q->rating))>{{  $rating->{'rating' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>

                @if (!$link)
                  <div class="col-md-12">
                    <label for="attachment" class="col-sm-2 col-form-label">{{ __('global.attachment') }}</label>
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
                @endif

                <div class="d-flex justify-content-between my-3">
                  <button type="button" class="btn btn-danger" id="back2">{{ __('global.back') }}</button>
                  <button type="submit" class="btn btn-primary" id="submit">{{ __('global.submit') }}</button>
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
  <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
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
              $('#major').append("<option selected disabled>{{ __('global.select') }}</option>");
              $('#minor').empty();
              $('#minor').append("<option selected disabled>{{ __('global.select') }}</option>");
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
              $('#minor').append("<option selected disabled>{{ __('global.select') }}</option>");
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
      $('#major').append("<option value='{{ old('>major_id',$q->major_id) }}' selected>{{ $q->major?->{'specialty' . session('_lang')} }}</option>");
      $('#minor').append("<option value='{{ old('>minor_id',$q->minor_id)}}' selected>{{ $q->minor?->{'specialty' . session('_lang')} }}</option>");

      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      })


      let max = "{{ __('global.max') }}";
      let university = document.getElementById('university');
      let universitySmall = document.getElementById('universitySmall');
      let college = document.getElementById('college');
      let colelgeSmall = document.getElementById('colelgeSmall');
      let city = document.getElementById('city');
      let citySmall = document.getElementById('citySmall');
      let thesis = document.getElementById('thesis');
      let thesisSmall = document.getElementById('thesisSmall');

      university.addEventListener('keyup', function(){
        let char = this.value.length;
        universitySmall.innerHTML = `${max} ${char} / 100`;
      });
      universitySmall.innerHTML = `${max} ${university.value.length} / 100`;

      college.addEventListener('keyup', function(){
        let char = this.value.length;
        collegeSmall.innerHTML = `${max} ${char} / 100`;
      });
      collegeSmall.innerHTML = `${max} ${college.value.length} / 100`;


      city.addEventListener('keyup', function(){
        let char = this.value.length;
        citySmall.innerHTML = `${max} ${char} / 30`;
      });
      citySmall.innerHTML = `${max} ${city.value.length} / 30`;


      thesis.addEventListener('keyup', function(){
        let char = this.value.length;
        thesisSmall.innerHTML = `${max} ${char} / 255`;
      });
      thesisSmall.innerHTML = `${max} ${thesis.value.length} / 255`;


    });
  </script>
@endsection