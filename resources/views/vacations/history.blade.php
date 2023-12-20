@extends('layout.master')

@section('title')
  {{ __('Vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
  <style>
    #vacationsTable{
      min-width: 800px;
    }
  </style>
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
          href="{{ route('vacations.index') }}"
          class="btn btn-danger mx-2">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('Back') }}
        </a>
        <a
          href="{{ route('vacations.create') }}"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('Add') }}
        </a>
      </div>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    @if (session('message'))
      <div class="alert alert-warning" role="alert">
        {{ session('message') }}
      </div>
    @endif
    <div class="alert alert-danger d-none" id="editAttempt"></div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body mt-4">
            @if (count($vacations) == 0)
              <div class="alert alert-danger" role="alert">
                {{ __('There are no vacations availed yet') }}
              </div>
            @else
              @if (session('success'))
                <div class="alert alert-success" role="alert">
                  {{ session('success') }}
                </div>
              @endif
              <!-- Table with stripped rows -->
              <table class="table table-striped" id="vacationsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Start Date') }}</th>
                    <th scope="col">{{ __('End Date') }}</th>
                    <th scope="col">{{ __('Duration') }}</th>
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
                      <td>{{ $vacation->start_date }}</td>
                      <td>{{ $vacation->end_date }}</td>
                      <td>{{ $vacation->days }}</td>
                      <td>{{ $vacation->type->{'vacation_type' . session('_lang')} }}</td>
                      <td>
                        @switch($vacation->status_id)
                          @case(1)
                            <i class="bi bi-check-square-fill text-success fs-5"></i>
                            @break
                          @case(2)
                            <i class="bi bi-x-square-fill text-danger fs-5"></i>
                            @break
                          @default
                          <i class="bi bi-hourglass-top text-warning fs-5"></i>
                        @endswitch
                        <span class="mx-2">{{ $vacation->status->{'workflow_status' . session('_lang')} }}</span>
                      </td>
                      <td>
                        <a
                        href="{{ route('vacations.show', $vacation->id) }}"
                        class="btn btn-secondary btn-sm py-0">
                        <i class="bi bi-eye-fill"></i>
                        </a>
                        <button
                          type="button"
                          class="btn btn-danger btn-sm py-0"
                          id="deleteBtn"
                          data-id = "{{ $vacation->id }}"
                          data-bs-toggle="modal"
                          data-bs-target="#delteConfirmation">
                          <i class="bi bi-trash3"></i>
                        </button>
                        <a
                          href="{{ route('attachment.vacation', $vacation->id) }}"
                          class="btn btn-info btn-sm py-0">
                          <i class="bi bi-paperclip"></i>
                        </a>
                      </td>
                    </tr>
                    @php $c++; @endphp
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
            @endif
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