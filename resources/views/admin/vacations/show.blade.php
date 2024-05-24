@extends('admin.layout.master')

@section('title')
  {{ __('head/vacations.vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
@endsection

@section('h1')
  {{ __('head/vacations.vacations') }}
@endsection

@section('breadcrumb')
  {{ __('head/vacations.vacations') . ' / ' . __('global.show') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col-md-6">
        <div class="card py-2">
          <div class="card-body pb-0">
            <div class="card-title mb-0 py-2">
              {{ session('_lang') == '_ar' ? $vacation->user->getFullArabicNameAttribute : $vacation->user->getFullEnglishNameAttribute }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="d-flex justify-content-end">
          <a href="{{ route('admin.vacations') }}" class="btn btn-danger">{{ __('global.back') }}</a>
          <button  type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#actionModal">
            {{ __('head/vacations.takeAction') }}
          </button>
        </div>
      </div>
    </div>
    @if (session('message'))
      <div class="alert alert-warning" role="alert">
        {{ session('message') }}
      </div>
    @endif
    @if (session('processed'))
      <div class="alert alert-danger">
        {{ session('processed') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
    <div class="row text-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h2 class="card-title h2 pb-0">{{ __('head/vacations.from') }}</h2>
          </div>
          @if (session('_lang') == '_ar')
            <i class="bi bi-arrow-left-square-fill text-primary fs-1"></i>
          @else
            <i class="bi bi-arrow-right-square-fill text-primary fs-1"></i>
          @endif
          <div class="h5">
            {{ $vacation->start_date }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('head/vacations.to') }}</h5>
          </div>
          @if (session('_lang') == '_ar')
          <i class="bi bi-arrow-right-square-fill text-danger fs-1"></i>
          @else
          <i class="bi bi-arrow-left-square-fill text-danger fs-1"></i>
          @endif
          <div class="h5">
            {{ $vacation->end_date }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('head/vacations.type') }}</h5>
            <i class="bi bi-vinyl-fill text-info fs-1"></i>
          </div>
          <div class="h5">
            {{ $vacation->type->{'vacation_type'. session('_lang')} }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('head/vacations.status') }}</h5>
          </div>
          @switch($vacation->status_id)
            @case(1)
              <i class="bi bi-check-square-fill text-success fs-1"></i>
              @break
            @case(2)
              <i class="bi bi-x-square-fill text-danger fs-1"></i>
              @break
            @default
            <i class="bi bi-hourglass-top text-warning fs-1"></i>
          @endswitch
          <div class="h5">
            {{ $vacation->status->{'workflow_status'. session('_lang')} }}
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('head/vacations.details') }}
              </h5>
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.days') }}</div>
            <div>{{ $vacation->days }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.date') }}</div>
            <div>
              @if (!blank($vacation->detail?->employee_time))
                {{ date('d/m/Y', strtotime($vacation->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.time') }}</div>
            <div>
              @if (!blank($vacation->detail?->employee_time))
                {{ date('H:i:s', strtotime($vacation->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('head/vacations.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->employee_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('head/vacations.deptHead') }}
              </h5>
              <div class="py-3">
                @switch($vacation->detail?->head_status)
                  @case(1)
                    <i class="bi bi-check-square-fill text-success fs-5"></i>
                    @break
                  @case(2)
                    <i class="bi bi-x-square-fill text-danger fs-5"></i>
                    @break
                  @default
                  <i class="bi bi-hourglass-top text-warning fs-5"></i>
                @endswitch
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.status') }}</div>
            <div>{{ $vacation->detail?->headStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.date') }}</div>
            <div>
              @if (!blank($vacation->detail?->head_time))
                {{ date('m/d/Y', strtotime($vacation->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.time') }}</div>
            <div>
              @if (!blank($vacation->detail?->head_time))
                {{ date('H:i:s', strtotime($vacation->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('head/vacations.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->head_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('head/vacations.hr') }}
              </h5>
              <div class="py-3">
                @switch($vacation->detail?->hr_status)
                  @case(1)
                    <i class="bi bi-check-square-fill text-success fs-5"></i>
                    @break
                  @case(2)
                    <i class="bi bi-x-square-fill text-danger fs-5"></i>
                    @break
                  @default
                  <i class="bi bi-hourglass-top text-warning fs-5"></i>
                @endswitch
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.status') }}</div>
            <div>{{ $vacation->detail?->hrStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.date') }}</div>
            <div>
              @if (!blank($vacation->detail?->hr_time))
                {{ date('m/d/Y', strtotime($vacation->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/vacations.time') }}</div>
            <div>
              @if (!blank($vacation->detail?->hr_time))
                {{ date('H:i:s', strtotime($vacation->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('head/vacations.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->hr_notes }}</div>
        </div>
      </div>
    </div>
  </section>


  <!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="actionModalLabel">{{ __('head/vacations.takeAction') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.vacations.action', $vacation->id) }}" method="post" id="actionForm">
          @csrf
          <div class="mb-3">
            <label for="action">{{ __('global.action') }}</label>
            <select name="action" id="" class="form-select">
              <option value="0" selected disabled>{{ __('global.select') }}</option>
              <option value="1">{{ __('head/vacations.approve') }}</option>
              <option value="2">{{ __('head/vacations.decline') }}</option>
            </select>
          </div>
          <div class="row">
            <div class="col">
              <label for="notes">{{ __('head/vacations.notes') }}</label>
              <textarea class="form-control" name="hr_notes" cols="30" rows="3" id="notes">{{ old('notes') }}</textarea>
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
<script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
  <script>
    $(document).ready(function (){

      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      });
    });
  </script>
@endsection