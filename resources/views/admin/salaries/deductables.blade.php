@extends('admin.layout.master')

@section('title')
  {{ __('admin/salaries.deductables') }}
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
{{ __('admin/salaries.deductables') }}
@endsection

@section('breadcrumb')
  @include('admin.salaries.breadcrumb')
@endsection


@section('content')
<div class="row">
  @if (! $sent)
    <div class="col d-flex justify-content-end mb-3">
      <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#addDeduct"
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
        {{ __('admin/salaries.deductables') }}
      </h5>
      @if (count($deductables) == 0)
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
              @if (! $sent)
              <th>{{ __('admin/salaries.action') }}</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @php $c = 1; @endphp
            @foreach ($deductables as $payable)
              <tr>
                <td>{{ $c; }}</td>
                <td>{{ $payable->user->empid }}</td>
                <td>{{ session('_lang') == '_en' ? $payable->user->getFullEnglishNameAttribute : $payable->user->getFullArabicNameAttribute }}</td>
                <td>{{ $payable->amount }}</td>
                <td>{{ $payable->description }}</td>
                @if (! $sent)
                  <td>
                    <button
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#editDeductable"
                    data-id          = "{{ $payable->id }}"
                    data-amount      = "{{ $payable->amount }}"
                    data-description = "{{ $payable->description }}"
                    class="btn btn-warning btn-sm py-0">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger btn-sm py-0"
                    id="btn"
                    data-id = "{{ $payable->id }}"
                    data-bs-toggle="modal"
                    data-bs-target="#delteConfirmation">
                    <i class="bi bi-trash3"></i>
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
      <a href="{{ route('admin.salaries.payables', $month_id) }}" class="btn btn-danger mx-2"><i class="bi bi-caret-{{ session('_lang') == '_ar' ? 'right' : 'left'  }}-square-fill me-2"></i>{{ __('global.back') }}</a>
      <a href="{{ route('admin.salaries.dashboard', $month_id) }}" class="btn btn-secondary mx-2"><i class="bi bi-house-gear-fill mx-2"></i>{{ __('global.home') }}</a>
      {{-- <a href="{{ route('admin.salaries.deductables', $month_id) }}" class="btn btn-primary mx-2">{{ __('global.next') }}<i class="bi bi-caret-{{ session('_lang') == '_ar' ? 'left' : 'right'  }}-square-fill ms-2"></i></a> --}}
    </div>
  </div>

  {{--  Edit Deductable  --}}
  <div class="modal fade" id="editDeductable" tabindex="-1" aria-labelledby="editDeductableModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editDeductableLabel">{{ __('admin/salaries.editDeductable') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" id="editForm">
            @csrf
            <input type="hidden" id="id" name="id">
            <div class="row">
              <div class="col-12 mb-3">
                <label for="numberEdit" class="form-label">{{ __('admin/salaries.amount') }}</label>
                <input type="number" name="numberEdit" id="numberEdit" class="form-control" min="0">
              </div>
            </div>
            <div class="row">
              <div class="col mb-3 d-flex justify-content-between">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="unitEdit" id="inlineRadio4" value="day">
                  <label class="form-check-label" for="inlineRadio4">{{ __('admin/salaries.day') }}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="unitEdit" id="inlineRadio5" value="hour">
                  <label class="form-check-label" for="inlineRadio5">{{ __('admin/salaries.hour') }}</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="unitEdit" id="inlineRadio6" value="riyal">
                  <label class="form-check-label" for="inlineRadio6">{{ __('admin/salaries.riyal') }}</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="descriptionEditTextArea" class="form-label">{{ __('admin/salaries.description') }}</label>
                <textarea class="form-control" id="descriptionEditTextArea" rows="3" name="descriptionEdit">{{ old('descriptionEdit') }}</textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
          <button type="submit" class="btn btn-primary" form="editForm">{{ __('global.save') }}</button>
        </div>
      </div>
    </div>
  </div>

  {{--  Add Deductable  --}}
  <div class="modal fade" id="addDeduct" tabindex="-1" aria-labelledby="addHolidayModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addHolidayLabel">{{ __('admin/salaries.addDeduct') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.salaries.deductables.store') }}" method="POST" id="addForm">
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
                  <input class="form-check-input" type="radio" name="unit" id="inlineRadio1" value="day">
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

  <!-- Delete Modal -->
  <div class="modal fade" id="delteConfirmation" tabindex="-1" aria-labelledby="delteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('global.delConf') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="deleteForm">
            @csrf
            @method('delete')
            {{ __('global.deleteConfirmation') }}
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
          <button type="submit" class="btn btn-danger" form="deleteForm">{{ __('global.delete') }}</button>
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
        dropdownParent: $('#addDeduct')
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

      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "delete/" + id;
      });

      $('#editDeductable').on('show.bs.modal', function (event){

        let button = $(event.relatedTarget);
        let id = button.data('id');
        let amount = button.data('amount');
        let description = button.data('description');
        let form = document.getElementById('editForm');

        $('#id').val(id);
				$('#descriptionEditTextArea').val(description);
        $('#numberEdit').val(amount);
        form.action = "edit/" + id;
      });
    });
  </script>
@endsection
