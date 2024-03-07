@extends('admin.layout.master')


@section('title')
  {{ __('admin/salaries.salaries') }}
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
{{ __('admin/salaries.salaries') }}
@endsection

@section('breadcrumb')
{{ __('admin/salaries.salaries') .  ' / ' . __('global.all')}}
@endsection


@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <button
          type="button"
          data-bs-toggle="modal"
          data-bs-target="#addMonth"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('global.add') }}
        </button>
      </div>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('admin/salaries.salaries') }}
        </h5>
      @if (session('success'))
        <div class="alert alert-success">
          {{ __('admin/salaries.addedMonth') }}
        </div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
        @if (count($months) == 0)
          <div class="alert alert-danger text-center">
            {{ __('admin/salaries.noMonth') }}
          </div>
        @else
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ __('admin/salaries.from') }}</th>
                <th>{{ __('admin/salaries.to') }}</th>
                <th>{{ __('admin/salaries.month') }}</th>
                <th>{{ __('admin/salaries.year') }}</th>
                <th>{{ __('admin/salaries.addedAt') }}</th>
                <th>{{ __('admin/salaries.status') }}</th>
                <th class="text-center">{{ __('admin/salaries.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @php $c = 1; @endphp
              @foreach ($months as $month)
                <tr>
                  <td>{{ $c }}</td>
                  <td>{{ $month->start_date }}</td>
                  <td>{{ $month->end_date }}</td>
                  <td>{{ $month->month }}</td>
                  <td>{{ $month->year }}</td>
                  <td>{{ $month->created_at }}</td>
                  <td>
                    @if ($month->status == 1)
                      <i class="bi bi-lock-fill text-danger fs-5"></i>
                      <span class="text-danger fs-6">{{ __('admin/salaries.closed') }}</span>
                    @else
                      <i class="bi bi-unlock-fill text-success fs-5"></i>
                      <span class="text-success fs-6">{{ __('admin/salaries.open') }}</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <a href="#" class="btn btn-secondary btn-sm">
                      <span>
                        <i class="bi bi-eye-fill fs-6"></i>
                        <span class="fs-6">{{ __('admin/salaries.show') }}</span>
                      </span>
                    </a>
                    <a href="#" class="btn btn-success btn-sm" data-status="{{ $month->status }}" data-id="{{ $month->id }}">
                      <span>
                        <i class="bi bi-cash-stack fs-6"></i>
                        <span class="fs-6">{{ __('admin/salaries.payables') }}</span>
                      </span>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" data-status="{{ $month->status }}" data-id="{{ $month->id }}">
                      <span>
                        <i class="bi bi-wallet fs-6"></i>
                        <span class="fs-6">{{ __('admin/salaries.deductables') }}</span>
                      </span>
                    </a>
                    <button
                      type="button"
                      class="btn btn-sm {{ $month->status == 0 ? 'btn-primary' : 'btn-danger' }}"
                      data-id="{{ $month->id }}"
                      data-status="{{ $month->status }}"
                      data-bs-toggle="modal"
                      data-bs-target="#confirmation">
                      <span>
                        <i class="bi bi-gear-fill fs-6"></i>
                        <span class="fs-6">{{ __('admin/salaries.process') }}</span>
                      </span>
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

  {{-- Add Holiday Model --}}
  <div class="modal fade" id="addMonth" tabindex="-1" aria-labelledby="addHolidayModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addHolidayLabel">{{ __('admin/salaries.addMonth') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.salaries.create') }}" method="POST" id="addForm">
            @csrf
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="from" class="form-label required">{{ __('admin/salaries.from') }}</label>
                  <input type="date" class="form-control" id="from" name="from" value="{{ $start_date }}" autocomplete="off" readonly disabled>
                  <input type="hidden" class="form-control" id="from" name="from" value="{{ $start_date }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="to" class="form-label required">{{ __('admin/salaries.to') }}</label>
                  <input type="date" class="form-control" id="to" name="to" value="{{ old('to') }}" autocomplete="off" min={{ $start_date }}>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 mb-3">
                <label for="month" class="form-label">{{ __('admin/salaries.month') }}</label>
                <select class="form-select" id="month" name="month" style="width:100%">
                  <option selected disabled>{{ __('global.select') }}</option>
                  @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" @selected( $i == old('month'))>{{  str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-6 mb-3">
                <label for="year" class="form-label">{{ __('admin/salaries.year') }}</label>
                <select class="form-select" id="year" name="year" style="width:100%">
                  <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                </select>
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

  <!-- Salary Process Confirmation Modal -->
<div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('admin/salaries.prConf') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="processForm">
        @csrf
        @method('post')
        <div class="modal-body">
          {{ __('admin/salaries.msgBody') }}
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('global.close') }}</button>
        <button type="submit" class="btn btn-success" form="processForm">{{ __('global.submit') }}</button>
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
    $(document).ready(function (){
      $("#month").select2({
        dropdownParent: $('#addMonth')
      });
      $("#year").select2({
        dropdownParent: $('#addMonth')
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
      $('#confirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('processForm');
        form.action = "salaries/process/" + id;
      });
      var elements = document.querySelectorAll('[data-id]');
      console.log(elements);
      elements.forEach(element => {
        if(element.getAttribute('data-status') == 1){
          element.style.opacity = '0.5';
          element.style.pointerEvents = 'none';
        }
      });
    });
  </script>
@endsection