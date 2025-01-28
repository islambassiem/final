@extends('layout.master')

@section('title')
  {{ __('salary.salary') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <style>
    table thead tr th{
      font-weight: 900 !important;
    }
  </style>
@endsection

@section('h1')
  {{ __('salary.salary') }}
@endsection

@section('breadcrumb')
  {{ __('salary.salary') . ' / '  . __('global.show')}}
@endsection

@section('content')
  <section class="section">
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    @if (session('noSalary'))
      <div class="alert alert-danger">
        {{ session('noSalary') }}
      </div>
    @endif
    {{--  <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('salary.payslip') }}
        </h5>
        <form action="{{ route('payslip') }}" method="get">
          @csrf
          <div class="row d-flex">
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('salary.year') }}</label>
                <select name="year" id="years" class="form-control">
                  <option value="" selected  disabled>{{ __('global.select') }}</option>
                  @foreach ($years as $year)
                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('salary.month') }}</label>
                <select name="month" id="month" class="form-control"></select>
              </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3 d-flex justify-content-end align-items-center">
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary mx-2">{{ __('global.submit') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>  --}}
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('salary.history') }}</h5>
            <!-- Table with stripped rows -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">{{ __('salary.basic') }}</th>
                  <th scope="col">{{ __('salary.housing') }}</th>
                  <th scope="col">{{ __('salary.transportation') }}</th>
                  <th scope="col">{{ __('salary.food') }}</th>
                  <th scope="col">{{ __('salary.package') }}</th>
                  <th scope="col">{{ __('salary.effective') }}</th>
                </tr>
              </thead>
              <tbody>
                @php $c = 1; @endphp
                @foreach ($salary as $item)
                  <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $item->basic }}</td>
                    <td>{{ $item->housing }}</td>
                    <td>{{ $item->transportation }}</td>
                    <td>{{ $item->food }}</td>
                    <td>{{ $item->package() }}</td>
                    <td>{{ $item->effective }}</td>
                  </tr>
                  @php $c++; @endphp
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script>
    $(document).ready(function(){
      $('select').select2();
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