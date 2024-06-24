@extends('admin.layout.master')


@section('title')
  {{ __('vacations.vacations') }}
@endsection


@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
  <style>
    #table{
      min-width: 1200px;
    }
    ._icon{
      font-size: 100px !important;
    }
  </style>
@endsection

@section('h1')
{{ __('vacations.vacations') }}
@endsection


@section('breadcrumb')
{{ __('vacations.vacations') .  ' / ' . __('global.all')}}
@endsection

@section('content')
  <section class="section">
    <div class="row d-flex justify-content-center">
      <div class="col-md-3">
        <a href="{{ route('admin.pending.vacations') }}">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">
                {{ __('admin/vacations.pendingVacations') }}
              </h5>
              <div class="text-center text-info icon">
                <i class="bi bi-hourglass-top text-warning _icon"></i>
              </div>
              <div class="card-title text-center">{{ $pending }}</div>
              <div class="card-title text-center">{{ __('dashboard.days') }}</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('admin.search.vacations') }}">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">
                {{ __('admin/vacations.employeesVacation') }}
              </h5>
              <div class="text-center text-info icon">
                <i class="bi bi-search text-primary _icon"></i>
              </div>
              <div class="card-title text-center">{{ $vacations }}</div>
              <div class="card-title text-center">{{ __('admin/vacations.employees') }}</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="{{ route('admin.balance') }}">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">
                {{ __('admin/vacations.balance') }}
              </h5>
              <div class="text-center text-info icon">
                <i class="bi bi-bank text-secondary _icon"></i>
              </div>
              <div class="card-title text-center">{{ $balance }}</div>
              <div class="card-title text-center">{{ __('admin/vacations.employees') }}</div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>

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