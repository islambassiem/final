@extends('layout.master')

@section('title')
  {{ __('dependants.dependents') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
  {{ __('dependants.dependents') }}
@endsection

@section('breadcrumb')
  {{ __('dependants.dependents') . ' / ' . __('global.all')}}
@endsection

@section('content')
<section class="section">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#addDependent"
        class="btn btn-success">
        <i class="bi bi-plus-square-fill me-1"></i>
        {{ __('global.add') }}
      </button>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger mt-5">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @if (count($dependents) == 0)
            <div class="alert alert-danger my-5" role="alert">
              {{ __('dependants.noDepen') }}
            </div>
          @else
            <h5 class="card-title">{{ __('dependants.dependents') }}</h5>
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
            <table class="table table-striped" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">{{ __('dependants.name') }}</th>
                  <th scope="col">{{ __('dependants.id') }}</th>
                  <th scope="col">{{ __('dependants.dob') }}</th>
                  <th scope="col">{{ __('dependants.dob') }}</th>
                  <th scope="col">{{ __('global.action') }}</th>
                </tr>
              </thead>
              <tbody>
                @php $c = 1; @endphp
                @foreach ($dependents as $dependent)
                  <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $dependent->name }}</td>
                    <td>{{ $dependent->identification }}</td>
                    <td>{{ $dependent->date_of_birth }}</td>
                    <td>{{ $dependent->relationship->{'relationship' . session('_lang')} }}</td>
                    <td>
                      <button
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#editDependent"
                        data-id   = "{{ $dependent->id }}"
                        data-iden = "{{ $dependent->identification }}"
                        data-name = "{{ $dependent->name }}"
                        data-dob  = "{{ $dependent->date_of_birth }}"
                        data-rel  = "{{ $dependent->relationship_id }}"
                        class="btn btn-warning btn-sm py-0"
                        data-bs-placement="top"
                        title="{{ __('global.edit') }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                      <button
                        type="button"
                        class="btn btn-danger btn-sm py-0"
                        id="btn"
                        data-id = "{{ $dependent->id }}"
                        data-bs-toggle="modal"
                        data-bs-target="#delteConfirmation"
                        data-bs-placement="top"
                        title="{{ __('global.delete?') }}">
                        <i class="bi bi-trash3"></i>
                      </button>
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

<!-- Edit Modal -->
<div class="modal fade" id="editDependent" tabindex="-1" aria-labelledby="editDependentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editDependentLabel">{{ __('dependants.editDepen') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="editForm">
          @csrf
          @method('PUT')
          <input type="hidden" id="dependent_id" name="dependent_id" autocomplete="off">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label required">{{ __('dependants.deptName') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="identification" class="form-label required">{{ __('dependants.gender') }}</label>
                <select class="form-select" id="gender_id_edit" name="gender_id" style="width:100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                  @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}" @selected( $gender->id == old('gender_id->id'))>{{  $gender->{'gender' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="identification" class="form-label required">{{ __('dependants.deptId') }}</label>
                <input type="text" class="form-control" id="identification" name="identification" value="{{ old('identification') }}" autocomplete="off">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="date_of_birth" class="form-label required">{{ __('dependants.dob') }}</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="identification" class="form-label required">{{ __('dependants.relationship') }}</label>
              <select class="form-select" id="relationship_id_edit" name="relationship_id" style="width:100%">
                <option selected disabled>{{ __('global.select') }}</option>
                @foreach ($relationships as $relationship)
                  <option value="{{ $relationship->id }}" @selected( $relationship->id == old('relationship->id'))>{{  $relationship->{'relationship' . session('_lang')} }}</option>
                @endforeach
              </select>
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

<!-- Add Modal -->
<div class="modal fade" id="addDependent" tabindex="-1" aria-labelledby="addDependentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addDependentLabel">{{ __('dependants.addDepn') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('dependents.store') }}" method="POST" id="addForm">
          @csrf
          <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label required">{{ __('dependants.deptName') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="gender" class="form-label required">{{ __('dependants.gender') }}</label>
                <select class="form-select" id="genders" name="gender_id" style="width:100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                  @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}" @selected( $gender->id == old('gender_id'))>{{  $gender->{'gender' . session('_lang')} }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="identification" class="form-label required">{{ __('dependants.deptId') }}</label>
                <input type="text" class="form-control" id="identification" name="identification" value="{{ old('identification') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="date_of_birth" class="form-label required">{{ __('dependants.dob') }}</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="relationship" class="form-label required">{{ __('dependants.relationship') }}</label>
              <select class="form-select" id="relationship" name="relationship_id" style="width:100%">
                <option selected disabled>{{ __('global.select') }}</option>
                @foreach ($relationships as $relationship)
                  <option value="{{ $relationship->id }}" @selected( $relationship->id == old('relationship_id'))>{{  $relationship->{'relationship' . session('_lang')} }}</option>
                @endforeach
              </select>
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
          <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('dependants.delDepen') }}</h1>
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

      $("#relationship").select2({
        dropdownParent: $('#addDependent')
      });

      $("#genders").select2({
        dropdownParent: $('#addDependent')
      });

      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "dependents/" + id;
      });

      $('#editDependent').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let iden = button.data('iden');
        let name = button.data('name');
        let dob = button.data('dob');
        let rel = button.data('rel');
        let id = button.data('id');
        let form = document.getElementById('editForm');
        $('#name').val(name);
        $('#dependent_id').val(id);
        $('#identification').val(iden);
        $('#date_of_birth').val(dob);
        $('#relationship_id_edit').val(rel);
        form.action = "dependents/" + id;
      });

      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
          new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
  </script>
@endsection