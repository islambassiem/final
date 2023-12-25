@extends('layout.master')

@section('title')
  {{ __('attachments.attachments') }}
@endsection

@section('style')
  <style>
    .icon{
      font-size: 128px;
    }
  </style>
@endsection

@section('h1')
  {{ __('attachments.attachments') }}
@endsection

@section('breadcrumb')
  {{ __('Attachment / ' .  __('folders.' . Str::ucfirst(request()->segment(2)))) }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex mb-3">
        <a href="{{ route('attachments.index') }}"
          class="btn btn-danger">
          <i class="bi bi-backspace-fill me-1"></i>
          {{ __('global.back') }}
        </a>
      </div>
    </div>
    <div class="card card-body">
      <h5 class="card-title">
        {{ Str::ucfirst(request()->segment(2)) }}
      </h5>
      <div class="row">
        @foreach ($files as $file)
        <div class="col-md-3 text-center my-3">
          <a href="{{ route('attachment.download', $file->id) }}" class="icon">
            @if (Str::after($file->link, '.') == 'pdf')
              <i class="bi bi-file-earmark-pdf-fill icon"></i>
            @else
              <i class="bi bi-card-image icon"></i>
            @endif
          </a>
          <div>{{ $file->title .' | ' . $file->attachmentable_id}}</div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection

@section('script')
@endsection