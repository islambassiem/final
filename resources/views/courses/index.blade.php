@extends('layout.master')

@section('title')
  {{ __('courses.courses') }}it
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
@endsection

@section('h1')
  {{ __('courses.courses') }}
@endsection

@section('breadcrumb')
  {{ __('courses.courses')  . ' / ' . __('global.all')}}
@endsection

@section('content')
<section class="section">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <a
        href="{{ route('courses.create') }}"
        class="btn btn-success">
        <i class="bi bi-plus-square-fill me-1"></i>
        {{ __('global.add') }}
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
              {{ __('courses.noCourses') }}
            </div>
          @else
            <h5 class="card-title">{{ __('courses.courses') }}</h5>
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
                        <div class="col-md-4"><strong>{{ __('courses.issuer') }}</strong></div>
                        <div class="col-md-8">{{ $course->issuer }}</div>
                      </div><hr>
                      <div class="row">
                        <div class="col-md-2"><strong>{{ __('courses.country') }}</strong></div>
                        <div class="col-md-4">{{ $course->country->{'country' . session('_lang')} }}</div>
                        <div class="col-md-1"><strong>{{ __('courses.city') }}</strong></div>
                        <div class="col-md-4">{{ $course->city }}</div>
                      </div><hr>
                      <div class="row">
                        <div class="col-md-2"><strong>{{ __('courses.date') }}</strong></div>
                        <div class="col-md-2">{{ $course->courseDate }}</div>
                        <div class="col-md-2"><strong>{{ __('courses.duration') }}</strong></div>
                        <div class="col-md-2">{{ $course->period }}</div>
                        <div class="col-md-2"><strong>{{ __('courses.type') }}</strong></div>
                        <div class="col-md-2">{{ $course->type->{'course_type' . session('_lang')} }}</div>
                      </div><hr>
                      <div class="row ">
                        <div class="col d-flex justify-content-end">
                          <a class="btn btn-info btn-sm mx-2"
                            href="{{ route('attachment.course', $course->id) }}">
                            <i class="bi bi bi-paperclip"></i> {{ __('global.attachment') }}
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
                            <i class="bi bi-pencil-square"></i> {{ __('global.edit') }}
                          </a>
                          <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#delteConfirmation"
                            data-id={{ $course->id }}>
                            <i class="bi bi-trash3"></i> {{ __('global.del') }}
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

<!-- Delete Modal -->
<div class="modal fade" id="delteConfirmation" tabindex="-1" aria-labelledby="delteConfirmationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('global.delConf') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="deleteForm">
          @csrf
          @method('delete')
          {{ __('global.deleteConfirmation') }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
        <button type="submit" class="btn btn-danger" form="deleteForm">{{ __('global.delete') }}</button>
      </div>
    </div>
  </div>
</div>

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