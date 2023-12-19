@extends('layout.master')

@section('title')
  {{ __('leaves') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('leaves') }}
@endsection

@section('breadcrumb')
  {{ __('leaves / Show') }}
@endsection

@section('content')
  <section class="section">
    <div class="row text-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h2 class="card-title h2 pb-0">{{ __('From') }}</h2>
          </div>
          @if (session('_lang') == '_ar')
            <i class="bi bi-arrow-left-square-fill text-primary fs-1"></i>
          @else
            <i class="bi bi-arrow-right-square-fill text-primary fs-1"></i>
          @endif
          <div class="h5">
            {{ $leave->from }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('To') }}</h5>
          </div>
          @if (session('_lang') == '_ar')
          <i class="bi bi-arrow-right-square-fill text-danger fs-1"></i>
          @else
          <i class="bi bi-arrow-left-square-fill text-danger fs-1"></i>
          @endif
          <div class="h5">
            {{ $leave->to }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('leave Type') }}</h5>
            <i class="bi bi-vinyl-fill text-info fs-1"></i>
          </div>
          <div class="h5">
            {{ $leave->type->{'leave_type'. session('_lang')} }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('Status') }}</h5>
          </div>
          @switch($leave->status_id)
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
            {{ $leave->status->{'workflow_status'. session('_lang')} }}
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
                {{ __('Details') }}
              </h5>
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Hours') }}</div>
            <div>{{ $leave->hours }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Date') }}</div>
            <div>
              @if (!blank($leave->detail?->employee_time))
                {{ date('m/d/Y', strtotime($leave->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Time') }}</div>
            <div>
              @if (!blank($leave->detail?->employee_time))
                {{ date('H:i:s', strtotime($leave->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('Notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $leave->detail?->employee_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('Department Head') }}
              </h5>
              <div class="py-3">
                @switch($leave->detail?->head_status)
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
            <div>{{ __('Sataus') }}</div>
            <div>{{ $leave->detail?->headStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Date') }}</div>
            <div>
              @if (!blank($leave->detail?->head_time))
                {{ date('m/d/Y', strtotime($leave->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Time') }}</div>
            <div>
              @if (!blank($leave->detail?->head_time))
                {{ date('H:i:s', strtotime($leave->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('Notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $leave->detail?->head_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('Human Resources') }}
              </h5>
              <div class="py-3">
                @switch($leave->detail?->hr_status)
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
            <div>{{ __('Sataus') }}</div>
            <div>{{ $leave->detail?->hrStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Date') }}</div>
            <div>
              @if (!blank($leave->detail?->hr_time))
                {{ date('m/d/Y', strtotime($leave->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Time') }}</div>
            <div>
              @if (!blank($leave->detail?->hr_time))
                {{ date('H:i:s', strtotime($leave->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('Notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $leave->detail?->hr_notes }}</div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
@endsection