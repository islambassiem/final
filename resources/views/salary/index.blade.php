@extends('layout.master')

@section('title')
  {{ __('salary.salary') }}
@endsection

@section('style')
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
@endsection