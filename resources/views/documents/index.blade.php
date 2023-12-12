@extends('layout.master')

@section('title')
  {{ __('Documents') }}
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
<style>
  table thead tr th{
    font-weight: 900 !important;
  }
</style>
@endsection

@section('h1')
  {{ __('Documents') }}
@endsection

@section('breadcrumb')
  {{ __('Documents / Al') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#addDocument"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('Add') }}
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('All Documents') }}</h5>
            @if ($errors->any())
              <div class="alert alert-danger pb-0">
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
            @if ($docNum == 0)
              <div class="alert alert-danger" role="alert">
                {{ __('There are no documents Registered') }}
              </div>
            @else
              @if (session('message'))
                <div class="alert alert-warning" role="alert">
                  {{ session('message') }}
                </div>
              @endif
              <!-- Table with stripped rows -->
              <table class="table table-striped text-center">
                <thead>
                  <tr>
                    <th scope="col">{{ __('Document') }}</th>
                    <th scope="col">{{ __('Document Number') }}</th>
                    <th scope="col">{{ __('Place of issue') }}</th>
                    <th scope="col">{{ __('Date of issue') }}</th>
                    <th scope="col">{{ __('Date of Expiry') }}</th>
                    <th scope="col">{{ __('Notification') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($nationalIds as $id)
                    <tr>
                      <td>{{ $id->document->{'attachment_type' . session('_lang')} }}</td>
                      <td>{{ $id->document_id }}</td>
                      <td>{{ blank($id->place_of_issue) ? __("N/A") : $id->place_of_issue}}</td>
                      <td>{{ blank($id->date_of_issue) ? __("N/A") : $id->date_of_issue }}</td>
                      <td>{{ $id->date_of_expiry }}</td>
                      <td>{{ $id->notification }}</td>
                      <td>
                        <button
                          type="button"
                          data-id = "{{ $id->id }}"
                          data-place = "{{ $id->place_of_issue }}"
                          data-date = "{{ $id->date_of_issue }}"
                          data-not = "{{ $id->notification }}"
                          data-attachment = "{{ $id->attachment }}"
                          data-bs-toggle="modal"
                          data-bs-target="#editID"
                          class="btn btn-warning btn-sm py-0">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <a
                          href="{{ route('document.attachment', $id->id) }}"
                          class="btn btn-info btn-sm py-0">
                          <i class="bi bi-paperclip"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                  @foreach ($passports as $passport)
                    <tr>
                      <td>{{ $passport->document->{'attachment_type' . session('_lang')} }}</td>
                      <td>{{ $passport->document_id }}</td>
                      <td>{{ blank($passport->place_of_issue) ? __("N/A") : $passport->place_of_issue}}</td>
                      <td>{{ blank($passport->date_of_issue) ? __("N/A") : $passport->date_of_issue }}</td>
                      <td>{{ $passport->date_of_expiry }}</td>
                      <td>{{ $passport->notification }}</td>
                      <td>
                        <button
                          type="button"
                          data-id = "{{ $passport->id }}"
                          data-place = "{{ $passport->place_of_issue }}"
                          data-date = "{{ $passport->date_of_issue }}"
                          data-exp = "{{ $passport->date_of_expiry}}"
                          data-not = "{{ $passport->notification }}"
                          data-attachment = "{{ $passport->attachment }}"
                          data-bs-toggle="modal"
                          data-bs-target="#editPassport"
                          class="btn btn-warning btn-sm py-0">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <a
                          href="{{ route('document.attachment', $passport->id) }}"
                          class="btn btn-info btn-sm py-0">
                          <i class="bi bi-paperclip"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                  @foreach ($documents as $document)
                    <tr>
                      <td>{{ $document->document_type_id >= 6 ? $document->description : $document->document->{'attachment_type' . session('_lang')} }}</td>
                      <td>{{ $document->document_id }}</td>
                      <td>{{ blank($document->place_of_issue) ? __("N/A") : $document->place_of_issue }}</td>
                      <td>{{ blank($document->date_of_issue) ? __("N/A") : $document->date_of_issue }}</td>
                      <td>{{ $document->date_of_expiry }}</td>
                      <td>{{ $document->notification }}</td>
                      <td>
                        <button
                          type="button"
                          data-id = "{{ $document->id }}"
                          data-desc = "{{ $document->description }}"
                          data-doc-id = "{{ $document->document_id }}"
                          data-place = "{{ $document->place_of_issue }}"
                          data-date = "{{ $document->date_of_issue }}"
                          data-exp = "{{ $document->date_of_expiry}}"
                          data-not = "{{ $document->notification }}"
                          data-attachment = "{{ $document->attachment }}"
                          data-bs-toggle="modal"
                          data-bs-target="#editDocument"
                          class="btn btn-warning btn-sm py-0">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <a
                          href="{{ route('document.attachment', $document->id) }}"
                          class="btn btn-info btn-sm py-0">
                          <i class="bi bi-paperclip"></i>
                        </a>
                      </td>
                    </tr>
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

  <!-- Add a document Modal -->
  <div class="modal fade" id="addDocument" tabindex="-1" aria-labelledby="addDocumentLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addDocumentLabel">{{ __('Add a new document') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data" id="addDocForm">
            @csrf
            <div class="row">
              <div class="col-8">
                <label for="docType" class="form-label">{{ __('Document Type') }}</label>
                <select class="form-select" aria-label="Default select example" id="docType" name="document_type_id">
                  <option selected disabled>{{ __('Select') }}</option>
                  <option value="2" @selected(old('document_type_id') == 2)>{{ __('Passport') }}</option>
                  <option value="6" @selected(old('document_type_id') == 6)>{{ __('Affiliation') }}</option>
                  <option value="7" @selected(old('document_type_id') == 7)>{{ __('Other') }}</option>
                </select>
              </div>
              <div class="col-4">
                <div class="mb-3">
                  <label for="notification" class="form-label">{{ __('Notification') }}</label>
                  <input type="number" class="form-control" id="notification" value="30" name="notification">
                </div>
              </div>
            </div>
            <div class="row d-none" id="descriptionRow">
              <div class="col">
                <div class="mb-3">
                  <label for="description" class="form-label">{{ __('Description') }}</label>
                  <input type="text" class="form-control" id="description" name="description">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="document_id" class="form-label">{{ __('Document Numner') }}</label>
                  <input type="text" id="document_id" class="form-control" name="document_id" value="{{ old('document_id') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="place_of_issue" class="form-label">{{ __('Place of Issue') }}</label>
                  <input type="text" class="form-control" id="place_of_issue" name="place_of_issue" value="{{ old('place_of_issue') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="date_of_issue" class="form-label">{{ __('Issue Date') }}</label>
                  <input type="date" class="form-control" id="date_of_issue" name="date_of_issue" value="{{ old('date_of_issue') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="date_of_expiry" class="form-label">{{ __('Expiry Date') }}</label>
                  <input type="date" class="form-control" id="date_of_expiry" name="date_of_expiry" value="{{ old('date_of_expiry') }}">
                </div>
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
          <button type="submit" form="addDocForm" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Iqama Modal -->
  <div class="modal fade" id="editID" tabindex="-1" aria-labelledby="editIDLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editIDLabel">{{ __('Edit National ID details') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="editIDForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="date_of_issue_iqama_edit" class="form-label">{{ __('Date of Issue') }}</label>
                  <input type="date" class="form-control" id="date_of_issue_iqama_edit" name="date_of_issue_iqama_edit">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="notification_iqama_edit" class="form-label">{{ __('Notification in Days') }}</label>
                  <input type="number" min="0" class="form-control" id="notification_iqama_edit" name="notification_iqama_edit">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="place_of_issue_iqama_edit" class="form-label">{{ __('Place of Issue') }}</label>
              <input type="text" class="form-control" id="place_of_issue_iqama_edit" name="place_of_issue_iqama_edit">
            </div>
            <div class="row" id="IDAttachmentRow">
              <div class="col-12">
                <label for="attachmentIqama" class="col-sm-2 col-form-label">{{ __('Attachment') }}</label>
                <div class="col-sm-12">
                  <input
                    type="file"
                    class="dropify"
                    id="attachmentIqama"
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
          <button type="submit" form="editIDForm" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit passport Modal -->
  <div class="modal fade" id="editPassport" tabindex="-1" aria-labelledby="editPassportLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editPassportLabel">{{ __('Edit Passport details') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="editPassportForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="date_of_issue_passport_edit" class="form-label">{{ __('Date of Issue') }}</label>
                  <input type="date" class="form-control" id="date_of_issue_passport_edit" name="date_of_issue_passport_edit">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="date_of_expiry_passport_edit" class="form-label">{{ __('Date of Expiry') }}</label>
                  <input type="date" class="form-control" id="date_of_expiry_passport_edit" name="date_of_expiry_passport_edit">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="place_of_issue_passport_edit" class="form-label">{{ __('Place of Issue') }}</label>
                  <input type="text" class="form-control" id="place_of_issue_passport_edit" name="place_of_issue_passport_edit">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="notification_passport_edit" class="form-label">{{ __('Notification in Days') }}</label>
                  <input type="number" min="0" class="form-control" id="notification_passport_edit" name="notification_passport_edit">
                </div>
              </div>
            </div>
            <div class="row" id="PassportAttachmentRow">
              <div class="col-12">
                <label for="attachmentPassport" class="col-sm-2 col-form-label">{{ __('Attachment') }}</label>
                <div class="col-sm-12">
                  <input
                    type="file"
                    class="dropify"
                    id="attachmentPassport"
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
          <button type="submit" form="editPassportForm" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit document Modal -->
  <div class="modal fade" id="editDocument" tabindex="-1" aria-labelledby="editDocumentLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editDocumentLabel">{{ __('Edit Document Details') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="editDocForm" enctype="multipart/form-data">
            @csrf
            <div class="row" id="editDescriptionRow">
              <div class="col-6">
                <div class="mb-3">
                  <label for="description_edit" class="form-label">{{ __('Description') }}</label>
                  <input type="text" class="form-control" id="description_edit" name="description_edit">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="notification_edit" class="form-label">{{ __('Notification') }}</label>
                  <input type="number" class="form-control" id="notification_edit" name="notification_edit">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="document_id_edit" class="form-label">{{ __('Document Number') }}</label>
                  <input type="text" class="form-control" name="document_id_edit" id="document_id_edit">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="place_of_issue_edit" class="form-label">{{ __('Place of Issue') }}</label>
                  <input type="text" class="form-control" name="place_of_issue_edit" id="place_of_issue_edit">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="date_of_issue_edit" class="form-label">{{ __('Issue Date') }}</label>
                  <input type="date" class="form-control" name="date_of_issue_edit" id="date_of_issue_edit">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="date_of_expiry_edit" class="form-label">{{ __('Expiry Date') }}</label>
                  <input type="date" class="form-control" name="date_of_expiry_edit" id="date_of_expiry_edit">
                </div>
              </div>
            </div>
            <div class="row" id="docAttachmentRow">
              <div class="col-12">
                <label for="attachmentDoc" class="col-sm-2 col-form-label">{{ __('Attachment') }}</label>
                <div class="col-sm-12">
                  <input
                    type="file"
                    class="dropify"
                    id="attachmentDoc"
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
          <button type="submit" form="editDocForm" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
  <script>
    $(document).ready(function(){
      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('Drag and drop or click to replace') }}",
          'remove':  "{{ __('Delete') }}",
          'error': "{{ __('Ooops, something wrong happended.') }}"
        }
      });

        $('#editID').on('show.bs.modal', function (event){
          let button = $(event.relatedTarget);
          let id = button.data('id');
          let form = document.getElementById('editIDForm');
          $('#date_of_issue_iqama_edit').val(button.data('date'));
          $('#place_of_issue_iqama_edit').val(button.data('place'));
          $('#notification_iqama_edit').val(button.data('not'));
          if(button.data('attachment') != ''){
            $('#IDAttachmentRow').remove();
          }
          form.action = "document/id/edit/" + id;
        });

        $('#editPassport').on('show.bs.modal', function (event){
          let button = $(event.relatedTarget);
          let id = button.data('id');
          let form = document.getElementById('editPassportForm');
          $('#date_of_issue_passport_edit').val(button.data('date'));
          $('#date_of_expiry_passport_edit').val(button.data('exp'));
          $('#place_of_issue_passport_edit').val(button.data('place'));
          $('#notification_passport_edit').val(button.data('not'));
          if(button.data('attachment') != ''){
            $('#PassportAttachmentRow').remove();
          }
          form.action = "document/passport/edit/" + id;
        });

        $('#editDocument').on('show.bs.modal', function (event){
          let button = $(event.relatedTarget);
          let id = button.data('id');
          let form = document.getElementById('editDocForm');
          $('#description_edit').val(button.data('desc'));
          $('#document_id_edit').val(button.data('doc-id'));
          $('#date_of_issue_edit').val(button.data('date'));
          $('#date_of_expiry_edit').val(button.data('exp'));
          $('#place_of_issue_edit').val(button.data('place'));
          $('#notification_edit').val(button.data('not'));
          if(button.data('attachment') != ''){
            $('#docAttachmentRow').remove();
          }
          form.action = "document/doc/edit/" + id;
        });
    });
  </script>
  <script>
    document.getElementById('docType').addEventListener('change', function (){
      if(this.value == 2){
        document.getElementById('notification').value = 180;
      }else{
        document.getElementById('notification').value = 30;
      }
      if(this.value >= 6){
        document.getElementById('descriptionRow').classList.remove("d-none");
      }else{
        document.getElementById('descriptionRow').classList.add("d-none");
      }
    });
  </script>
@endsection