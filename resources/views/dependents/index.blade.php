@extends('layout.master')

@section('title')
  {{ __('Dependents') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
@endsection

@section('h1')
  {{ __('Dependents') }}
@endsection

@section('breadcrumb')
  {{ __('Dependents / All') }}
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
        {{ __('Add') }}
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
              {{ __('There are no dependents Registered') }}
            </div>
          @else
            <h5 class="card-title">{{ __('Dependents') }}</h5>
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
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">ID</th>
                  <th scope="col">Date Of Birth</th>
                  <th scope="col">Relationship</th>
                  <th scope="col">Actions</th>
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
                        class="btn btn-warning btn-sm py-0">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger btn-sm py-0"
                        id="btn"
                        data-id = "{{ $dependent->id }}"
                        data-bs-toggle="modal"
                        data-bs-target="#delteConfirmation">
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
        <h1 class="modal-title fs-5" id="editDependentLabel">{{ __('Edit a dependent') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="editForm">
          @csrf
          @method('PUT')
          <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
          <input type="hidden" id="dependent_id" name="dependent_id">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label">{{ __('Dependent Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="identification" class="form-label">{{ __('Dependent ID') }}</label>
                <input type="text" class="form-control" id="identification" name="identification" value="{{ old('identification') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="date_of_birth" class="form-label">{{ __('Date of Birth') }}</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="identification" class="form-label">{{ __('Relationship') }}</label>
              <select class="form-select" id="relationship_id_edit" name="relationship_id" style="width:100%">
                <option selected disabled>{{ __('Select') }}</option>
                @foreach ($relationships as $relationship)
                  <option value="{{ $relationship->id }}" @selected( $relationship->id == old('relationship->id'))>{{  $relationship->{'relationship' . session('_lang')} }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="editForm">{{ __('Save') }}</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDependent" tabindex="-1" aria-labelledby="addDependentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addDependentLabel">{{ __('Add a dependent') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('dependents.store') }}" method="POST" id="addForm">
          @csrf
          <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label">{{ __('Dependent Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="identification" class="form-label">{{ __('Dependent ID') }}</label>
                <input type="text" class="form-control" id="identification" name="identification" value="{{ old('identification') }}">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="date_of_birth" class="form-label">{{ __('Date of Birth') }}</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="identification" class="form-label">{{ __('Relationship') }}</label>
              <select class="form-select" id="relationship_id" name="relationship_id" style="width:100%">
                <option selected disabled>{{ __('Select') }}</option>
                @foreach ($relationships as $relationship)
                  <option value="{{ $relationship->id }}" @selected( $relationship->id == old('relationship->id'))>{{  $relationship->{'relationship' . session('_lang')} }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="addForm">{{ __('Add') }}</button>
      </div>
    </div>
  </div>
</div>


  <!-- Delete Modal -->
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
            {{ __('Are you sure you want to delete the dependent?') }}
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
  <script>
    $(document).ready(function (){
      $("#relationship").select2({
        dropdownParent: $('#addDependent')
      });

      $('#relationship_id_edit').select2({
        dropdownParent: $('#editDependent')
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
    });
  </script>
@endsection