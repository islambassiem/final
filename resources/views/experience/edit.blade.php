@extends('layout.master')

@section('title')
  {{ __('Experience') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/qualifications.form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/rich-format-text.css') }}">
@endsection

@section('h1')
  {{ __('Experience') }}
@endsection

@section('breadcrumb')
  {{ __('Experience / Edit') }}
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
        <a href="{{ route('experience.index') }}"
          class="btn btn-danger">
          <i class="bi bi-x-octagon-fill me-1"></i>
          {{ __('Cancel') }}
        </a>
      </div>
    </div>
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


            <form action="{{ route('experience.update', $e) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row g-3 mt-3" id="phase1">

                <div class="row py-2">
                  <div class="col-md-4">
                    <label for="institutions" class="form-label">{{ __('Insitiution Sector') }}</label>
                    <select id="institutions" class="form-select">
                      <option selected disabled>{{ __('Choose...') }}</option>
                      @foreach ($institutions as $institution)
                        <option value="{{ $institution->code }}" @selected($institution->code == old('institution_id', $e->institution_id))>{{  $institution->{'institute' . session('_lang') ?? 'en' } }}</option>
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
                        <option value="{{ $region->code }}" >{{  $region->{'city' . session('_lang') ?? 'en' } }}</option>
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

                <div class="row py-2">
                  <div class="col-md-4">
                    <label for="hiring_date" class="form-label">{{ __('Hiring Date') }}</label>
                    <input type="date" class="form-control" id="hiring_date" name="hiring_date" value="{{ old('hiring_date', $e->hiring_date) }}">
                  </div>
                  <div class="col-md-4">
                    <label for="joining_date" class="form-label">{{ __('Joining Date') }}</label>
                    <input type="date" class="form-control" id="joining_date" name="joining_date" value="{{ old('joining_date', $e->joining_date) }}">
                  </div>
                  <div class="col-md-4">
                    <label for="resignation_date" class="form-label">{{ __('Resegniation Date') }}</label>
                    <input type="date" class="form-control" id="resignation_date" name="resignation_date" value="{{ old('resignation_date', $e->resignation_date ) }}">
                  </div>
                </div>

                @if (auth()->user()->category_id == 1)
                  <div class="row py-2">
                    <div class="col-md-4">
                      <label for="appointment_type_id" class="form-label">{{ __('Appointment Type') }}</label>
                      <select id="appointment_type_id" class="form-select" name="appointment_type_id">
                        <option disabled>{{ __('Choose...') }}</option>
                        @foreach ($appointment_types as $type)
                          <option value="{{ $type->id }}" @selected($type->id == old('appointment_type_id', $e->appointment_type_id))>{{  $type->{'appointment_type' . session('_lang') ?? 'en' } }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="job_type_id" class="form-label">{{ __('Job Type') }}</label>
                      <select id="job_type_id" class="form-select" name="job_type_id">
                        <option selected disabled>{{ __('Choose...') }}</option>
                        @foreach ($job_types as $type)
                          <option value="{{ $type->id }}" @selected($type->id == old('job_type_id', $e->job_type_id))>{{  $type->{'job_type' . session('_lang') ?? 'en' } }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="employment_status_id" class="form-label">{{ __('Employment Status') }}</label>
                      <select id="employment_status_id" class="form-select" name="employment_status_id">
                        <option selected disabled>{{ __('Choose...') }}</option>
                        @foreach ($employment_status as $status)
                          <option value="{{ $status->id }}" @selected($status->id == old('employment_status_id', $e->employment_status_id))>{{  $status->{'employment_status' . session('_lang') ?? 'en' } }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row py-2">
                    <div class="col-md-4">
                      <label for="domain" class="form-label">{{ __('Doamain') }}</label>
                      <select id="domain" class="form-select">
                        <option selected disabled>{{ __('Choose...') }}</option>
                        @foreach ($domains as $domain)
                          <option value="{{ $domain->code }}">{{  $domain->{'specialty' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="major" class="form-label">{{ __('Major') }}</label>
                      <select id="major" class="form-select"  name="major_id"></select>
                    </div>
                    <div class="col-md-4">
                      <label for="minor" class="form-label">{{ __('Minor') }}</label>
                      <select id="minor" class="form-select" name="minor_id"></select>
                    </div>
                    <div class="col-md-4">

                    </div>
                  </div>
                @endif

                <div class="row py-2">
                  @if (auth()->user()->category_id == 1)
                    <div class="col-md-4">
                      <label for="academic_rank_id" class="form-label">{{ __('Academic Rank') }}</label>
                      <select id="academic_rank_id" class="form-select" name="academic_rank_id">
                        <option selected disabled>{{ __('Choose...') }}</option>
                        @foreach ($academic_ranks as $rank)
                          <option value="{{ $rank->id }}" @selected($rank->id == old('academic_rank_id', $e->academic_rank_id))>{{  $rank->{'rank' . session('_lang') ?? 'en' } }}</option>
                        @endforeach
                      </select>
                    </div>
                  @else
                    <div class="col-md-4">
                      <label for="professional_rank_id" class="form-label">{{ __('Professional Rank') }}</label>
                      <select id="professional_rank_id" class="form-select" name="professional_rank_id">
                        <option selected disabled>{{ __('Choose...') }}</option>
                        @foreach ($professional_ranks as $rank)
                          <option value="{{ $rank->id }}" @selected($rank->id == old('professional_rank_id', $e->professional_rank_id)) >{{  $rank->{'rank' . session('_lang') ?? 'en' } }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="accommodation_status_id" class="form-label">{{ __('Accommodation Status') }}</label>
                      <select id="accommodation_status_id" class="form-select" name="accommodation_status_id">
                        <option selected disabled>{{ __('Choose...') }}</option>
                        @foreach ($accommodation_types as $type)
                          <option value="{{ $type->id }}" @selected( $type->id == old('accommodation_status_id', $e->accommodation_status_id))>{{  $type->{'accommodation_status' . session('_lang') ?? 'en' } }}</option>
                        @endforeach
                      </select>
                    </div>
                  @endif
                  <div class="col-md-4">
                    <label for="position" class="form-label">{{ __('Possition') }}</label>
                    <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $e->position) }}">
                  </div>
                </div>
                <div class="d-flex justify-content-between my-3">
                  <button type="button" class="btn btn-danger" id="back1">{{ __("Back") }}</button>
                  <button type="button" class="btn btn-primary" id="next2">{{ __("Next") }}</button>
                </div>

              </div>

              <div class="row g-3 mt-3" id="phase3">
                <div class="row">
                  <div class="col">
                    <div class="my-3">
                      {{-- <label for="tasks" class="form-label">{{ __('Tasks') }}</label>
                      <textarea class="form-control" id="tasks" rows="11" name="tasks">{{ old('tasks', $e->tasks) }}</textarea> --}}
                      <label for="tasks" class="form-label">{{ __('Tasks') }}</label>
											<div class="options">
												<!-- Text Format -->
												<button type="button" id="bold" class="option-button format button">
													<i class="fa-solid fa-bold"></i>
												</button>
												<button type="button" id="italic" class="option-button format button">
													<i class="fa-solid fa-italic"></i>
												</button>
												<button type="button" id="underline" class="option-button format button">
													<i class="fa-solid fa-underline"></i>
												</button>
												<button type="button" id="superscript" class="option-button script button">
													<i class="fa-solid fa-superscript"></i>
												</button>
												<button type="button" id="subscript" class="option-button script button">
													<i class="fa-solid fa-subscript"></i>
												</button>

												<!-- List -->
												<button type="button" id="insertOrderedList" class="option-button button">
													<div class="fa-solid fa-list-ol"></div>
												</button>

												<!-- Alignment -->
												<button type="button" id="justifyLeft" class="option-button align button">
													<i class="fa-solid fa-align-left"></i>
												</button>
												<button type="button" id="justifyCenter" class="option-button align button">
													<i class="fa-solid fa-align-center"></i>
												</button>
												<button type="button" id="justifyRight" class="option-button align button">
													<i class="fa-solid fa-align-right"></i>
												</button>
												<button type="button" id="justifyFull" class="option-button align button">
													<i class="fa-solid fa-align-justify"></i>
												</button>
												<button type="button" id="indent" class="option-button spacing button">
													<i class="fa-solid fa-indent"></i>
												</button>
												<button type="button" id="outdent" class="option-button spacing button">
													<i class="fa-solid fa-outdent"></i>
												</button>

											</div>
											<div id="text-input" contenteditable="true"></div>
                      <input type="hidden" class="form-control" id="tasks" name="tasks" value='{{ old('tasks', $e->tasks) }} '>
                    </div>
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
  <script src="{{ asset('assets/js/rich-format-text.js') }}"></script>
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
                $('#institution_id').append("<option value="+element.id+">"+institute+"</option>");
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
                $('#city').append("<option value="+element.id+">"+city+"</option>")
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
                $('#college_id').append("<option value="+element.id+">"+college+"</option>")
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
                $('#department_major').append("<option value="+element.id+">"+section+"</option>")
              }

            }
          });
        }
      });

      $("#department_major").on('change.select2', function(e){
        if(this.value){
          $.ajax({
            url: "{{ URL::to('department_minor/') }}/"+ this.value,
            method: "POST",
            data:{
              "_token": "{{ csrf_token() }}"
            },
            dataType: 'JSON',
            success:function(response){
              $('#department_minor').empty();
              $('#department_minor').append("<option selected disabled>{{ __('Choose...') }}</option>");
              for (let i = 0; i < response.length; i++) {
                const element = response[i];
                let section = element.section_en;
                if("{{ session('_lang') }}" == "_ar"){
                  section = element.section_ar
                }
                $('#department_minor').append("<option value="+element.id+">"+section+"</option>")
              }
            }
          });
        }
      });

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
                $('#major').append("<option value="+element.id+">"+major+"</option>");
              }
            }
          });
        }
      });

      $('#major').on('change.select2', function(e){
        let id = this.value;
        if(id){
          $.ajax({
            url: "{{ URL::to('minor') }}/" + id,
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
                $('#minor').append("<option value="+element.id+">"+minor+"</option>")
              }
            }
          });
        }
      })

      $('#institution_id').append("<option selected value='{{ $e->institution_id }}'>{{ $e->institution->{'institute' . session('_lang')} }}</option>");
      $('#college_id').append("<option selected value='{{ $e->college_id }}'>{{ $e->college->{'college' . session('_lang')} }}</option>");
      $('#department_major').append("<option selected disabled>{{ __('Choose...') }}</option>");
      $('#department_minor').append("<option selected value='{{ $e->section_id }}'>{{ $e->section->{'section' . session('_lang')} }}</option>");
      $('#governorate').append("<option selected disabled>{{ __('Choose...') }}</option>");
      $('#city').append("<option selected value='{{ $e->city_id }}'>{{ $e->city->{'city' . session('_lang')} }}</option>");
      $('#major').append("<option selected value='{{ $e->major_id }}'>{{ $e->major->{'specialty' . session('_lang')} }}</option>");
      $('#minor').append("<option selected value='{{ $e->minor_id }}'>{{ $e->minor->{'specialty' . session('_lang')} }}</option>");
      // $('#text-input').html("{{ old('tasks', $e->tasks) }}");
      document.getElementById('text-input').innerHTML = document.getElementById('tasks').value;
      document.getElementsByTagName("form")[0].addEventListener("submit", function () {
        document.getElementById("tasks").value = document.getElementById("text-input").innerHTML;
      });
    });
  </script>
@endsection
