@extends('admin.layout.master')


@section('title')
  {{ __('admin/salaries.salaries') }}
@endsection


@section('h1')
{{ __('admin/salaries.salaries') }}
@endsection

@section('breadcrumb')
{{ __('admin/salaries.salaries') .  ' / ' . __('global.all')}}
@endsection



@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="w-50 mx-auto">
          <h1 class="card-title  text-center">
            <i class="bi bi-cash-coin fs-1"></i>
          </h1>
          <p class="h1 text-center">{{ __('admin/salaries.salaryOf') . ' ' . __("admin/salaries.$month") }}</p>
          <div class="row mt-5">
            <div class="col-md-6">
              <p class="text-primary fs-4">{{ __('admin/salaries.workingDays') }}</p>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <div class="d-flex align-items-center">
                <a href="{{ route('admin.salaries.working', $month_id) }}" class="btn btn-primary btn-sm">
                  <i class="bi bi-eye-fill"></i>
                  {{ __('admin/salaries.show') }}
                </a>
              </div>
            </div>
            <hr>
          </div>
          <div class="row mt-5">
            <div class="col-md-6">
              <p class="text-dark fs-4">{{ __('admin/salaries.nonWorkingDays') }}</p>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <div class="d-flex align-items-center">
                <a href="{{ route('admin.salaries.non.working', $month_id) }}" class="btn btn-dark btn-sm">
                  <i class="bi bi-eye-fill"></i>
                  {{ __('admin/salaries.show') }}
                </a>
              </div>
            </div>
            <hr>
          </div>
          <div class="row mt-5">
            <div class="col-md-6">
              <p class="text-success fs-4">{{ __('admin/salaries.payables') }}</p>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <div class="d-flex align-items-center">
                <a href="{{ route('admin.salaries.payables', $month_id) }}" class="btn btn-success btn-sm">
                  <i class="bi bi-eye-fill"></i>
                  {{ __('admin/salaries.show') }}
                </a>
              </div>
            </div>
            <hr>
          </div>
          <div class="row mt-5">
            <div class="col-md-6">
              <p class="text-danger fs-4">{{ __('admin/salaries.deductables') }}</p>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <div class="d-flex align-items-center">
                <a href="{{ route('admin.salaries.deductables', $month_id) }}" class="btn btn-danger btn-sm">
                  <i class="bi bi-eye-fill"></i>
                  {{ __('admin/salaries.show') }}
                </a>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection