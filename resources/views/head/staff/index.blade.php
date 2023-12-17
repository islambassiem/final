@extends('layout.master')

@section('title')
  {{ __('Staff') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('h1')
  {{ __('Staff') }}
@endsection

@section('breadcrumb')
  {{ __('Staff / All') }}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        @if (count($staff) == 0)
          <div class="alert alert-danger my-5" role="alert">
            {{ __('There are no staff under your supervision') }}
          </div>
        @else
          <h5 class="card-title">
            {{ __('All Staff') }}
          </h5>
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('Gender') }}</th>
                <th scope="col">{{ __('Mobile') }}</th>
                <th scope="col">{{ __('Extention') }}</th>
                <th scope="col">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @php $c = 1; @endphp
              @foreach ($staff as $member)
                <tr>
                  <td>{{ $c }}</td>
                  <td>{{ session('_lang') == '_ar' ? $member->getFullArabicNameAttribute : $member->getFullEnglishNameAttribute }}</td>
                  <td>{{ $member->gender->{'gender' . session('_lang')} }}</td>
                  <td>{{ $member->mobile($member->id)?->contact }}</td>
                  <td>{{ $member->extension($member->id)?->contact }}</td>
                  <td>
										<a href="">{{ __('Permission') }}</a>
										<a href="">{{ __('Vacation') }}</a>
									</td>
                </tr>
                @php $c++; @endphp
              @endforeach
            </tbody>
          </table>
        @endif
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