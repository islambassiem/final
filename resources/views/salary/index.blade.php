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
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('salary.payslip') }}
        </h5>
        <form action="{{ route('payslip') }}" method="post">
          @csrf
          <div class="row d-flex">
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('salary.month') }}</label>
                <select name="month" id="" class="form-control">
                  <option value="" selected disabled>{{ __('global.select') }}</option>
                  @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="to">{{ __('salary.year') }}</label>
                <select name="year" id="" class="form-control">
                  <option value="" selected  disabled>{{ __('global.select') }}</option>
                  @for ($i = 2024; $i <= 2036; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>
            <div class="d-flex justify-content-end align-items-center">
              <button type="submit" class="btn btn-primary mx-2">{{ __('global.submit') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
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
    });
  </script>
@endsection