@extends('admin.layout.master')


@section('title')
  {{ __('admin/holiday.holidays') }}
@endsection


@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <style>
    #table{
      min-width: 1200px;
    }
  </style>
@endsection


@section('h1')
{{ __('admin/holiday.holidays') }}
@endsection

@section('breadcrumb')
{{ __('admin/holiday.holidays') .  ' / ' . __('global.all')}}
@endsection


@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#addHoliday"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('global.add') }}
        </button>
      </div>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('admin/holiday.holidays') }}
        </h5>
      @if (session('success'))
        <div class="alert alert-success">
          {{ __('admin/holiday.addedSuccess') }}
        </div>
      @endif
        @if (count($holidays) == 0)
          <div class="alert alert-danger text-center">
            {{ __('admin/holiday.noHoliday') }}
          </div>
        @else
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('admin/holiday.from') }}</th>
                <th>{{ __('admin/holiday.to') }}</th>
                <th>{{ __('admin/holiday.days') }}</th>
                <th>{{ __('admin/holiday.desc') }}</th>
                <th>{{ __('admin/holiday.branch') }}</th>
                <th>{{ __('admin/holiday.addedAt') }}</th>
              </tr>
            </thead>
            <tbody>
              @php $c = 1; @endphp
              @foreach ($holidays as $holiday)
                <tr>
                  <td>{{ $c }}</td>
                  <td>{{ $holiday->from }}</td>
                  <td>{{ $holiday->to }}</td>
                  <td>{{ $holiday->days() }}</td>
                  <td>{{ $holiday->description }}</td>
                  <td>{{ $holiday->branch->{'name' . session('_lang')} }}</td>
                  <td>{{ $holiday->created_at }}</td>
                </tr>
                @php $c++; @endphp
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </section>

  {{-- Add Holiday Model --}}
  <div class="modal fade" id="addHoliday" tabindex="-1" aria-labelledby="addHolidayModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addHolidayLabel">{{ __('admin/holiday.addHoliday') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.holiday.create') }}" method="POST" id="addForm">
            @csrf
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="from" class="form-label required">{{ __('admin/holiday.from') }}</label>
                  <input type="date" class="form-control" id="from" name="from" value="{{ old('from') }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="to" class="form-label required">{{ __('admin/holiday.to') }}</label>
                  <input type="date" class="form-control" id="to" name="to" value="{{ old('to') }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mb-3">
                <label for="branch_id" class="form-label">{{ __('admin/holiday.branch') }}</label>
                <select class="form-select" id="branch_id" name="branch_id" style="width:100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                  @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" @selected( $branch->id == old('branch_id'))>{{  $branch->{'name' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <label for="description" class="form-label">{{ __('admin/holiday.description') }}</label>
                  <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}" placeholder="{{ __('admin/holiday.description') }}">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
          <button type="submit" class="btn btn-primary" form="addForm">{{ __('global.add') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>

  <script>
    $(document).ready(function (){
      $("#branch_id").select2({
        dropdownParent: $('#addHoliday')
      });
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
    $('#table').dataTable({
      language: {
        url: file
      }
    });
    });
  </script>
@endsection