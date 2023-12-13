@extends('layout.master')

@section('title')
  {{ __('Vacation') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('Vacation') }}
@endsection

@section('breadcrumb')
  {{ __('Vacation / Show') }}
@endsection

@section('content')
  <section class="section">
    <div class="row text-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h2 class="card-title h2 pb-0">{{ __('Start Date') }}</h2>
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
            <h5 class="card-title pb-0">{{ __('End Date') }}</h5>
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
            <h5 class="card-title pb-0">{{ __('Vacation Type') }}</h5>
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
            <h5 class="card-title pb-0">{{ __('Status') }}</h5>
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
                {{ __('Details') }}
              </h5>
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Days') }}</div>
            <div>{{ $vacation->days }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Date') }}</div>
            <div>
              @if (!blank($vacation->detail?->employee_time))
                {{ date('d/m/Y', strtotime($vacation->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Time') }}</div>
            <div>
              @if (!blank($vacation->detail?->employee_time))
                {{ date('H:i:s', strtotime($vacation->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('Notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->employee_notes }}</div>
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
            <div>{{ __('Sataus') }}</div>
            <div>{{ $vacation->detail?->headStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Date') }}</div>
            <div>
              @if (!blank($vacation->detail?->head_time))
                {{ date('m/d/Y', strtotime($vacation->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Time') }}</div>
            <div>
              @if (!blank($vacation->detail?->head_time))
                {{ date('H:i:s', strtotime($vacation->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('Notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->head_notes }}</div>
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
            <div>{{ __('Sataus') }}</div>
            <div>{{ $vacation->detail?->hrStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Date') }}</div>
            <div>
              @if (!blank($vacation->detail?->hr_time))
                {{ date('m/d/Y', strtotime($vacation->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('Time') }}</div>
            <div>
              @if (!blank($vacation->detail?->hr_time))
                {{ date('H:i:s', strtotime($vacation->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('Notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->hr_notes }}</div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
@endsection