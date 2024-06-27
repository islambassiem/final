@extends('layout.master')

@section('title')
  {{ __('head/vacations.vacations') }}
@endsection


@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <style>
    #table{
      min-width: 1200px;
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
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('head/vacations.filter') }}
        </h5>
        <form action="{{ route('teachingstaff.vacations.search') }}" method="get">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="user" class="form-label">{{ __('admin/vacations.employees')}}</label>
                <select class="form-select" id="user" name="user_id" style="width:100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>{{ $user->empid }} | {{ session('_lang') == '_en' ? $user->getFullEnglishNameAttribute : $user->getFullArabicNameAttribute }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <div class="col-md-4 mx-auto">
                <div class="mb-3">
                  <label for="from" class="form-label">{{ __('head/vacations.from') }}</label>
                  <input type="date" id="from" class="form-control" name="start" value="{{ request()->has('start') ? request()->get('start') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
              </div>
              <div class="col-md-4 mx-auto">
                <div class="mb-3">
                  <label for="to" class="form-label">{{ __('head/vacations.to') }}</label>
                  <input type="date" id="to" class="form-control" name="end" value="{{ request()->has('end') ? request()->get('end') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 d-flex justify-content-end align-items-center ms-auto">
              <a href="{{ route('teachingstaff.vacations.search') }}" class="btn btn-danger">{{ __('head/vacations.clear') }}</a>
              <button type="submit" class="btn btn-primary mx-2">{{ __('head/vacations.filter') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    @if (session('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    @endif
    @if (session('processed'))
      <div class="alert alert-danger">
        {{ session('processed') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        @if (count($vacations) == 0)
          <div class="alert alert-danger my-5" role="alert">
            {{ __('admin/vacations.novacations') }}
          </div>
        @else
          <h5 class="card-title">
            {{ __('head/vacations.filter') }}
          </h5>
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('admin/vacations.empid') }}</th>
                <th scope="col">{{ __('head/vacations.name') }}</th>
                <th scope="col">{{ __('head/vacations.from') }}</th>
                <th scope="col">{{ __('head/vacations.to') }}</th>
                <th scope="col">{{ __('head/vacations.type') }}</th>
                <th scope="col">{{ __('admin/vacations.headStatus') }}</th>
                <th scope="col">{{ __('admin/vacations.hrStatus') }}</th>
              </tr>
            </thead>
            <tbody>
              @php $c = 1; @endphp
              @foreach ($vacations as $vacation)
                <tr>
                  <td>{{ $c }}</td>
                  <td>{{ $vacation->user->empid }}</td>
                  <td>{{ session('_lang') == '_ar' ? $vacation->user->getFullArabicNameAttribute : $vacation->user->getFullEnglishNameAttribute }}</td>
                  <td>{{ $vacation->start_date }}</td>
                  <td>{{ $vacation->end_date }}</td>
                  <td>{{ $vacation->type->{'vacation_type' . session('_lang')} }}</td>
                  <td>
                    @switch($vacation->detail?->head_status)
                      @case(1)
                        <i class="bi bi-check-square-fill text-success fs-5"></i>
                        @break
                      @case(2)
                        <i class="bi bi-x-square-fill text-danger fs-5"></i>
                        @break
                      @default
                      <i class="bi bi-hourglass-top text-warning fs-5"></i>
                    @endswitch
                    <span class="mx-2">{{ $vacation->detail?->headStatus->{'workflow_status' . session('_lang')} }}</span>
                  </td>
                  <td>
                    @switch($vacation->detail?->hr_status)
                      @case(1)
                        <i class="bi bi-check-square-fill text-success fs-5"></i>
                        @break
                      @case(2)
                        <i class="bi bi-x-square-fill text-danger fs-5"></i>
                        @break
                      @default
                      <i class="bi bi-hourglass-top text-warning fs-5"></i>
                    @endswitch
                    <span class="mx-2">{{ $vacation->detail?->hrStatus->{'workflow_status' . session('_lang')} }}</span>
                  </td>
                </tr>
                @php $c++; @endphp
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </section>

@endsection


@section('script')
<script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function (){
      $('#user').select2();
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