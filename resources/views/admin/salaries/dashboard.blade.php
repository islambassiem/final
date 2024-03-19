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
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if (session('salarySuccess'))
      <div class="alert alert-success">
        {{ session('salarySuccess') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="w-50 mx-auto">
          <h1 class="card-title  text-center">
            <i class="bi bi-cash-coin fs-1"></i>
          </h1>
          <p class="h1 text-center">{{ __('admin/salaries.salaryOf') . ' ' . __("admin/salaries.$month") }}</p>
          <div class="row">
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
          <div class="row">
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
          <div class="row">
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
          <div class="row">
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
          @if (! $status)
            <div class="row mt-5">
              <div class="col-md-12 d-flex justify-content-end">
                <button
                  type="button"
                  class="btn btn-primary btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#confirmation">
                  <span>
                    <i class="bi bi-gear-fill fs-6"></i>
                    <span class="fs-6">{{ __('admin/salaries.process') }}</span>
                  </span>
                </button>
              </div>
            </div>
            <div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('admin/salaries.prConf') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('salary.process') }}" method="post" id="processForm">
                      @csrf
                      @method('post')
                      <input type="hidden" name="month" value="{{ $month_id }}">
                      <div class="row">
                        <div class="row">
                          <div class="col">
                            <div class="modal-body">
                              {{ __('admin/salaries.msgBody') }}
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="fingerprint" name="fingerprint" @if (old('fingerprint')) checked  @endif>
                            <label class="form-check-label" for="fingerprint">{{ __('admin/salaries.fingerprint') }}</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="payablesConf" name="payablesConf" @if (old('payablesConf')) checked  @endif>
                            <label class="form-check-label" for="payablesConf">{{ __('admin/salaries.payablesConf') }}</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="deductablesConf" name="deductablesConf" @if (old('deductablesConf')) checked  @endif>
                            <label class="form-check-label" for="deductablesConf">{{ __('admin/salaries.deductablesConf') }}</label>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('global.close') }}</button>
                    <button type="submit" class="btn btn-success" form="processForm">{{ __('global.submit') }}</button>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection


@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script>
    $(document).ready(function(){
      var elements = document.querySelectorAll('[data-id]');
      elements.forEach(element => {
        if(element.getAttribute('data-status') == 1){
          element.style.opacity = '0.5';
          element.style.pointerEvents = 'none';
        }
      });
    });
  </script>
@endsection