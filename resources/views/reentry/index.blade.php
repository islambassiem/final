@extends('layout.master')

@section('title')
  {{ __('Family Visits') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('h1')
  {{ __('Family Visits') }}
@endsection

@section('breadcrumb')
  {{ __('Requests /  Exit Re-entry Visas / All ') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#addVisa"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('Add') }}
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
            @if (count($visas) == 0)
              <div class="alert alert-danger my-5" role="alert">
                {{ __('There are no Exit Re-entry visas Registered') }}
              </div>
            @else
              <h5 class="card-title">{{ __('Re-entry visas') }}</h5>
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
                    <th scope="col">{{ __('Departure Date') }}</th>
                    <th scope="col">{{ __('Return Date') }}</th>
                    <th scope="col">{{ __('Number of Days') }}</th>
                    <th scope="col">{{ __('Applied At ') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php $c = 1; @endphp
                  @foreach ($visas as $visit)
                    <tr>
                      <td>{{ $c }}</td>
                      <td>{{ $visit->from }}</td>
                      <td>{{ $visit->to }}</td>
                      <td>{{ $visit->days() }}</td>
                      <td>{{ $visit->created_at }}</td>
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
<div class="modal fade" id="addVisa" tabindex="-1" aria-labelledby="addVisitLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addVisitLabel">{{ __('Add a familt visit') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('reentry.store') }}" method="POST" id="addForm">
          @csrf
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="from" class="form-label">{{ __('Departure Date') }}</label>
                <input type="date" class="form-control" id="from" name="from" value="{{ old('from') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="to" class="form-label">{{ __('Return Date') }}</label>
                <input type="date" class="form-control" id="to" name="to" value="{{ old('to') }}" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="deduction" name="deduction" @if (old('deduction')) checked  @endif>
              <label class="form-check-label" for="deduction">{{ __('I agree to be deducted 100 SAR for every extra month') }}</label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
        <button type="submit" class="btn btn-primary" form="addForm">{{ __('Add') }}</button>
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
    });
  </script>
@endsection