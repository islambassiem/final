@extends('admin.layout.master')


@section('title')
  {{ __('admin/salaries.salaries') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
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
    @if (session('emailSent'))
      <div class="alert alert-success">
        {{ session('emailSent') }}
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
                  class="btn btn-primary btn-sm mx-2"
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
          @else
          <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-start">
              <a href="{{ route('paydeduct', $month_id) }}" class="btn btn-info mx-2"><i class="bi bi-receipt-cutoff me-2"></i>{{ __('admin/salaries.payDeduct') }}</a>
              <a href="{{ route('timesheet', $month_id) }}" class="btn btn-warning mx-2"><i class="bi bi-clock-history me-2"></i>{{ __('admin/salaries.timesheet') }}</a>
              <a href="{{ route('send', $month_id) }}" class="btn btn-dark mx-2"><i class="bi bi-send-arrow-up-fill me-2"></i>{{ __('admin/salaries.send') }}</a>
              {{-- <button
                  class="btn btn-dark ms-auto"
                  type="button"
                  data-bs-toggle="modal"
                  data-bs-target="#payslip">
                  <i class="bi bi-receipt-cutoff mx-2"></i>
                  {{ __('admin/salaries.payslip') }}
                </button> --}}
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  {{-- <div class="modal fade" id="payslip" tabindex="-1" aria-labelledby="payslipLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="payslipLabel">{{ __('admin/salaries.payslip') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('payslip') }}" method="get" id="payslipForm">
            @csrf
            <div class="row">
              <div class="col-12 mb-3">
                <label for="user" class="form-label">{{ __('admin/salaries.employee') }}</label>
                <select class="form-select" id="user" name="user_id" style="width:100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->user->id }}" @selected(old('user_id') == $user->user->id)>{{ $user->user->empid }} | {{ session('_lang') == '_en' ? $user->user->getFullEnglishNameAttribute : $user->user->getFullArabicNameAttribute }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="row d-flex">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="years">{{ __('salary.year') }}</label>
                  <select name="year" id="years" class="form-control">
                    <option value="" selected  disabled>{{ __('global.select') }}</option>
                    @foreach ($years as $year)
                      <option value="{{ $year->year }}">{{ $year->year }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="month">{{ __('salary.month') }}</label>
                  <select name="month" id="month" class="form-control"></select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
              <button type="submit" form="payslipForm" class="btn btn-primary">{{ __('global.submit') }}</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div> --}}
  </section>
@endsection


@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script>
    $(document).ready(function(){
      var elements = document.querySelectorAll('[data-id]');
      elements.forEach(element => {
        if(element.getAttribute('data-status') == 1){
          element.style.opacity = '0.5';
          element.style.pointerEvents = 'none';
        }
      });

      $('#years').select2({
        dropdownParent: $('#payslip')
      });
      $('#month').select2({
        dropdownParent: $('#payslip')
      });
      $('#user').select2({
        dropdownParent: $('#payslip')
      });
      $('#month').append("<option selected disabled>{{ __('global.select') }}</option>");
      $('#years').on('change.select2', function(e){
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        if(this.value){
          $.ajax({
            url: "{{ URL::to('payslip/month') }}/" + this.value,
            method: "post",
            dataType: "json",
            success: function(data){
              $('#month').empty();
              $('#month').append("<option selected disabled>{{ __('global.select') }}</option>");
              for (let i = 0; i < data.length; i++) {
                const element = data[i];
                let month = element.month;
                $('#month').append("<option value="+element.month+">"+element.month+"</option>");
              }
            }
          });
        }
      });
    });
  </script>
@endsection