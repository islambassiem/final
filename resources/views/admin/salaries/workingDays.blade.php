@extends('admin.layout.master')

@section('title')
  {{ __('admin/salaries.workingDays') }}
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
{{ __('admin/salaries.workingDays') }}
@endsection

@section('breadcrumb')
  @include('admin.salaries.breadcrumb')
@endsection


@section('content')

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ __('admin/salaries.workingDays') }}
      </h5>
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
              <th>{{ __('admin/salaries.workingDays') }}</th>
              @if (!$sent)
                <th>{{ __('global.action') }}</th>
              @endif
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
                <td>{{ $day->working_days }}</td>
                @if (!$sent)
                  <td>
                    <button
                      type="button"
                      class="btn btn-primary btn-sm py-0"
                      data-bs-toggle="modal"
                      data-bs-target="#editModal"
                      data-id="{{ $day->id }}">
                      {{ __('global.edit') }}
                      <i class="bi bi-stack"></i>
                    </button>
                  </td>
                @endif
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
      <a href="{{ route('admin.salaries.dashboard', $month_id) }}" class="btn btn-danger mx-2"><i class="bi bi-caret-{{ session('_lang') == '_ar' ? 'right' : 'left'  }}-square-fill me-2"></i>{{ __('global.back') }}</a>
      <a href="{{ route('admin.salaries.dashboard', $month_id) }}" class="btn btn-secondary mx-2"><i class="bi bi-house-gear-fill mx-2"></i>{{ __('global.home') }}</a>
      <a href="{{ route('admin.salaries.non.working', $month_id) }}" class="btn btn-primary mx-2">{{ __('global.next') }}<i class="bi bi-caret-{{ session('_lang') == '_ar' ? 'left' : 'right'  }}-square-fill ms-2"></i></a>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">{{ __('admin/salaries.editWorkingDays') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="editForm">
            @csrf
            <input type="hidden" name="month_id" value={{ $month_id }}>
            <div class="mb-3">
              <label for="expiry">{{ __('admin/salaries.editWorkingDays') }}</label>
              <input type="text" name="workingDays" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
          <button type="submit" form="editForm" class="btn btn-primary">{{ __('global.submit') }}</button>
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
      $("#month").select2({
        dropdownParent: $('#addMonth')
      });
      $("#year").select2({
        dropdownParent: $('#addMonth')
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

      $('#editModal').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('editForm');
        form.action = "edit/" + id;
      });
    });
  </script>
@endsection
