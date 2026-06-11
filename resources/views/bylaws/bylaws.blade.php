@extends('bylaws.layout')

@section('embed')
    <embed src="{{ asset('storage/gallary/bylaws/bylaws.pdf') }}" type="application/pdf" width="100%" style="height: 80vh;">
@endsection