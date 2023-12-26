@extends('layout.master')

@section('title')
  {{ __('achievements.achievements') }}
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
  {{ __('achievements.achievements') }}
@endsection

@section('breadcrumb')
  {{ __('achievements.achievements') . ' / ' . __('global.all') }}
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
          @if (count($achievements) == 0)
            <div class="alert alert-danger my-5" role="alert">
              {{ __('achievements.noAchievements') }}
            </div>
          @else
            <h5 class="card-title">{{ __('achievements.achievements') }}</h5>
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
                  <th scope="col">{{ __('achievements.achievements') }}</th>
                  <th scope="col">{{ __('achievements.donor') }}</th>
                  <th scope="col">{{ __('achievements.year') }}</th>
                  <th scope="col">{{ __('global.action') }}</th>
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
                        data-attachment = "{{ $achievement->attachment }}"
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
                      <a
                      href="{{ route('attachment.achievement', $achievement->id) }}"
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

<!-- Edit Modal -->
<div class="modal fade" id="editAchievement" tabindex="-1" aria-labelledby="editAchievementLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editAchievementLabel">{{ __('achievements.edit') }}</h1>
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
                <label for="title" class="form-label required">{{ __('achievements.title') }}</label>
                <input type="text" class="form-control" id="titleEdit" name="title" value="{{ old('title') }}">
                <span class="text-secondary"><small id="titleEditSmall"></small></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="donor" class="form-label">{{ __('achievements.title') }}</label>
                <input type="text" class="form-control" id="donorEdit" name="donor" value="{{ old('donor') }}">
                <span class="text-secondary"><small id="donorEditSmall"></small></span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="mb-3">
              <label for="year" class="form-label required">{{ __('achievements.title') }}</label>
              <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}">
            </div>
          </div>
          <div class="row" id="attachmentRow">
            <div class="col-12">
              <label for="attachment" class="col-sm-2 col-form-label">{{ __('global.attachment') }}</label>
              <div class="col-sm-12">
                <input
                  type="file"
                  class="dropify"
                  id="attachment_edit"
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
        <button type="submit" class="btn btn-primary" form="editForm">{{ __('global.save') }}</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addAchievement" tabindex="-1" aria-labelledby="addAchievementLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addAchievementLabel">{{ __('achievements.add') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('achievements.store') }}" method="POST" id="addForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="titleAdd" class="form-label required">{{ __('achievements.title') }}</label>
                <input type="text" class="form-control" maxlength="100" id="titleAdd" name="title" value="{{ old('title') }}">
                <span class="text-secondary"><small id="titleAddSmall"></small></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="donor" class="form-label">{{ __('achievements.donor') }}</label>
                <input type="text" class="form-control" id="donorAdd" maxlength="100" name="donor" value="{{ old('donor') }}">
                <span class="text-secondary"><small id="donorAddSmall"></small></span>
              </div>
            </div>
          </div>
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <label for="year" class="form-label required">{{ __('achievements.year') }}</label>
                  <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}">
                </div>
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
        let attachment = button.data('attachment');
        let form = document.getElementById('editForm');
        if(attachment != ''){
          $('#attachmentRow').remove();
        }
        $('#id').val(id);
        $('#titleEdit').val(title);
        $('#donorEdit').val(mobile);
        $('#year').val(email);
        form.action = "achievements/" + id;
      });

      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      });

      let max = "{{ __('global.max') }}";
      let titleAdd = document.getElementById('titleAdd');
      let titleAddSmall = document.getElementById('titleAddSmall');
      let donorAdd = document.getElementById('donorAdd');
      let donorAddSmall = document.getElementById('donorAddSmall');
      let titleEdit = document.getElementById('titleEdit');
      let titleEditSmall = document.getElementById('titleEditSmall');
      let donorEdit = document.getElementById('donorEdit');
      let donorEditSmall = document.getElementById('donorEditSmall');

      donorAdd.addEventListener('keyup', function(){
        let char = this.value.length;
        donorAddSmall.innerHTML = `${max} ${char} / 100`;
      });
      donorAddSmall.innerHTML = `${max} ${donorAdd.value.length} / 100`;

      titleAdd.addEventListener('keyup', function(){
        let char = this.value.length;
        titleAddSmall.innerHTML = `${max} ${char} / 100`;
      });
      titleAddSmall.innerHTML = `${max} ${titleAdd.value.length} / 100`;

      donorEdit.addEventListener('keyup', function(){
        let char = this.value.length;
        donorEditSmall.innerHTML = `${max} ${char} / 100`;
      });
      donorEditSmall.innerHTML = `${max} ${donorEdit.value.length} / 100`;

      titleEdit.addEventListener('keyup', function(){
        let char = this.value.length;
        titleEditSmall.innerHTML = `${max} ${char} / 100`;
      });
      titleEditSmall.innerHTML = `${max} ${titleEdit.value.length} / 100`;
    });
  </script>
@endsection