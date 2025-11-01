@extends('admin.layout.master')

@section('title')
  {{ __('vacations.vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
  {{ __('vacations.vacations') }}
@endsection

@section('breadcrumb')
  {{ __('vacations.vacations') . ' / ' . __('global.add')}}
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif
  @if (session('message'))
    <div class="alert alert-warning" role="alert">
      {{ session('message') }}
    </div>
  @endif
  <section class="section">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card margin-auto">
          <div class="card-body">
            <h5 class="card-title">{{ __('vacations.addVacation') }}</h5>
            <form action="{{ route('admin.vacations.update', $vacation->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('POST')
              <div class="row">
                <div class="col-6">
                  <div class="mb-3">
                    <label for="start_date" class="required">{{ __('vacations.start') }}</label>
                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $vacation->start_date }}">
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="start_date" class="required">{{ __('vacations.end') }}</label>
                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $vacation->end_date }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="vacation_type" class="required">{{ __('vacations.type') }}</label>
                  <select class="form-select" name="vacation_type" id="vacation_type" style="width: 100%">
                    <option disabled selected>{{ __('global.select') }}</option>
                    @foreach ($types as $type)
                      <option value="{{ $type->id }}" id="{{ $type->id }}" @selected($type->id == $vacation->vacation_type)>{{ $type->{'vacation_type' . session('_lang')} }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12 d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">{{ __('global.submit') }}</button>
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
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      });

      let max = "{{ __('global.max') }}";
      let count = document.getElementById('letters_count');
      let notes = document.getElementById('notes');
      notes.addEventListener('keyup', function(){
        let char = this.value.length;
        count.innerHTML = `${max} ${char} / 255`;
      });
      count.innerHTML = `${max} ${notes.value.length} / 255`;
    });
  </script>
@endsection