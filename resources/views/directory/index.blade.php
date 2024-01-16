@extends('layout.master')

@section('title')
  {{ __('directory.directory') }}
@endsection

  @section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
@endsection

@section('h1')
  {{ __('directory.directory') }}
@endsection

@section('breadcrumb')
  {{ __('directory.directory') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
              <h5 class="card-title">{{ __('directory.directory') }}</h5>
              <!-- Table with stripped rows -->
              <table class="table table-striped" id="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('directory.empid')}}</th>
                    <th scope="col">{{ __('directory.name') }}</th>
                    <th scope="col">{{ __('directory.department') }}</th>
                    <th scope="col">{{ __('directory.ext') }}</th>
                    <th scope="col">{{ __('directory.email') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php $c = 1; @endphp
                  @foreach ($users as $user)
                    <tr>
                      <td>{{ $c }}</td>
                      <td>{{ $user->empid }}</td>
                      <td>{{ session('_lang') == '_ar' ? $user->getFullArabicNameAttribute : $user->getFullEnglishNameAttribute }}</td>
                      <td>{{ $user->section?->{'section' . session('_lang')} }}</td>
                      <td>{{ $user->extension($user->id) }}</td>
                      <td>{{ $user->email }}</td>
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
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script>
    $(document).ready(function (){
      var lang = "{{ session('lang') }}";
      var file;
      switch (lang) {
        case "ar":
          file = "{{ asset('assets/vendor/datatables/ar.json') }}"
          break;
        case "pk":
          file = "{{ asset('assets/vendor/datatables/pk.json') }}"
          break;
        case "in":
          file = "{{ asset('assets/vendor/datatables/in.json') }}"
          break;
        case "ph":
          file = "{{ asset('assets/vendor/datatables/ph.json') }}"
          break;
        default:
          file = "{{ asset('assets/vendor/datatables/en.json') }}"
          break;
      }
        $('#table').dataTable({
          language: {
            url: file
          }
        });
    });
  </script>
@endsection