@extends('layout.master')

@section('title')
  {{ __('vacations.vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
@endsection

@section('h1')
  {{ __('vacations.vacations') }}
@endsection

@section('breadcrumb')
  {{ __('vacations.vacations') . ' / ' . __('global.all')}}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end pb-2">
        <a
          href="{{ route('vacations.history') }}"
          class="btn btn-primary mx-2">
          <i class="bi bi-hourglass-split me-1"></i>
          {{ __('vacations.history') }}
        </a>
        <a
          href="{{ route('vacations.create') }}"
          class="btn btn-success mx-2">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('global.add') }}
        </a>
      </div>
    </div>
    @if (session('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    @endif
    <div class="row">
      <div class="col-md-4 mx-auto text-center">
        <div class="card mb-0">
          <div class="card-body">
            <div class="card-title text-center h3 mt-2">{{ __('vacations.balance') }}</div>
            <i class="bi bi-graph-down text-success fs-1"></i>
            <div class="h1">{{ $balance }}</div>
            <form action="{{ route('vacations.index') }}" method="get">
              @csrf
              <input type="date" name="tillDate" min="{{ date('Y-m-d') }}" class="form-control" value="{{ request()->has('tillDate') ? request()->get('tillDate') : ''}}">
              <input type="submit" value="{{ __('global.submit') }}" class="btn btn-secondary mt-3">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">
              {{ __('vacations.avAnnual') }}
            </h5>
            <div class="text-center"><i class="bi bi-calendar2-date-fill fs-1 text-info"></i></div>
            <div class="h1 text-center">{{ $availedAnnual }}</div>
            <div class="card-title text-center">{{ __('vacations.thisYear') }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">
              {{ __('vacations.avSick') }}
            </h5>
            <div class="text-center"><i class="bi bi-capsule-pill text-warning fs-1"></i></div>
            <div class="h1 text-center">{{ $availedSick }}</div>
            <div class="card-title text-center">{{ __('vacations.thisYear') }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">
              {{ __('vacations.absence') }}
            </h5>
            <div class="text-center text-danger"><i class="bi bi-emoji-tear-fill fs-1"></i></div>
            <div class="h1 text-center">{{ $availedAbsent }}</div>
            <div class="card-title text-center">{{ __('vacations.thisYear') }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
  <script>
    $(document).ready(function (){
      var lang = "{{ session('lang') }}";
      var file;
      switch (lang) {
        case "ar":
          file = "{{ asset('assets/vendor/datatables/ar.json') }}"
          break;
        case "pk":
          file = "{{ asset('assets/vendor/datatables/pk.json') }}"
          break;
        case "in":
          file = "{{ asset('assets/vendor/datatables/in.json') }}"
          break;
        case "ph":
          file = "{{ asset('assets/vendor/datatables/ph.json') }}"
          break;
        default:
          file = "{{ asset('assets/vendor/datatables/en.json') }}"
          break;
      }
      $('#vacationsTable').dataTable({
        language: {
          url: file
        }
      });

      $("#vacation_type").select2({
        dropdownParent: $('#addVacation')
      });



      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      });

      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "vacations/" + id;
      });
    });
  </script>
@endsection