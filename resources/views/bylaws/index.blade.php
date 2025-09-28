@extends('layout.master')

@section('title')
  {{ __('attachments.attachments') }}
@endsection

@section('h1')
  {{ __('sidebar.bylaws') }}
@endsection

@section('breadcrumb')
  {{ __('sidebar.bylaws') }}
@endsection

@section('content')
  <embed src="storage/gallary/bylaws.pdf" type="application/pdf" width="100%" style="height: 80vh;">
@endsection
