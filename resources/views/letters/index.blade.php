@extends('layout.master')

@section('title')
  {{ __('letters.letters') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
  {{ __('letters.letters') }}
@endsection

@section('breadcrumb')
  {{ __('letters.requests') .   ' / '  .  __('letters.letters') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#addLetter"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('global.add') }}
        </button>
      </div>
    </div>
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



  <!-- Add Modal -->
<div class="modal fade" id="addLetter" tabindex="-1" aria-labelledby="addLetterLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addLetterLabel">{{ __('letters.addLetter') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('letters.store') }}" method="POST" id="addForm">
          @csrf
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="addressee" class="form-label required">{{ __('letters.addressee') }}</label>
                <input type="text" class="form-control" id="addressee" name="addressee" value="{{ old('addressee') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="english" name="english" @if (old('english')) checked  @endif>
              <label class="form-check-label" for="english">{{ __('letters.english') }}</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="salary" name="salary" @if (old('salary')) checked  @endif>
              <label class="form-check-label" for="salary">{{ __('letters.salary') }}</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="loan" name="loan" @if (old('loan')) checked  @endif>
              <label class="form-check-label" for="loan">{{ __('letters.loan') }}</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="attested" name="attested" @if (old('attested')) checked  @endif>
              <label class="form-check-label" for="attested">{{ __('letters.attested') }}</label>
            </div>
          </div>
          <div class="col-12 d-none" id="deductionAcceptance">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="deduction" name="deduction" @if (old('deduction')) checked  @endif>
              <label class="form-check-label" for="deduction">{{ __('letters.agree') }}</label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
        <button type="submit" class="btn btn-primary" form="addForm">{{ __('global.add') }}</button>
      </div>
    </div>
  </div>
</div>
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
      document.getElementById('attested').addEventListener('change', function (){
        console.log(this.value);
        if(this.value == "on"){
          document.getElementById('deductionAcceptance').classList.remove('d-none');
        }
      });
    });
  </script>
@endsection