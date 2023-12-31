@extends('layout.master')

@section('title')
  {{ __('attachments.attachments') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
@endsection

@section('h1')
  {{ __('attachments.attachments') }}
@endsection

@section('breadcrumb')
  {{ __('attachments.attachments') . ' / ' . __('global.all')}}
@endsection

@section('content')
<div class="row">
  <div class="col d-flex justify-content-end mb-3">
    <button
      type="button"
      data-bs-toggle="modal"
      data-bs-target="#addAttachment"
      class="btn btn-success">
      <i class="bi bi-plus-square-fill me-1"></i>
      {{ __('global.add') }}
    </button>
  </div>
  @if ($errors->any())
    <div class="alert alert-danger mt-5">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        @if (count($folders) == 0)
          <div class="alert alert-danger my-5" role="alert">
            {{ __('attachments.noAtt') }}
          </div>
        @else
          <h5 class="card-title">
            {{ __('attachments.allAtt') }}
          </h5>
          <div class="row">
            @foreach ($folders as $folder)
              <div class="col-md-3 text-center my-3">
                  <a href="{{ route('folder.contents', Str::lower(Str::after($folder->attachmentable_type, 'App\Models\\'))) }}">
                    <img src="{{ asset('assets/img/folder-icon.png') }}" width="128" height="128">
                    <div>{{ __('folders.' . Str::after($folder->attachmentable_type, 'App\Models\\')) }}</div>
                  </a>
                </div>
            @endforeach
          </div>
        @endif
<!-- Add Modal -->
<div class="modal fade" id="addAttachment" tabindex="-1" aria-labelledby="addAttachmentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addAttachmentLabel">{{ __('attachments.addAtt') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('attachment.store') }}" method="POST" id="addForm" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col">
              <label for="attachment_type" class="form-label">{{ __('attachments.type') }}</label>
              <select class="form-select" id="attachment_type" name="attachment_type" style="width:100%">
                <option selected disabled>{{ __('global.select') }}</option>
                @foreach ($types as $type)
                  <option value="{{ $type->id }}" @selected( $type->id == old('type->id'))>{{  $type->{'attachment_type' . session('_lang')} }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col">
              <div class="mb-3">
                <label for="title" class="form-label">{{ __('attachments.title') }}</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="attachment" class="col-form-label">{{ __('global.attachment') }}</label>
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
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>

  <script>
    $(document).ready(function (){
      $("#attachment_type").select2({
        dropdownParent: $('#addAttachment')
      });

      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      });
    });
  </script>
@endsection