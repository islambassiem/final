@extends('layout.master')

@section('title')
  {{ __('head/leaves.leaves') }}
@endsection

@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
@endsection

@section('h1')
  {{ __('head/leaves.leaves') }}
@endsection

@section('breadcrumb')
  {{ __('head/leaves.leaves') . ' / ' . __('global.all')}}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('head/leaves.filter') }}
        </h5>
        <form action="{{ route('sLeave.index') }}" method="get">
          @csrf
          <div class="row">
            <div class="col-md-2">
              <div class="mb-3">
                <label for="from">{{ __('head/leaves.from') }}</label>
                <input type="date" id="from" class="form-control" name="start" value="{{ request()->has('start') ? request()->get('start') : ''}}">
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label for="to">{{ __('head/leaves.to') }}</label>
                <input type="date" id="to" class="form-control" name="end" value="{{ request()->has('end') ? request()->get('end') : ''}}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('head/leaves.type') }}</label>
                <select name="type" id="" class="form-control">
                  <option value="" selected>{{ __('head/leaves.selectAll') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ request()->get('type') == $type->id ? 'selected' : ''}}>{{ $type->{'leave_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('head/leaves.status') }}</label>
                <select name="status" id="" class="form-control">
                  <option value="" selected >{{ __('head/leaves.selectAll') }}</option>
                  @foreach ($status as $item)
                    <option value="{{ $item->code }}" {{ request()->get('status') == $item->code ? 'selected' : ''}}>{{ $item->{'workflow_status' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2 d-flex justify-content-end align-items-center">
              <a href="{{ route('sLeave.index') }} " class="btn btn-danger mx-2">{{ __('head/leaves.clear') }}</a>
              <button type="submit" class="btn btn-primary">{{ __('head/leaves.filter') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        @if (count($permissions) == 0)
          <div class="alert alert-danger my-5" role="alert">
            {{ __('head/leaves.noLeaves') }}
          </div>
        @else
          <h5 class="card-title">
            {{ __('head/leaves.allStaff') }}
          </h5>
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('head/leaves.name') }}</th>
                <th scope="col">{{ __('head/leaves.date') }}</th>
                <th scope="col">{{ __('head/leaves.from') }}</th>
                <th scope="col">{{ __('head/leaves.to') }}</th>
                <th scope="col">{{ __('head/leaves.type') }}</th>
                <th scope="col">{{ __('head/leaves.status') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @php $c = 1; @endphp
              @foreach ($permissions as $permission)
                <tr>
                  <td>{{ $c }}</td>
                  <td>{{ session('_lang') == '_ar' ? $permission->user->getFullArabicNameAttribute : $permission->user->getFullEnglishNameAttribute }}</td>
                  <td>{{ $permission->date }}</td>
                  <td>{{ $permission->from }}</td>
                  <td>{{ $permission->to }}</td>
                  <td>{{ $permission->type->{'leave_type' . session('_lang')} }}</td>
                  <td>
                    @switch($permission->detail?->head_status)
                      @case(1)
                        <i class="bi bi-check-square-fill text-success fs-5"></i>
                        @break
                      @case(2)
                        <i class="bi bi-x-square-fill text-danger fs-5"></i>
                        @break
                      @default
                      <i class="bi bi-hourglass-top text-warning fs-5"></i>
                    @endswitch
                    <span class="mx-2">{{ $permission->detail?->headStatus->{'workflow_status' . session('_lang')} }}</span>
                  </td>
                  <td>
                    <a
                      href="{{ route('sLeave.show', $permission->id) }}"
                      class="btn btn-secondary btn-sm py-0"
                      data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('global.view') }}">
                      <i class="bi bi-eye-fill"></i>
                    </a>
                    <button
                      type="button"
                      class="btn btn-primary btn-sm py-0"
                      data-bs-toggle="modal"
                      data-bs-target="#actionModal"
                      data-id="{{ $permission->id }}"
                      data-bs-placement="top"
                      title="{{ __('global.action') }}">
                      <i class="bi bi-activity"></i>
                    </button>
                    @if ($permission->hasAttachment())
                    <a
                      href="{{ route('attachment.leave', $permission->id) }}"
                      target="_blank"
                      class="btn btn-info btn-sm py-0"
                      data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('global.link') }}">
                      <i class="bi bi-paperclip"></i>
                    </a>
                    @else
                      <span class="btn btn-dark btn-sm py-0"
                      data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ __('global.nolink') }}">
                      <i class="bi bi-ban-fill"></i></span>
                    @endif
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
        <h1 class="modal-title fs-5" id="actionModalLabel">{{ __('head/leaves.takeAction') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="actionForm">
          @csrf
          <div class="mb-3">
            <label for="action">{{ __('global.action') }}</label>
            <select name="action" id="" class="form-select">
              <option selected disabled>{{ __('global.select') }}</option>
              <option value="1">{{ __('head/leaves.approve') }}</option>
              <option value="2">{{ __('head/leaves.decline') }}</option>
            </select>
          </div>
          <div class="row">
            <div class="col">
              <label for="notes">{{ __('head/leaves.notes') }}</label>
              <textarea class="form-control" name="head_notes" cols="30" rows="3" id="notes">{{ old('notes') }}</textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
        <button type="submit" form="actionForm" class="btn btn-primary">{{ __('global.submit') }}</button>
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
      form.action = "sLeave/update/" + id;
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
          new bootstrap.Tooltip(tooltipTriggerEl);
        });

    });
</script>
@endsection