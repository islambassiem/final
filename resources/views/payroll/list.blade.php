@extends('layout.master')

@section('title')
  {{ __('Payroll List') }}
@endsection


@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection


@section('h1')
{{ __('Payroll Result') }}
@endsection

@section('breadcrumb')
{{ __('payroll') }}
@endsection


@section('content')

  <section class="section">
    <div class="row">
      <div class="col-md-8 offset-md-1">
        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="card margin-auto">
          <div class="card-body">
            <h5 class="card-title">{{ __('Salary File') }}</h5>

            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('salary.csv', ['type' => 'sponsored']) }}"
                class="btn btn-primary">
                    Download Sponsored
                </a>

                <a href="{{ route('salary.csv', ['type' => 'non']) }}"
                class="btn btn-info">
                    Download Non-Sponsored
                </a>

                <a href="{{ route('salary.csv', ['type' => 'cheques']) }}"
                class="btn btn-warning">
                    Download Cheques
                </a>

                <a href="{{ route('salary.csv', ['type' => 'all']) }}"
                class="btn btn-success">
                    Download All
                </a>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>

@endsection