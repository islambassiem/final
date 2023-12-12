@extends('layout.master')

@section('title')
  {{ __('Courses') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
@endsection

@section('h1')
  {{ __('Courses') }}
@endsection

@section('breadcrumb')
  {{ __('Courses / All') }}
@endsection

@section('content')
<section class="section">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <a
        href="{{ route('courses.create') }}"
        class="btn btn-success">
        <i class="bi bi-plus-square-fill me-1"></i>
        {{ __('Add') }}
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger mt-5">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @if (count($courses) == 0)
            <div class="alert alert-danger my-5" role="alert">
              {{ __('There are no courses Registered') }}
            </div>
          @else
            <h5 class="card-title">{{ __('Courses') }}</h5>
            @if (session('success'))
              <div class="alert alert-success" role="alert">
                {{ session('success') }}
              </div>
            @endif
            @if (session('message'))
            <div class="alert alert-warning" role="alert">
              {{ session('message') }}
            </div>
            @endif
            <div class="accordion" id="accordionExample">
              @foreach ($courses as $course)
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $course->id }}" aria-expanded="true" aria-controls="collapse{{ $course->id }}">
                      {{ $course->name }}
                    </button>
                  </h2>
                  <div id="collapse{{ $course->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <div class="row">
                        <div class="col-md-4"><strong>{{ __('Course Issuer') }}</strong></div>
                        <div class="col-md-8">{{ $course->issuer }}</div>
                      </div><hr>
                      <div class="row">
                        <div class="col-md-2"><strong>{{ __('Country') }}</strong></div>
                        <div class="col-md-4">{{ $course->country->{'country' . session('_lang')} }}</div>
                        <div class="col-md-1"><strong>{{ __('City') }}</strong></div>
                        <div class="col-md-4">{{ $course->city }}</div>
                      </div><hr>
                      <div class="row">
                        <div class="col-md-2"><strong>{{ __('Date') }}</strong></div>
                        <div class="col-md-2">{{ $course->courseDate }}</div>
                        <div class="col-md-2"><strong>{{ __('Duration') }}</strong></div>
                        <div class="col-md-2">{{ $course->period }}</div>
                        <div class="col-md-2"><strong>{{ __('Type') }}</strong></div>
                        <div class="col-md-2">{{ $course->type->{'course_type' . session('_lang')} }}</div>
                      </div><hr>
                      <div class="row ">
                        <div class="col d-flex justify-content-end">
                          <a class="btn btn-info btn-sm mx-2"
                            href="{{ route('attachment.course', $course->id) }}">
                            <i class="bi bi bi-paperclip"></i> {{ __('Attachment') }}
                          </a>
                          <a class="btn btn-primary btn-sm mx-2"
                            href="{{ route('courses.edit', $course->id) }}"
                            {{-- data-bs-toggle="modal"
                            data-bs-target="#editCourse" --}}
                            data-id={{ $course->id }}
                            data-name="{{ $course->name }}"
                            data-issuer="{{ $course->issuer }}"
                            data-country="{{ $course->country_id }}"
                            data-city="{{ $course->city }}"
                            data-date="{{ $course->courseDate }}"
                            data-type="{{ $course->type_id }}"
                            data-period="{{ $course->period }}"
                            >
                            <i class="bi bi-pencil-square"></i> {{ __('Edit') }}
                          </a>
                          <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#delteConfirmation"
                            data-id={{ $course->id }}>
                            <i class="bi bi-trash3"></i> {{ __('Delete') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Add Modal -->
{{-- <div class="modal fade" id="addCourse" tabindex="-1" aria-labelledby="addCourseLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addCourseLabel">{{ __('Add a Course') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('courses.store') }}" method="POST" id="addForm">
          @csrf
          <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label">{{ __('Course Name') }}</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="issuer" class="form-label">{{ __('Issuer') }}</label>
                <input type="text" class="form-control" name="issuer" value="{{ old('issuer') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="courseDate" class="form-label">{{ __('Couese Date') }}</label>
                <input type="date" class="form-control" name="courseDate" value="{{ old('courseDate') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="period" class="form-label">{{ __('Course Period') }}</label>
                <input type="text" class="form-control" name="period" value="{{ old('period') }}">
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
                <input type="text" class="form-control" name="city" value="{{ old('city') }}">
              </div>
            </div>
            <div class="col-6">
              <label for="type" class="form-label">{{ __('Course Type') }}</label>
              <select class="form-select" id="type_add" name="type_id" style="width:100%">
                <option selected disabled>{{ __('Select') }}</option>
                @foreach ($types as $type)
                  <option value="{{ $type->id }}" @selected( $type->id == old('type->id'))>{{  $type->{'course_type' . session('_lang')} }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="addForm">{{ __('Add') }}</button>
      </div>
    </div>
  </div>
</div> --}}
<!-- Delete Modal -->
<div class="modal fade" id="delteConfirmation" tabindex="-1" aria-labelledby="delteConfirmationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('Delete Confirmation!') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="deleteForm">
          @csrf
          @method('delete')
          {{ __('Are you sure you want to delete the course?') }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-danger" form="deleteForm">{{ __('Yes, Delete') }}</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
{{-- <div class="modal fade" id="editCourse" tabindex="-1" aria-labelledby="editCourseLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editCourseLabel">{{ __('Edit the Course') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="editForm">
          @csrf
          @method('PUT')
          <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label">{{ __('Course Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="issuer" class="form-label">{{ __('Issuer') }}</label>
                <input type="text" class="form-control" id="issuer" name="issuer" value="{{ old('issuer') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="courseDate" class="form-label">{{ __('Couese Date') }}</label>
                <input type="date" class="form-control" id="courseDate" name="courseDate" value="{{ old('courseDate') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="period" class="form-label">{{ __('Course Period') }}</label>
                <input type="text" class="form-control" id="period" name="period" value="{{ old('period') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <label for="country_id" class="form-label">{{ __('Country') }}</label>
              <select class="form-select" id="country_id_edit" name="country_id" style="width:100%">
                <option selected disabled>{{ __('Select') }}</option>
                @foreach ($countries as $country)
                  <option value="{{ $country->id }}" @selected( $country->id == old('country->id'))>{{  $country->{'country' . session('_lang')} }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-4">
              <div class="mb-3">
                <label for="city" class="form-label">{{ __('City') }}</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
              </div>
            </div>
            <div class="col-6">
              <label for="type" class="form-label">{{ __('Course Type') }}</label>
              <select class="form-select" id="type_edit" name="type_id" style="width:100%">
                <option selected disabled>{{ __('Select') }}</option>
                @foreach ($types as $type)
                  <option value="{{ $type->id }}" @selected( $type->id == old('type->id'))>{{  $type->{'course_type' . session('_lang')} }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="editForm">{{ __('Update') }}</button>
      </div>
    </div>
  </div>
</div> --}}

@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script>
    $(document).ready(function (){
      $("#country_id_add").select2({
        dropdownParent: $('#addCourse')
      });

      $("#type_add").select2({
        dropdownParent: $('#addCourse')
      });

      $("#country_id_edit").select2({
        dropdownParent: $('#editCourse')
      });

      $("#type_edit").select2({
        dropdownParent: $('#editCourse')
      });

      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "courses/" + id;
      });

      $('#editCourse').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('editForm');
        $('#name').val(button.data('name'));
        $('#issuer').val(button.data('issuer'));
        $('#courseDate').val(button.data('date'));
        $('#period').val(button.data('period'));
        $('#city').val(button.data('city'));
        $('#country_id_edit').val(button.data('country'));
        $('#type_edit').val(button.data('type'));
        form.action = "courses/" + id;
      });

    });
  </script>
@endsection