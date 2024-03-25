@extends('admin.layout.master')

@section('title')
  {{ __('admin/salaries.trasDeduct') }}
@endsection


@section('style')
    @if (session('dir') == 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
@endsection

@section('h1')
  {{ __('admin/salaries.trasDeduct') }}
@endsection


@section('breadcrumb')
{{ __('admin/salaries.trasDeduct')}}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <button type="button" data-bs-toggle="modal" data-bs-target="#addDeduction" class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('global.add') }}
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col">
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('admin/salaries.trasDeduct') }}
        </h5>
        @if (count($deductions) == 0)
          <div class="alert alert-danger text-center">
            {{ __('admin/salaries.noTransportationDeductions') }}
          </div>
        @else
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('admin/salaries.empid') }}</th>
              <th>{{ __('admin/salaries.name') }}</th>
              <th>{{ __('admin/salaries.from') }}</th>
              {{-- <th>{{ __('admin/salaries.to') }}</th> --}}
              <th>{{ __('admin/salaries.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @php $c = 1; @endphp
            @foreach ($deductions as $deduction)
              <tr>
                <td>{{ $c; }}</td>
                <td>{{ $deduction->user->empid }}</td>
                <td>{{ session('_lang') == '_en' ? $deduction->user->getFullEnglishNameAttribute : $deduction->user->getFullArabicNameAttribute }}</td>
                <td>{{ $deduction->from }}</td>
                {{-- <td>{{ $deduction->to }}</td> --}}
                <td>
                  <button
                  type="button"
                  class="btn btn-primary btn-sm py-0"
                  data-bs-toggle="modal"
                  data-bs-target="#actionModal"
                  data-id="{{ $deduction->id }}">
                  <i class="bi bi-activity"></i>
                  {{ __('admin/salaries.edit') }}
                </button>
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

  <div class="modal fade" id="addDeduction" tabindex="-1" aria-labelledby="addDeductionLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addVisitLabel">{{ __('admin/salaries.addDeduction') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('trasportation.deduction.create') }}" method="POST" id="addForm">
              @csrf
              <div class="row">
                <div class="col-12 mb-3">
                  <label for="user_id" class="form-label">{{ __('admin/salaries.employee') }}</label>
                  <select class="form-select" id="user_id" name="user_id" style="width:100%">
                    <option selected disabled>{{ __('global.select') }}</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                        {{ $user->empid }} |
                        {{ session('_lang') == '_en' ? $user->getFullEnglishNameAttribute : $user->getFullArabicNameAttribute }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="from" class="form-label required">{{ __('admin/salaries.from') }}</label>
                    <input type="date" class="form-control" id="from" name="from" value="{{ old('from') }}" autocomplete="off">
                  </div>
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
            data-bs-dismiss="modal">{{ __('global.close') }}</button>
          <button type="submit" class="btn btn-primary" form="addForm">{{ __('global.add') }}</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="actionModalLabel">{{ __('head/vacations.takeAction') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="actionForm">
          @csrf
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="to" class="form-label required">{{ __('admin/salaries.to') }}</label>
                <input type="date" class="form-control" id="to" name="to" value="{{ old('to') }}" autocomplete="off">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
        <button type="submit" form="actionForm" class="btn btn-primary">{{ __('global.submit') }}</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $("#user_id").select2({
          dropdownParent: $('#addDeduction')
      });
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
        form.action = "deductions/" + id;
      });
    });
  </script>
@endsection
