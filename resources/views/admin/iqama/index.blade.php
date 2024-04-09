@extends('admin.layout.master')

@section('title')
  {{ __('admin/iqama.iqama') }}
@endsection

@section('style')
  @if (session('dir') == 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/hijri-date-picker/css/bootstrap-rtl.min.css') }}" />
    <link href="{{ asset('assets/vendor/hijri-date-picker/css/bootstrap-datetimepicker-rtl.min.css') }}" rel="stylesheet" />
  @else
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/hijri-date-picker/css/bootstrap.min.css') }}" />
    <link href="{{ asset('assets/vendor/hijri-date-picker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
  @endif
@endsection

@section('h1')
{{ __('admin/iqama.iqama') }}
@endsection

@section('breadcrumb')
{{ __('admin/iqama.iqama')}}
@endsection

@section('content')
  <section class="section">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('admin/iqama.iqama') }}
        </h5>
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('admin/iqama.empid') }}</th>
              <th>{{ __('admin/iqama.name') }}</th>
              <th>{{ __('admin/iqama.num') }}</th>
              <th>{{ __('admin/iqama.gregorian') }}</th>
              <th>{{ __('admin/iqama.hijri') }}</th>
              <th>{{ __('admin/iqama.duration') }}</th>
              <th>{{ __('admin/iqama.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @php $c = 1; @endphp
            @foreach ($iqamas as $iqama)
              <tr>
                <th>{{ $c; }}</th>
                <th>{{ $iqama->user->empid }}</th>
                <th>{{ session('_lang') == '_ar' ? $iqama->user->getFullArabicNameAttribute : $iqama->user->getFullEnglishNameAttribute }}</th>
                <th>{{ $iqama->document_id }}</th>
                <th>{{ $iqama->date_of_expiry; }}</th>
                <th>{{ $iqama->hijri; }}</th>
                <th>{{ $iqama->expiry; }}</th>
                <th>
                  <button
                  type="button"
                  class="btn btn-primary btn-sm py-0"
                  data-bs-toggle="modal"
                  data-bs-target="#actionModal"
                  data-id="{{ $iqama->id }}">
                  {{ __('admin/iqama.renew') }}
                  <i class="bi bi-stack"></i>
                </button>
                </th>
              </tr>
              @php $c ++; @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="actionModalLabel">{{ __('head/leaves.takeAction') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="actionForm">
          @csrf
          <div class="mb-3">
            <label for="expiry">{{ __('admin/iqama.expiry') }}</label>
            <input type="text" name="expiry" id="hijri-date-input" class="form-control">
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
<script src="{{ asset('assets/vendor/hijri-date-picker/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendor/hijri-date-picker/js/bootstrap-hijri-datetimepicker.min.js') }}"></script>
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
      form.action = "iqama/renewal/" + id;
    });

  });
</script>
<script type="text/javascript">
  $(function () {
    $("#hijri-date-input").hijriDatePicker({
      hijri:true,
      viewMode:'days',
      format:'YYYY-MM-DD',
      locale: "{{ session('_lang') == '_en' ? 'en-us' : 'ar-SA' }}",
      showClear: true,
      showClose: true,
      showTodayButton: true,
      hijriText: "{{ __('hijri.hijri') }}",
      gregorianText: "{{ __('hijri.gregorian') }}",
      minDate: "{{ date('Y-m-d') }}",
      maxDate: '2038-02-04',
      icons: {
        previous: "<",
        next: ">",
        today: "{{ __('hijri.today') }}",
        clear: "{{ __('hijri.clear') }}",
        close: "{{ __('hijri.close') }}"
      },
    });
  });
</script>
@endsection