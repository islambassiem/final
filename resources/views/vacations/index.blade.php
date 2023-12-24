@extends('layout.master')

@section('title')
  {{ __('Vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
@endsection

@section('h1')
  {{ __('Vacations') }}
@endsection

@section('breadcrumb')
  {{ __('Vacations / All') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end pb-2">
        <a
          href="{{ route('vacations.history') }}"
          class="btn btn-primary mx-2">
          <i class="bi bi-hourglass-split me-1"></i>
          {{ __('History') }}
        </a>
        <a
          href="{{ route('vacations.create') }}"
          class="btn btn-success mx-2">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('Add') }}
        </a>
      </div>
    </div>
    @if (session('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    @endif
    <div class="row">
      <div class="col-md-4 mx-auto text-center">
        <div class="card mb-0">
          <div class="card-body">
            <div class="card-title text-center h3 mt-2">{{ __('Balance') }}</div>
            <i class="bi bi-graph-down text-success fs-1"></i>
            <div class="h1">{{ $balance }}</div>
            <form action="{{ route('vacations.index') }}" method="get">
              @csrf
              <input type="date" name="tillDate" min="{{ date('Y-m-d') }}" class="form-control" value="{{ request()->has('tillDate') ? request()->get('tillDate') : ''}}">
              <input type="submit" value="Submit" class="btn btn-secondary mt-3">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">
              {{ __('Availed Annual') }}
            </h5>
            <div class="text-center"><i class="bi bi-calendar2-date-fill fs-1 text-info"></i></div>
            <div class="h1 text-center">{{ $availedAnnual }}</div>
            <div class="card-title text-center">{{ __('This Year') }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">
              {{ __('Availed Sick Leave') }}
            </h5>
            <div class="text-center"><i class="bi bi-capsule-pill text-warning fs-1"></i></div>
            <div class="h1 text-center">{{ $availedSick }}</div>
            <div class="card-title text-center">{{ __('This Year') }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">
              {{ __('Absence') }}
            </h5>
            <div class="text-center text-danger"><i class="bi bi-emoji-tear-fill fs-1"></i></div>
            <div class="h1 text-center">{{ $availedAbsent }}</div>
            <div class="card-title text-center">{{ __('This Year') }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Add a vacation Modal -->
  <div class="modal fade" id="addVacation" tabindex="-1" aria-labelledby="addVacationLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addVacationLabel">{{ __('Add a new vacation request') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('vacations.store') }}" method="post" enctype="multipart/form-data" id="addVacationForm" >
            @csrf
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="start_date">{{ __('Start Date') }}</label>
                  <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="start_date">{{ __('End Date') }}</label>
                  <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="vacation_type">{{ __('Vacation Type') }}</label>
                <select class="form-select" name="vacation_type" id="vacation_type" style="width: 100%">
                  <option selected disabled>{{ __('Select') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->{'vacation_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="notes">{{ __('Notes') }}</label>
                <textarea class="form-control" name="employee_notes" cols="30" rows="3" id="notes">{{ old('notes') }}</textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="attachment" class="col-sm-2 col-form-label">{{ __('Attachment') }}</label>
                <div class="col-sm-12">
                  <input
                    type="file"
                    class="dropify"
                    id="attachment"
                    name="attachment"
                    data-height="100"
                    accept="image/*, .pdf">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
          <button type="submit" form="addVacationForm" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete a vacation modal --}}

  <div class="modal fade" id="delteConfirmation" tabindex="-1" aria-labelledby="delteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('Delete Confirmation!') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="deleteForm">
            @csrf
            @method('delete')
            {{ __('Are you sure you want to delete the vacation and its related document?') }}
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
          <button type="submit" class="btn btn-danger" form="deleteForm">{{ __('Yes, Delete') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
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
      $('#vacationsTable').dataTable({
        language: {
          url: file
        }
      });

      $("#vacation_type").select2({
        dropdownParent: $('#addVacation')
      });



      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('Drag and drop or click to replace') }}",
          'remove':  "{{ __('Delete') }}",
          'error': "{{ __('Ooops, something wrong happended.') }}"
        }
      });

      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "vacations/" + id;
      });
    });
  </script>
@endsection