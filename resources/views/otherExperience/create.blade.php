@extends('layout.master')

@section('title')
  {{ __('Other Experiences') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/rich-format-text.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
  <style>
    label.required{
      color: red;
      position: relative;
    }
    label.required::after{
      content: '*';
    }
  </style>
@endsection

@section('h1')
  {{ __('Other Experiences') }}
@endsection

@section('breadcrumb')
  {{ __('Other Experiences / Add') }}
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
          <h5 class="card-title">{{ __('Add Other Experience') }}</h5>

          <form action="{{ route('other_experience.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
              <div class="row">
                <div class="col-md-8">
                  <div class="mb-3">
                    <label for="organization_name" class="form-label required">{{ __('Organization Name') }}</label>
                    <input type="text" class="form-control" id="organization_name" maxlength="100" name="organization_name" value="{{ old('organization_name') }}">
                    <span class="text-secondary"><small id="organizationSmall"></small></span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="profession" class="form-label required">{{ __('Profession') }}</label>
                    <input type="text" class="form-control" id="profession" name="profession" maxlength="100" value="{{ old('profession') }}">
                    <span class="text-secondary"><small id="professionSmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="section" class="form-label">{{ __('Section') }}</label>
                    <input type="text" class="form-control" id="section" maxlength="100" name="section" value="{{ old('section') }}">
                    <span class="text-secondary"><small id="sectionSmall"></small></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="department" class="form-label">{{ __('Department') }}</label>
                    <input type="text" class="form-control" id="department" maxlength="100" name="department" value="{{ old('department') }}">
                    <span class="text-secondary"><small id="departmentSmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <label for="country_id" class="form-label required">{{ __('Country') }}</label>
                  <select class="form-select" id="country_id" name="country_id" style="width:100%">
                    <option selected disabled>{{ __('Select') }}</option>
                    @foreach ($countries as $country)
                      <option value="{{ $country->id }}" @selected( $country->id == old('country->id'))>{{  $country->{'country' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="city" class="form-label">{{ __('City') }}</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                    <span class="text-secondary"><small id="citySmall"></small></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="start_date" class="form-label required">{{ __('Start Date') }}</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="end_date" class="form-label required">{{ __('End Date') }}</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
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
                <div class="col">
                  <div class="my-3">
                    <span for="functional_tasks" class="form-label">{{ __('Tasks') }}</span>
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
                    <input type="hidden" class="form-control" id="functional_tasks" name="functional_tasks" value="{{ old('functional_tasks') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col d-flex justify-content-end">
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
  <script src="{{ asset('assets/js/rich-format-text.js') }}"></script>
  <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>

  <script>
    $(document).ready(function (){
      $("#country_id_add").select2();
      $("#type_add").select2();
      $("#country_id").select2();
    });

    document.getElementById('text-input').innerHTML = document.getElementById('functional_tasks').value;

    document.getElementsByTagName("form")[0].addEventListener("submit", function () {
      document.getElementById("functional_tasks").value = document.getElementById("text-input").innerHTML;
    });

    $('.dropify').dropify({
      messages: {
        'default': "",
        'replace': "{{ __('Drag and drop or click to replace') }}",
        'remove':  "{{ __('Delete') }}",
        'error': "{{ __('Ooops, something wrong happended.') }}"
        }
      });

      let max = "{{ __('Max characters') }}";
      let organization = document.getElementById('organization_name');
      let organizationSmall = document.getElementById('organizationSmall');
      let profession = document.getElementById('profession');
      let professionSmall = document.getElementById('professionSmall');
      let section = document.getElementById('section');
      let sectionSmall = document.getElementById('sectionSmall');
      let department = document.getElementById('department');
      let departmentSmall = document.getElementById('departmentSmall');
      let city = document.getElementById('city');
      let citySmall = document.getElementById('citySmall');

      city.addEventListener('keyup', function(){
        let char = this.value.length;
        citySmall.innerHTML = `${max} ${char} / 30`;
      });
      citySmall.innerHTML = `${max} ${city.value.length} / 30`;

      department.addEventListener('keyup', function(){
        let char = this.value.length;
        departmentSmall.innerHTML = `${max} ${char} / 100`;
      });
      departmentSmall.innerHTML = `${max} ${department.value.length} / 100`;

      section.addEventListener('keyup', function(){
        let char = this.value.length;
        sectionSmall.innerHTML = `${max} ${char} / 100`;
      });
      sectionSmall.innerHTML = `${max} ${section.value.length} / 100`;

      profession.addEventListener('keyup', function(){
        let char = this.value.length;
        professionSmall.innerHTML = `${max} ${char} / 100`;
      });
      professionSmall.innerHTML = `${max} ${profession.value.length} / 100`;

      organization.addEventListener('keyup', function(){
        let char = this.value.length;
        organizationSmall.innerHTML = `${max} ${char} / 100`;
      });
      organizationSmall.innerHTML = `${max} ${organization.value.length} / 100`;
  </script>
@endsection