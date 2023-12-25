@extends('layout.master')

@section('title')
  {{ __('acquaintance.acquaintance') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
  {{ __('acquaintance.acquaintance') }}
@endsection

@section('breadcrumb')
  {{ __('acquaintance.acquaintance') . ' / ' . __('global.all')}}
@endsection

@section('content')
<section class="section">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#addAcquaintance"
        class="btn btn-success">
        <i class="bi bi-plus-square-fill me-1"></i>
        {{ __('global.add') }}
      </button>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body pb-0">
          @if ($errors->any())
            <div class="alert alert-danger mt-5">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @if (count($acquaintances) == 0)
            <div class="alert alert-danger my-5" role="alert">
              {{ __('acquaintance.noAcq') }}
            </div>
          @else
            <h5 class="card-title">{{ __('acquaintance.acquaintance') }}</h5>
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
                  <th scope="col">{{ __('acquaintance.name') }}</th>
                  <th scope="col">{{ __('acquaintance.mobile') }}</th>
                  <th scope="col">{{ __('acquaintance.email') }}</th>
                  <th scope="col">{{ __('acquaintance.position') }}</th>
                  <th scope="col">{{ __('global.action') }}</th>
                </tr>
              </thead>
              <tbody>
                @php $c = 1; @endphp
                @foreach ($acquaintances as $acquaintance)
                  <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $acquaintance->name }}</td>
                    <td>{{ $acquaintance->mobile }}</td>
                    <td>{{ $acquaintance->email }}</td>
                    <td>{{ $acquaintance->position }}</td>
                    <td>
                      <button
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#editAcquaintance"
                        data-id   = "{{ $acquaintance->id }}"
                        data-name = "{{ $acquaintance->name }}"
                        data-mobile = "{{ $acquaintance->mobile }}"
                        data-email  = "{{ $acquaintance->email }}"
                        data-position  = "{{ $acquaintance->position }}"
                        class="btn btn-warning btn-sm py-0">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger btn-sm py-0"
                        id="btn"
                        data-id = "{{ $acquaintance->id }}"
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
<div class="modal fade" id="editAcquaintance" tabindex="-1" aria-labelledby="editAcquaintanceLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editAcquaintanceLabel">{{ __('acquaintance.editAcq') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="editForm">
          @csrf
          @method('PUT')
          <input type="hidden" id="id" name="id">
          <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label required">{{ __('acquaintance.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="mobile" class="form-label required">{{ __('acquaintance.mobile') }}</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="email" class="form-label required">{{ __('acquaintance.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="position" class="form-label required">{{ __('acquaintance.position') }}</label>
              <input type="text" class="form-control" id="position" name="position" value="{{ old('position') }}" autocomplete="off">
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
<div class="modal fade" id="addAcquaintance" tabindex="-1" aria-labelledby="addAcquaintanceLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addAcquaintanceLabel">{{ __('acquaintance.addAcq') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('acquaintances.store') }}" method="POST" id="addForm">
          @csrf
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="name" class="form-label required">{{ __('acquaintance.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="mobile" class="form-label required">{{ __('acquaintance.mobile') }}</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="email" class="form-label required">{{ __('acquaintance.email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="position" class="form-label required">{{ __('acquaintance.position') }}</label>
              <input type="position" class="form-control" id="position" name="position" value="{{ old('position') }}" autocomplete="off">
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
          <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('acquaintance.addAcq') }}</h1>
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

      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "acquaintances/" + id;
      });

      $('#editAcquaintance').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let name = button.data('name');
        let mobile = button.data('mobile');
        let email = button.data('email');
        let position = button.data('position');
        let form = document.getElementById('editForm');
        $('#id').val(id);
        $('#name').val(name);
        $('#mobile').val(mobile);
        $('#email').val(email);
        $('#position').val(position);
        form.action = "acquaintances/" + id;
      });
    });
  </script>
@endsection