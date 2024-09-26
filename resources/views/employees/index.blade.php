@extends('layout.master')

@section('title')
  {{ __('sidebar.employees-impersonate') }}
@endsection

@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
@endsection


@section('content')
<div class="card card-body">
  <div class="card-title">
    <h5 class="card-title">
      {{ __('head/staff.allStaff') }}
    </h5>
    <table class="table table-striped" id="table">
      <thead>
        <tr>
          <th scope="col">
          <th scope="col">{{ __('admin/staff.empid') }}</th>
          <th scope="col">{{ __('head/staff.name') }}</th>
          <th scope="col">{{ __('global.action') }}</th>
        </tr>
      </thead>
      <tbody>
        @php $c = 1; @endphp
        @foreach ($staff as $member)
          <tr>
            <td @if (! $member->active) class="text-danger" @endif>{{ $c }}</td>
            <td @if (! $member->active) class="text-danger" @endif>{{ $member->empid }}</td>
            <td @if (! $member->active) class="text-danger" @endif>{{ session('_lang') == '_ar' ? $member->getFullArabicNameAttribute : $member->getFullEnglishNameAttribute }}</td>
            <td @if (! $member->active) class="text-danger" @endif>
              <a href="{{ route('impersonate', $member) }}" class="btn btn-primary btn-sm py-0"><i class="bi bi-box-arrow-in-left"></i></a>
            </td>
          </tr>
          @php $c++; @endphp
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection


@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
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
