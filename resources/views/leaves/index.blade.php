@extends('layout.master')

@section('title')
  {{ __('Leaves') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
@endsection

@section('h1')
  {{ __('Leaves') }}
@endsection

@section('breadcrumb')
  {{ __('Leaves / All') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end pb-2">
        <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#addleave"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('Add') }}
        </button>
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
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body mt-4">
            <h5 class="card-title">{{ __('Leaves') }}</h5>
            @if (count($leaves) == 0)
              <div class="alert alert-danger" role="alert">
                {{ __('There are no vacations availed yet') }}
              </div>
            @else
              @if (session('success'))
                <div class="alert alert-success" role="alert">
                  {{ session('success') }}
                </div>
              @endif
              @if (session('message'))
              <div class="alert alert-warning" role="alert">
                {{ session('message') }}
              </div>
              @endif
              <!-- Table with stripped rows -->
              <table class="table table-striped" id="vacationsTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('From') }}</th>
                    <th scope="col">{{ __('To') }}</th>
                    <th scope="col">{{ __('Type') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php $c = 1; @endphp
                  @foreach ($leaves as $leave)
                    <tr>
                      <td>{{ $c }}</td>
                      <td>{{ $leave->date }}</td>
                      <td>{{ $leave->from }}</td>
                      <td>{{ $leave->to }}</td>
                      <td>{{ $leave->type->{'leave_type' . session('_lang')} }}</td>
                      <td>
                        @switch($leave->status_id)
                          @case(1)
                            <i class="bi bi-check-square-fill text-success fs-5"></i>
                            @break
                          @case(2)
                            <i class="bi bi-x-square-fill text-danger fs-5"></i>
                            @break
                          @default
                          <i class="bi bi-hourglass-top text-warning fs-5"></i>
                        @endswitch
                        <span class="mx-2">{{ $leave->status->{'workflow_status' . session('_lang')} }}</span>
                      </td>
                      <td>
                        <a
                        href="{{ route('leaves.show', $leave->id) }}"
                        class="btn btn-secondary btn-sm py-0">
                        <i class="bi bi-eye-fill"></i>
                      </a>
                        {{-- <button
                          type="button"
                          class="btn btn-warning btn-sm py-0"
                          id="editBtn"
                          data-id="{{ $vacation->id }}"
                          data-status="{{ $vacation->status_id }}"
                          data-start-date="{{ $vacation->start_date }}"
                          data-end-date="{{ $vacation->end_date }}"
                          data-type="{{ $vacation->vacation_type }}"
                          data-notes="{{ $vacation->detail?->employee_notes }}"
                          data-attachment="{{ $vacation->attachment }}"
                          data-bs-toggle="modal"
                          data-bs-target="#editVacation">
                          <i class="bi bi-pencil-square"></i>
                        </button> --}}
                        <button
                          type="button"
                          class="btn btn-danger btn-sm py-0"
                          id="deleteBtn"
                          data-id = "{{ $leave->id }}"
                          data-bs-toggle="modal"
                          data-bs-target="#delteConfirmation">
                          <i class="bi bi-trash3"></i>
                        </button>
                        <a
                          href="{{ route('attachment.leave', $leave->id) }}"
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

  {{-- Edit vacation modal --}}
  {{-- <div class="modal fade" id="editVacation" tabindex="-1" aria-labelledby="editVacationLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editVacationLabel">{{ __('Edit the vacation request') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" enctype="multipart/form-data" id="editVacationForm" >
            @csrf
            @method('POST')
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="start_date_edit">{{ __('Start Date') }}</label>
                  <input type="date" class="form-control" name="start_date" id="start_date_edit">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="start_date_edit">{{ __('End Date') }}</label>
                  <input type="date" class="form-control" name="end_date" id="end_date_edit">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="vacation_type_edit">{{ __('Vacation Type') }}</label>
                <select class="form-select" name="vacation_type" id="vacation_type_edit" style="width: 100%">
                  <option disabled selected>{{ __('Select') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}" id="{{ $type->id }}">{{ $type->{'vacation_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="notes_edit">{{ __('Notes') }}</label>
                <textarea class="form-control" name="employee_notes" cols="30" rows="3" id="notes_edit"></textarea>
              </div>
            </div>
            <div class="row" id="editAttachment">
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
          <button type="submit" form="editVacationForm" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
      </div>
    </div>
  </div> --}}

  <!-- Add a leave Modal -->
  <div class="modal fade" id="addleave" tabindex="-1" aria-labelledby="addleaveLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addleaveLabel">{{ __('Add a new vacation request') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('leaves.store') }}" method="post" enctype="multipart/form-data" id="addleaveForm" >
            @csrf
            <div class="row">
              <div class="col-6 mb-3">
                <div class="mb-3">
                  <label for="date">{{ __('Date') }}</label>
                  <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}">
                </div>
              </div>
              <div class="col-6 mb-3">
                <label for="leave_type">{{ __('Permission Type') }}</label>
                <select class="form-select" name="leave_type" id="leave_type" style="width: 100%">
                  <option selected disabled>{{ __('Select') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->{'leave_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="from">{{ __('From') }}</label>
                  <input type="time" class="form-control" name="from" id="from" value="{{ old('from') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="to">{{ __('To') }}</label>
                  <input type="time" class="form-control" name="to" id="to" value="{{ old('to') }}">
                </div>
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
          <button type="submit" form="addleaveForm" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete a leave modal --}}

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

    $("#leave_type").select2({
      dropdownParent: $('#addleave')
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
      form.action = "leaves/" + id;
    });
  });
</script>
@endsection