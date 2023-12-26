@extends('layout.master')

@section('title')
  {{ __('leaves.leaves') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
  {{ __('leaves.leaves') }}
@endsection

@section('breadcrumb')
  {{ __('leaves.leaves') . __('global.all') }}
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
          {{ __('global.add') }}
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
            <h5 class="card-title">{{ __('leaves.leaves') }}</h5>
            @if (count($leaves) == 0)
              <div class="alert alert-danger" role="alert">
                {{ __('leaves.noLeaves') }}
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
                    <th scope="col">{{ __('leaves.date') }}</th>
                    <th scope="col">{{ __('leaves.from') }}</th>
                    <th scope="col">{{ __('leaves.to') }}</th>
                    <th scope="col">{{ __('leaves.to') }}</th>
                    <th scope="col">{{ __('leaves.status') }}</th>
                    <th scope="col">{{ __('global.action') }}</th>
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
                        <span class="mx-2">{{ $leave->status?->{'workflow_status' . session('_lang')} }}</span>
                      </td>
                      <td>
                        <a
                        href="{{ route('leaves.show', $leave->id) }}"
                        class="btn btn-secondary btn-sm py-0">
                        <i class="bi bi-eye-fill"></i>
                      </a>
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

  <!-- Add a leave Modal -->
  <div class="modal fade" id="addleave" tabindex="-1" aria-labelledby="addleaveLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addleaveLabel">{{ __('leaves.addLeave') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('leaves.store') }}" method="post" enctype="multipart/form-data" id="addleaveForm" >
            @csrf
            <div class="row">
              <div class="col-6 mb-3">
                <div class="mb-3">
                  <label for="date" class="required">{{ __('leaves.date') }}</label>
                  <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}">
                </div>
              </div>
              <div class="col-6 mb-3">
                <label for="leave_type" class="required">{{ __('leaves.type') }}</label>
                <select class="form-select" name="leave_type" id="leave_type" style="width: 100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                  @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->{'leave_type' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="from" class="required">{{ __('leaves.from') }}</label>
                  <input type="time" class="form-control" name="from" id="from" value="{{ old('from') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="to" class="required">{{ __('leaves.to') }}</label>
                  <input type="time" class="form-control" name="to" id="to" value="{{ old('to') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="notes">{{ __('leaves.notes') }}</label>
                <textarea class="form-control" name="employee_notes" cols="30" rows="3" id="notes">{{ old('notes') }}</textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="attachment" class="col-sm-2 col-form-label">{{ __('global.attachment') }}</label>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
          <button type="submit" form="addleaveForm" class="btn btn-primary">{{ __('global.save') }}</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete a leave modal --}}

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
        'replace': "{{ __('global.dnd') }}",
        'remove':  "{{ __('global.del') }}",
        'error': "{{ __('global.error') }}"
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