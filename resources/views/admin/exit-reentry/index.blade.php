@extends('admin.layout.master')

@section('title')
  {{ __('admin/letters.letters') }}
@endsection

@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  @endif
@endsection

@section('h1')
{{ __('admin/letters.letters') }}
@endsection

@section('breadcrumb')
{{ __('admin/letters.letters')}}
@endsection

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger mt-5">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @if (count($visas) == 0)
            <div class="alert alert-danger my-5" role="alert">
              {{ __('letters.noLetters') }}
            </div>
          @else
            <h5 class="card-title">{{  __('admin/exit-reentry.visas') }}</h5>
            @if (session('success'))
              <div class="alert alert-success" role="alert">
                {{ session('success') }}
              </div>
            @endif
            <!-- Table with stripped rows -->
            <table class="table table-striped" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">{{ __('admin/exit-reentry.empid') }}</th>
                  <th scope="col">{{ __('admin/exit-reentry.name') }}</th>
                  <th scope="col">{{ __('admin/exit-reentry.departure') }}</th>
                  <th scope="col">{{ __('admin/exit-reentry.arrival') }}</th>
                  <th scope="col">{{ __('admin/exit-reentry.days') }}</th>
                  <th scope="col">{{ __('admin/exit-reentry.deduction') }}</th>
                  <th scope="col">{{ __('admin/exit-reentry.appliedAt') }}</th>
                </tr>
              </thead>
              <tbody>
                @php $c = 1; @endphp
                @foreach ($visas as $visa)
                  <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $visa->user->empid }}</td>
                    <td>{{ session('_lang') == '_ar' ? $visa->user->getFullArabicNameAttribute : $visa->user->getFullEnglishNameAttribute }}</td>
                    <td>{{ $visa->from }}</td>
                    <td>{{ $visa->to }}</td>
                    <td>{{ $visa->days() }}</td>
                    <td>@php echo $visa->boolToIcon($visa->deduction) @endphp</td>
                    <td>{{  $visa->created_at  }}</td>
                  </tr>
                  @php $c++; @endphp
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->
          @endif
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