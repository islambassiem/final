@extends('layout.master')

@section('title')
  {{ __('transportation.trans') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">
@endsection

@section('h1')
  {{ __('transportation.trans') }}
@endsection

@section('breadcrumb')
  {{ __('transportation.requests')  . ' / '  . __('transportation.trans') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#addRequest"
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
            @if (count($requests) == 0)
              <div class="alert alert-danger my-5" role="alert">
                {{ __('transportation.noreq') }}
              </div>
            @else
              <h5 class="card-title">{{ __('transportation.trans') }}</h5>
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
                    <th scope="col">{{ __('transportation.dest') }}</th>
                    <th scope="col">{{ __('transportations.date') }}</th>
                    <th scope="col">{{ __('transportation.from') }}</th>
                    <th scope="col">{{ __('transportation.to') }}</th>
                    <th scope="col">{{ __('transportation.pass') }}</th>
                    <th scope="col">{{ __('transportation.appliedAt') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php $c = 1; @endphp
                  @foreach ($requests as $request)
                    <tr>
                      <td>{{ $c }}</td>
                      <td>{{ $request->destination }}</td>
                      <td>{{ $request->date }}</td>
                      <td>{{ $request->from }}</td>
                      <td>{{ $request->to }}</td>
                      <td>{{ $request->passengers }}</td>
                      <td>{{ $request->created_at  }}</td>
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

  <div class="modal fade" id="addRequest" tabindex="-1" aria-labelledby="addRequestLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addRequestLabel">{{ __('transportation.addTrans') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('transportation.store') }}" method="POST" id="addForm">
            @csrf
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="destination" class="form-label required">{{ __('transportation.dest') }}</label>
                  <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination') }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 mb-3">
                <div class="mb-3">
                  <label for="date" class="form-label required">{{ __('transportation.date') }}</label>
                  <input type="date" class="form-control" name="date" id="date" min="{{ date('Y-m-d') }}" value="{{ old('date') }}">
                </div>
              </div>
              <div class="col-6 mb-3">
                <label for="passengers" class="form-label required">{{ __('transportation.pass') }}</label>
                <input type="number" min="0" class="form-control" id="passengers" name="passengers" value="{{ old('passengers') }}" autocomplete="off">
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label for="from" class="form-label required">{{ __('transportation.from') }}</label>
                  <input type="time" class="form-control" name="from" id="from" value="{{ old('from') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label for="to" class="form-label required">{{ __('transportation.to') }}</label>
                  <input type="time" class="form-control" name="to" id="to" value="{{ old('to') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="notes">{{ __('transportation.notes') }}</label>
                <textarea class="form-control" name="notes" cols="30" rows="3" id="notes">{{ old('notes') }}</textarea>
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