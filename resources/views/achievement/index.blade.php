@extends('layout.master')

@section('title')
  {{ __('Achievements') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('h1')
  {{ __('Achievements') }}
@endsection

@section('breadcrumb')
  {{ __('Achievements / All') }}
@endsection

@section('content')
<section class="section">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <button
        type="button"
        data-bs-toggle="modal"
        data-bs-target="#addAchievement"
        class="btn btn-success">
        <i class="bi bi-plus-square-fill me-1"></i>
        {{ __('Add') }}
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
          @if (count($achievements) == 0)
            <div class="alert alert-danger my-5" role="alert">
              {{ __('There are no Acquaintance Registered') }}
            </div>
          @else
            <h5 class="card-title">{{ __('Acquaintance') }}</h5>
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
                  <th scope="col">{{ __('Achievement') }}</th>
                  <th scope="col">{{ __('Donor') }}</th>
                  <th scope="col">{{ __('Year') }}</th>
                  <th scope="col">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @php $c = 1; @endphp
                @foreach ($achievements as $achievement)
                  <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $achievement->title }}</td>
                    <td>{{ $achievement->donor }}</td>
                    <td>{{ $achievement->year }}</td>
                    <td>
                      <button
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#editAchievement"
                        data-id   = "{{ $achievement->id }}"
                        data-title = "{{ $achievement->title }}"
                        data-donor = "{{ $achievement->donor }}"
                        data-year  = "{{ $achievement->year }}"
                        class="btn btn-warning btn-sm py-0">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger btn-sm py-0"
                        id="btn"
                        data-id = "{{ $achievement->id }}"
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
<div class="modal fade" id="editAchievement" tabindex="-1" aria-labelledby="editAchievementLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editAchievementLabel">{{ __('Edit Achievement') }}</h1>
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
                <label for="title" class="form-label">{{ __('Achievement Title') }}</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="donor" class="form-label">{{ __('Donor') }}</label>
                <input type="text" class="form-control" id="donor" name="donor" value="{{ old('donor') }}">
              </div>
            </div>
          </div>
          <div class="col">
            <div class="mb-3">
              <label for="year" class="form-label">{{ __('Year') }}</label>
              <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
        <button type="submit" class="btn btn-primary" form="editForm">{{ __('Save') }}</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addAchievement" tabindex="-1" aria-labelledby="addAchievementLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addAchievementLabel">{{ __('Add an Achievement') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('achievements.store') }}" method="POST" id="addForm">
          @csrf
          <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="title" class="form-label">{{ __('Achievement Title') }}</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-">
              <div class="mb-3">
                <label for="donor" class="form-label">{{ __('Donor') }}</label>
                <input type="text" class="form-control" id="donor" name="donor" value="{{ old('donor') }}">
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="year" class="form-label">{{ __('Year') }}</label>
                  <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
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
            {{ __('Are you sure you want to delete the Achievement?') }}
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
        form.action = "achievements/" + id;
      });

      $('#editAchievement').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let title = button.data('title');
        let mobile = button.data('donor');
        let email = button.data('year');
        let form = document.getElementById('editForm');
        $('#id').val(id);
        $('#title').val(title);
        $('#donor').val(mobile);
        $('#year').val(email);
        form.action = "achievements/" + id;
      });
    });
  </script>
@endsection