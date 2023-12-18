@extends('layout.master')

@section('title')
  {{ __('Vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('h1')
  {{ __('Vacations') }}
@endsection

@section('breadcrumb')
  {{ __('Vacations / All') }}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('Filter') }}
        </h5>
        <form action="{{ route('lLeave.index') }}" method="get">
          @csrf
          <div class="row">
            <div class="col-md-2">
              <div class="mb-3">
                <label for="from">{{ __('From') }}</label>
                <input type="date" id="from" class="form-control" name="start" value="{{ request()->has('start') ? request()->get('start') : ''}}">
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="to">{{ __('To') }}</label>
                <input type="date" id="to" class="form-control" name="end" value="{{ request()->has('end') ? request()->get('end') : ''}}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('Vacation Type') }}</label>
                <select name="type" id="" class="form-control">
                  <option value="" selected>{{ __('Select All') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ request()->get('type') == $type->id ? 'selected' : ''}}>{{ $type->{'vacation_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('Vacation Status') }}</label>
                <select name="status" id="" class="form-control">
                  <option value="" selected >{{ __('Select All') }}</option>
                  @foreach ($status as $item)
                    <option value="{{ $item->code }}" {{ request()->get('status') == $item->code ? 'selected' : ''}}>{{ $item->{'workflow_status' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2 d-flex justify-content-end align-items-center">
              <a href="{{ route('lLeave.index') }}" class="btn btn-danger">{{ __('Clear Filter') }}</a>
              <button type="submit" class="btn btn-primary mx-2">{{ __('Filter') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
    <div class="card">
      <div class="card-body">
        @if (count($vacations) == 0)
          <div class="alert alert-danger my-5" role="alert">
            {{ __('There are vacation requests registered') }}
          </div>
        @else
          <h5 class="card-title">
            {{ __('Fiter') }}
          </h5>
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('From') }}</th>
                <th scope="col">{{ __('To') }}</th>
                <th scope="col">{{ __('Type') }}</th>
                <th scope="col">{{ __('Status') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @php $c = 1; @endphp
              @foreach ($vacations as $vacation)
                <tr>
                  <td>{{ $c }}</td>
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
                    <a
                    href="{{ route('lLeave.show', $vacation->id) }}"
                    class="btn btn-secondary btn-sm py-0">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                  <button  
                    type="button" 
                    class="btn btn-primary btn-sm py-0" 
                    data-bs-toggle="modal" 
                    data-bs-target="#actionModal"
                    data-id="{{ $vacation->id }}">
                    <i class="bi bi-activity"></i>
                  </button>
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

    <!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="actionModalLabel">{{ __('Take an action') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="actionForm">
          @csrf
          <div class="mb-3">
            <label for="action">{{ __('Action') }}</label>
            <select name="action" id="" class="form-select">
              <option value=""></option>
              <option value="1">{{ __('Approve') }}</option>
              <option value="2">{{ __('Decline') }}</option>
            </select>
          </div>
          <div class="row">
            <div class="col">
              <label for="notes">{{ __('Notes') }}</label>
              <textarea class="form-control" name="head_notes" cols="30" rows="3" id="notes">{{ old('notes') }}</textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" form="actionForm" class="btn btn-primary">{{ __('Submit') }}</button>
      </div>
    </div>
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
    $('#actionModal').on('show.bs.modal', function (event){
      let button = $(event.relatedTarget);
      let id = button.data('id');
      let form = document.getElementById('actionForm');
      form.action = "lLeave/update/" + id;
    });
  });
</script>
@endsection