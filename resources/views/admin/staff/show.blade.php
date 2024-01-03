@extends('admin.layout.master')


@section('title')
  {{ __('head/staff.staff') }}
@endsection


@section('style')
@endsection

@section('h1')
{{ __('head/staff.staff') }}
@endsection


@section('breadcrumb')
{{ __('head/staff.staff') .  ' / ' . __('global.all')}}
@endsection

@section('content')
  <section class="section">
    <div class="card card-body">
      <div class="card-title">
        <h5 class="card-title">
          {{ __('head/staff.allStaff') }}
        </h5>
      </div>
    </div>
  </section>
@endsection


@section('script')
@endsection