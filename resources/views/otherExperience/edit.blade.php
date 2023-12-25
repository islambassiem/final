@extends('layout.master')

@section('title')
  {{ __('otherExperience.otherExperience') }}
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
  {{ __('otherExperience.otherExperience') }}
@endsection

@section('breadcrumb')
  {{ __('otherExperience.otherExperience') . ' / '  . __('global.edit')}}
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
          <h5 class="card-title">{{ __('otherExperience.editOther') }}</h5>

          <form action="{{ route('other_experience.update', $experience->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container">
              <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
              <div class="row">
                <div class="col-md-8">
                  <div class="mb-3">
                    <label for="organization_name" class="form-label required">{{ __('otherExperience.organiztion') }}</label>
                    <input type="text" class="form-control" name="organization_name" maxlength="100" value="{{ old('organization_name', $experience->organization_name) }}">
                    <span class="text-secondary"><small id="organizationSmall"></small></span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="profession" class="form-label requied">{{ __('otherExperience.position') }}</label>
                    <input type="text" class="form-control" name="profession" maxlength="100" value="{{ old('profession',$experience->profession) }}">
                    <span class="text-secondary"><small id="professionSmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="section" class="form-label">{{ __('otherExperience.section') }}</label>
                    <input type="text" class="form-control" name="section" maxlength="100" value="{{ old('section', $experience->section) }}">
                    <span class="text-secondary"><small id="sectionSmall"></small></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="department" class="form-label">{{ __('otherExperience.department') }}</label>
                    <input type="text" class="form-control" name="department" maxlength="100" value="{{ old('department', $experience->department) }}">
                    <span class="text-secondary"><small id="departmentSmall"></small></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <label for="country_id" class="form-label">{{ __('otherExperience.country') }}</label>
                  <select class="form-select" id="country_id" name="country_id" style="width:100%">
                    <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($countries as $country)
                      <option value="{{ $country->id }}" @selected( $country->id == old('country->id', $experience->country_id))>{{  $country->{'country' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="city" class="form-label">{{ __('otherExperience.city') }}</label>
                    <input type="text" class="form-control" name="city" maxlength="30" value="{{ old('city', $experience->city) }}">
                    <span class="text-secondary"><small id="citySmall"></small></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="start_date" class="form-label required">{{ __('otherExperience.start') }}</label>
                    <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $experience->start_date) }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label for="end_date" class="form-label required">{{ __('otherExperience.end') }}</label>
                    <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $experience->end_date) }}">
                  </div>
                </div>
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

              <div class="row">
                <div class="col">
                  <div class="my-3">
                    <label for="functional_tasks" class="form-label">{{ __('otherExperience.tasks') }}</label>
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
                    <input type="hidden" id="functional_tasks" name="functional_tasks" value="{{ old('functional_tasks', $experience->tasks()) }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col d-flex justify-content-end">
                  <button class="btn btn-primary">{{ __('global.submit') }}</button>
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
    });

    document.getElementById('text-input').innerHTML = document.getElementById('functional_tasks').value;

    document.getElementsByTagName("form")[0].addEventListener("submit", function () {
      document.getElementById("functional_tasks").value = document.getElementById("text-input").innerHTML;
    });

    $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      });

      let max = "{{ __('global.max') }}";
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
        citySmall.innerHTML = `${max} ${char} / 100`;
      });
      citySmall.innerHTML = `${max} ${city.value.length} / 100`;

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