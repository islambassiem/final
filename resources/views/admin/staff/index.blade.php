@extends('admin.layout.master')


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
{{ __('head/staff.staff') .  ' / ' . __('global.all')}}
@endsection

@section('content')
  <section class="section">
    <div class="card card-body">
      <div class="card-title">
        <h5 class="card-title">
          {{ __('head/staff.allStaff') }}
        </h5>
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">{{ __('admin/staff.empid') }}</th>
              <th scope="col">{{ __('head/staff.name') }}</th>
              <th scope="col">{{ __('admin/staff.iqama') }}</th>
              <th scope="col">{{ __('admin/staff.salary') }}</th>
              <th scope="col">{{ __('head/staff.ext') }}</th>
              <th scope="col">{{ __('head/staff.mobile') }}</th>
              <th scope="col">{{ __('admin/staff.email') }}</th>
              <th scope="col">{{ __('global.action') }}</th>
              {{-- <th scope="col">{{ __('global.action') }}</th> --}}
            </tr>
          </thead>
          <tbody>
            @php $c = 1; @endphp
            @foreach ($staff as $member)
              <tr>
                <td>{{ $c }}</td>
                <td>{{ $member->empid }}</td>
                <td>{{ session('_lang') == '_ar' ? $member->getFullArabicNameAttribute : $member->getFullEnglishNameAttribute }}</td>
                <td>{{ $member->iqama($member->id)->document_id }}</td>
                <td>{{ $member->latestSalary($member->id) }}</td>
                <td>{{ $member->extension($member->id) }}</td>
                <td>{{ $member->mobile($member->id) }}</td>
                <td>{{ $member->email }}</td>
                <td><a href="{{ route('admin.employee', $member) }}" class="btn btn-primary btn-sm py-0"><i class="bi bi-person-fill-gear"></i></a></td>
                {{-- <td>
                  <a href="" class="btn btn-primary btn-sm py-0"><i class="bi bi-stopwatch-fill"></i></a>
                  <a href=""class="btn btn-danger btn-sm py-0"><i class="bi bi-person-walking"></i></a>
                  <a href=""class="btn btn-secondary btn-sm py-0"><i class="bi bi-person-fill-gear"></i></a>
                </td> --}}
              </tr>
              @php $c++; @endphp
            @endforeach
          </tbody>
        </table>
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
      $('#actionModal').on('show.bs.modal', function (event){
      let button = $(event.relatedTarget);
      let id = button.data('id');
      let form = document.getElementById('actionForm');
      form.action = "vacations/action/" + id;
    });
    });
</script>
@endsection