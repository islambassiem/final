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
          @if (count($letters) == 0)
            <div class="alert alert-danger my-5" role="alert">
              {{ __('letters.noLetters') }}
            </div>
          @else
            <h5 class="card-title">{{  __('letters.letters') }}</h5>
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
                  <th scope="col">{{ __('admin/letters.empid') }}</th>
                  <th scope="col">{{ __('admin/letters.name') }}</th>
                  <th scope="col">{{ __('letters.addressee') }}</th>
                  <th scope="col">{{ __('letters.English') }}</th>
                  <th scope="col">{{ __('letters.Salary') }}</th>
                  <th scope="col">{{ __('letters.Loan') }}</th>
                  <th scope="col">{{ __('letters.Attested') }}</th>
                  <th scope="col">{{ __('letters.Deduction') }}</th>
                  <th scope="col">{{ __('letters.appliedAt') }}</th>
                </tr>
              </thead>
              <tbody>
                @php $c = 1; @endphp
                @foreach ($letters as $letter)
                  <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $letter->user->empid }}</td>
                    <td>{{ session('_lang') == '_ar' ? $letter->user->getFullArabicNameAttribute : $letter->user->getFullEnglishNameAttribute }}</td>
                    <td>{{ $letter->addressee }}</td>
                    <td>@php echo $letter->boolToIcon($letter->english) @endphp</td>
                    <td>@php echo $letter->boolToIcon($letter->salary) @endphp</td>
                    <td>@php echo $letter->boolToIcon($letter->loan) @endphp</td>
                    <td>@php echo $letter->boolToIcon($letter->attested) @endphp</td>
                    <td>@php echo $letter->boolToIcon($letter->deduction) @endphp</td>
                    <td>{{  $letter->created_at  }}</td>
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