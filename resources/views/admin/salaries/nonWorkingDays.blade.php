@extends('admin.layout.master')

@section('title')
  {{ __('admin/salaries.nonWorkingDays') }}
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
{{ __('admin/salaries.nonWorkingDays') }}
@endsection

@section('breadcrumb')
  @include('admin.salaries.breadcrumb')
@endsection


@section('content')

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ __('admin/salaries.nonWorkingDays') }}
      </h5>
      @if (count($days) == 0)
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
              <th>{{ __('admin/salaries.cost_center') }}</th>
              <th>{{ __('admin/salaries.nonWorkingDays') }}</th>
              <th>{{ __('admin/salaries.type') }}</th>
            </tr>
          </thead>
          <tbody>
            @php $c = 1; @endphp
            @foreach ($days as $day)
              <tr>
                <td>{{ $c; }}</td>
                <td>{{ $day->user->empid }}</td>
                <td>{{ session('_lang') == '_en' ? $day->user->getFullEnglishNameAttribute : $day->user->getFullArabicNameAttribute }}</td>
                <td>{{ $day->user->cost_center }}</td>
                <td>{{ $day->days }}</td>
                <td>{{ $day->vacationType->{'vacation_type'. session('_lang')} }}</td>
              </tr>
              @php $c++; @endphp
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col d-flex justify-content-between">
      <a href="{{ route('admin.salaries.working', $month_id) }}" class="btn btn-danger">{{ __('global.back') }}</a>
      <a href="{{ route('admin.salaries.payables', $month_id) }}" class="btn btn-primary">{{ __('global.next') }}</a>
    </div>
  </div>
@endsection


@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>

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
      $('#table').dataTable({
        language: {
          url: file
        }
      });
    });
  </script>
@endsection
