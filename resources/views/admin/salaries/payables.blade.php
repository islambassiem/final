@extends('admin.layout.master')

@section('title')
  {{ __('admin/salaries.payables') }}
@endsection

@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
@endsection


@section('h1')
{{ __('admin/salaries.payables') }}
@endsection

@section('breadcrumb')
  @include('admin.salaries.breadcrumb')
@endsection


@section('content')
<div class="row">
  @if (! $status)
    <div class="col d-flex justify-content-end mb-3">
      <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#addPay"
        class="btn btn-success">
        <i class="bi bi-plus-square-fill me-1"></i>
        {{ __('global.add') }}
      </button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
</div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ __('admin/salaries.payables') }}
      </h5>
      @if (count($payables) == 0)
        <div class="alert alert-danger text-center">
          {{ __('admin/salaries.noSalaries') }}
        </div>
      @else
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('admin/salaries.empid') }}</th>
              <th>{{ __('admin/salaries.name') }}</th>
              <th>{{ __('admin/salaries.amount') }}</th>
              <th>{{ __('admin/salaries.description') }}</th>
            </tr>
          </thead>
          <tbody>
            @php $c = 1; @endphp
            @foreach ($payables as $payable)
              <tr>
                <td>{{ $c; }}</td>
                <td>{{ $payable->user->empid }}</td>
                <td>{{ session('_lang') == '_en' ? $payable->user->getFullEnglishNameAttribute : $payable->user->getFullArabicNameAttribute }}</td>
                <td>{{ $payable->amount }}</td>
                <td>{{ $payable->description }}</td>
              </tr>
              @php $c++; @endphp
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col d-flex justify-content-end">
      <a href="{{ route('admin.salaries.non.working', $month_id) }}" class="btn btn-danger mx-2"><i class="bi bi-caret-{{ session('_lang') == '_ar' ? 'right' : 'left'  }}-square-fill me-2"></i>{{ __('global.back') }}</a>
      <a href="{{ route('admin.salaries.dashboard', $month_id) }}" class="btn btn-secondary mx-2"><i class="bi bi-house-gear-fill mx-2"></i>{{ __('global.home') }}</a>
      <a href="{{ route('admin.salaries.deductables', $month_id) }}" class="btn btn-primary mx-2">{{ __('global.next') }}<i class="bi bi-caret-{{ session('_lang') == '_ar' ? 'left' : 'right'  }}-square-fill ms-2"></i></a>
    </div>
  </div>

  <div class="modal fade" id="addPay" tabindex="-1" aria-labelledby="addHolidayModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addHolidayLabel">{{ __('admin/salaries.addPay') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.salaries.payables.store') }}" method="POST" id="addForm">
            @csrf
            <input type="hidden" value="{{ $month_id }}" name="month_id">
            <div class="row">
              <div class="col-12 mb-3">
                <label for="user_id" class="form-label">{{ __('admin/salaries.employee') }}</label>
                <select class="form-select" id="user_id" name="user_id" style="width:100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->empid }} | {{ session('_lang') == '_en' ? $user->getFullEnglishNameAttribute : $user->getFullArabicNameAttribute }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mb-3">
                <label for="user_id" class="form-label">{{ __('admin/salaries.amount') }}</label>
                <input type="number" name="number" id="number" class="form-control" min="0" value="{{ old('number') }}">
              </div>
            </div>
            <div class="row">
              <div class="col mb-3 d-flex justify-content-between">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="unit" id="inlineRadio1" value="day" checked>
                  <label class="form-check-label" for="inlineRadio1">{{ __('admin/salaries.day') }}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="unit" id="inlineRadio2" value="hour">
                  <label class="form-check-label" for="inlineRadio2">{{ __('admin/salaries.hour') }}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="unit" id="inlineRadio3" value="riyal">
                  <label class="form-check-label" for="inlineRadio3">{{ __('admin/salaries.riyal') }}</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">{{ __('admin/salaries.description') }}</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{ old('description') }}</textarea>
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
      $("#user_id").select2({
        dropdownParent: $('#addPay')
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
