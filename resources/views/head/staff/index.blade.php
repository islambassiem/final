@extends('layout.master')

@section('title')
  {{ __('head/staff.staff') }}
@endsection

@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
@endsection

@section('h1')
  {{ __('head/staff.staff') }}
@endsection

@section('breadcrumb')
  {{ __('head/staff.staff') . ' / ' . __('global.all') }}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        @if (count($staff) == 0)
          <div class="alert alert-danger my-5" role="alert">
            {{ __('head/staff.noStaff') }}
          </div>
        @else
          <h5 class="card-title">
            {{ __('head/staff.allStaff') }}
          </h5>
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{ __('head/staff.name') }}</th>
                <th scope="col">{{ __('head/staff.gender') }}</th>
                <th scope="col">{{ __('head/staff.mobile') }}</th>
                <th scope="col">{{ __('head/staff.ext') }}</th>
                <th scope="col">{{ __('global.action') }}</th>
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
										<a href="" class="btn btn-primary btn-sm py-0"><i class="bi bi-stopwatch-fill"></i></a>
										<a href=""class="btn btn-danger btn-sm py-0"><i class="bi bi-person-walking"></i></a>
										<a href=""class="btn btn-secondary btn-sm py-0"><i class="bi bi-person-fill-gear"></i></a>
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