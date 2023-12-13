@extends('layout.master')

@section('title')
  {{ __('Vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
@endsection

@section('h1')
  {{ __('Vacations') }}
@endsection

@section('breadcrumb')
  {{ __('Vacations / Add') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card margin-auto">
          <div class="card-body">
            <h5 class="card-title">{{ __('Add a vacation') }}</h5>
            <form action="{{ route('vacations.store') }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('POST')
              <div class="row">
                <div class="col-6">
                  <div class="mb-3">
                    <label for="start_date">{{ __('Start Date') }}</label>
                    <input type="date" class="form-control" name="start_date" id="start_date">
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="start_date">{{ __('End Date') }}</label>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="vacation_type">{{ __('Vacation Type') }}</label>
                  <select class="form-select" name="vacation_type" id="vacation_type" style="width: 100%">
                    <option disabled selected>{{ __('Select') }}</option>
                    @foreach ($types as $type)
                      <option value="{{ $type->id }}" id="{{ $type->id }}">{{ $type->{'vacation_type' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="notes">{{ __('Notes') }}</label>
                  <textarea class="form-control" name="employee_notes" cols="30" rows="5" id="notes"></textarea>
                </div>
              </div>
              <div class="row" id="addAttachment">
                <div class="col-12">
                  <label for="attachment" class="col-sm-12 col-form-label">{{ __('Attachment') }}</label>
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
              <div class="row mt-3">
                <div class="col-12 d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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
      $("#vacation_type").select2();

      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('Drag and drop or click to replace') }}",
          'remove':  "{{ __('Delete') }}",
          'error': "{{ __('Ooops, something wrong happended.') }}"
        }
      });
    });
  </script>
@endsection