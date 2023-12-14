@extends('layout.master')

@section('title')
  {{ __('Attachments') }}
@endsection

@section('style')
  <style>
    .icon i{
      color: rgb(255, 233, 162);
      background-color: #aaa;
      font-size: 100px;
      padding-right: 15px;
      padding-left: 15px;
      border-radius: 15px
    }
  </style>
@endsection

@section('h1')
  {{ __('Attachments') }}
@endsection

@section('breadcrumb')
  {{ __('Attachments / All') }}
@endsection

@section('content')
  @if (count($folders) == 0)
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('There are no attchments') }}
        </h5>
      </div>
    </div>
  @else
    
  @endif
  @foreach ($folders as $folder)
    <div>{{ __(Str::after($folder->attachmentable_type, 'App\Models\\')) }}</div>
  @endforeach
@endsection

@section('script')
@endsection