@extends('layout.master')

@section('title')
  {{ __('Permissions') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('h1')
  {{ __('Permissions') }}
@endsection

@section('breadcrumb')
  {{ __('Permissions / All') }}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('Filter') }}
        </h5>
        <form action="{{ route('sLeave.index') }}" method="get">
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
                <label for="to">{{ __('Permission Type') }}</label>
                <select name="type" id="" class="form-control">
                  <option value="" selected>{{ __('Select All') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ request()->get('type') == $type->id ? 'selected' : ''}}>{{ $type->{'permission_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('Permission Status') }}</label>
                <select name="status" id="" class="form-control">
                  <option value="" selected >{{ __('Select All') }}</option>
                  @foreach ($status as $item)
                    <option value="{{ $item->code }}" {{ request()->get('status') == $item->code ? 'selected' : ''}}>{{ $item->{'workflow_status' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-2 d-flex justify-content-end align-items-center">
              <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        @if (count($permissions) == 0)
          <div class="alert alert-danger my-5" role="alert">
            {{ __('There are no upcoming permissions requests') }}
          </div>
        @else
          <h5 class="card-title">
            {{ __('All Staff') }}
          </h5>
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('Date') }}</th>
                <th scope="col">{{ __('From') }}</th>
                <th scope="col">{{ __('To') }}</th>
                <th scope="col">{{ __('Type') }}</th>
                <th scope="col">{{ __('Status') }}</th>
                {{-- <th scope="col">{{ __('Actions') }}</th> --}}
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
                  <td>{{ $permission->type->{'permission_type' . session('_lang')} }}</td>
                  <td>
                    @switch($permission->status_id)
                      @case(1)
                        <i class="bi bi-check-square-fill text-success fs-5"></i>
                        @break
                      @case(2)
                        <i class="bi bi-x-square-fill text-danger fs-5"></i>
                        @break
                      @default
                      <i class="bi bi-hourglass-top text-warning fs-5"></i>
                    @endswitch
                    <span class="mx-2">{{ $permission->status->{'workflow_status' . session('_lang')} }}</span>
                  </td>
                  {{-- <td>
                    <a
                    href="{{ route('permissions.show', $permission->id) }}"
                    class="btn btn-secondary btn-sm py-0">
                    <i class="bi bi-eye-fill"></i>
                  </a>
                    <button
                      type="button"
                      class="btn btn-danger btn-sm py-0"
                      id="deleteBtn"
                      data-id = "{{ $permission->id }}"
                      data-bs-toggle="modal"
                      data-bs-target="#delteConfirmation">
                      <i class="bi bi-trash3"></i>
                    </button>
                    <a
                      href="{{ route('attachment.permission', $permission->id) }}"
                      class="btn btn-info btn-sm py-0">
                      <i class="bi bi-paperclip"></i>
                    </a>
                  </td> --}}
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