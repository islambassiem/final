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
    {{-- <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('head/vacations.filter') }}
        </h5>
        <form action="{{ route('admin.vacations') }}" method="get">
          @csrf
          <div class="row">
            <div class="col-md-2">
              <div class="mb-3">
                <label for="from">{{ __('head/vacations.from') }}</label>
                <input type="date" id="from" class="form-control" name="start" value="{{ request()->has('start') ? request()->get('start') : ''}}">
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="to">{{ __('head/vacations.to') }}</label>
                <input type="date" id="to" class="form-control" name="end" value="{{ request()->has('end') ? request()->get('end') : ''}}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('head/vacations.type') }}</label>
                <select name="type" id="" class="form-control">
                  <option value="" selected>{{ __('head/vacations.selectAll') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ request()->get('type') == $type->id ? 'selected' : ''}}>{{ $type->{'vacation_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('head/vacations.status') }}</label>
                <select name="status" id="" class="form-control">
                  <option value="" selected >{{ __('head/vacations.selectAll') }}</option>
                  @foreach ($status as $item)
                    <option value="{{ $item->code }}" {{ request()->get('status') == $item->code ? 'selected' : ''}}>{{ $item->{'workflow_status' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2 d-flex justify-content-end align-items-center">
              <a href="{{ route('admin.vacations') }}" class="btn btn-danger">{{ __('head/vacations.clear') }}</a>
              <button type="submit" class="btn btn-primary mx-2">{{ __('head/vacations.filter') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div> --}}
    @if (session('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
          <h5 class="card-title">
            {{ __('admin/vacations.balance') }}
          </h5>
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('admin/vacations.empid') }}</th>
                <th scope="col">{{ __('admin/vacations.name') }}</th>
                <th scope="col">{{ __('admin/vacations.joining_date') }}</th>
                <th scope="col">{{ __('admin/vacations.balance') }}</th>
                {{-- <th scope="col">{{ __('global.action') }}</th> --}}
              </tr>
            </thead>
            <tbody>
              @php $c = 1; @endphp
              @foreach ($users as $user)
                <tr>
                  <td>{{ $c }}</td>
                  <td>{{ $user->empid }}</td>
                  <td>{{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}</td>
                  <td>{{ $user->joining_date }}</td>
                  <td>{{ $user->balance }}</td>
                  {{-- <td>
                  <a
                    href="{{ route('admin.vacation', $vacation->id) }}"
                    class="btn btn-secondary btn-sm py-0">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                  </td> --}}
                </tr>
                @php $c++; @endphp
              @endforeach
            </tbody>
          </table>
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