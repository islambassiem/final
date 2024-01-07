@extends('layout.master')

@section('title')
  {{ __('head/leaves.leaves') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('head/leaves.leaves') }}
@endsection

@section('breadcrumb')
  {{ __('head/leaves.leaves') . ' / ' . __('global.show')}}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col-md-6">
        <div class="card py-2">
          <div class="card-body pb-0">
            <div class="card-title mb-0 py-2">
              {{ session('_lang') == '_ar' ? $permission->user->getFullArabicNameAttribute : $permission->user->getFullEnglishNameAttribute }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="d-flex justify-content-end">
          <a href="{{ route('sLeave.index') }}" class="btn btn-danger">{{ __('global.back') }}</a>
          @if (auth()->user()->id != $permission->user->id)
            <button  type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#actionModal">
              {{ __('head/leaves.takeAction') }}
            </button>
          @endif
        </div>
      </div>
    </div>
    <div class="row text-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h2 class="card-title h2 pb-0">{{ __('head/leaves.from') }}</h2>
          </div>
          @if (session('_lang') == '_ar')
            <i class="bi bi-arrow-left-square-fill text-primary fs-1"></i>
          @else
            <i class="bi bi-arrow-right-square-fill text-primary fs-1"></i>
          @endif
          <div class="h5">
            {{ $permission->from }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('head/leaves.to') }}</h5>
          </div>
          @if (session('_lang') == '_ar')
          <i class="bi bi-arrow-right-square-fill text-danger fs-1"></i>
          @else
          <i class="bi bi-arrow-left-square-fill text-danger fs-1"></i>
          @endif
          <div class="h5">
            {{ $permission->to }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('head/leaves.Type') }}</h5>
            <i class="bi bi-vinyl-fill text-info fs-1"></i>
          </div>
          <div class="h5">
            {{ $permission->type->{'leave_type'. session('_lang')} }}
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h5 class="card-title pb-0">{{ __('head/leaves.status') }}</h5>
          </div>
          @switch($permission->status_id)
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
            {{ $permission->status->{'workflow_status'. session('_lang')} }}
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
                {{ __('head/leaves.details') }}
              </h5>
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/leaves.hours') }}</div>
            <div>{{ $permission->hours }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/leaves.date') }}</div>
            <div>
              @if (!blank($permission->detail?->employee_time))
                {{ date('m/d/Y', strtotime($permission->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/leaves.time') }}</div>
            <div>
              @if (!blank($permission->detail?->employee_time))
                {{ date('H:i:s', strtotime($permission->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('head/leaves.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $permission->detail?->employee_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('head/leaves.deptHead') }}
              </h5>
              <div class="py-3">
                @switch($permission->detail?->head_status)
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
            <div>{{ __('head/leaves.status') }}</div>
            <div>{{ $permission->detail?->headStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/leaves.date') }}</div>
            <div>
              @if (!blank($permission->detail?->head_time))
                {{ date('m/d/Y', strtotime($permission->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/leaves.time') }}</div>
            <div>
              @if (!blank($permission->detail?->head_time))
                {{ date('H:i:s', strtotime($permission->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('head/leaves.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $permission->detail?->head_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('head/leaves.hr') }}
              </h5>
              <div class="py-3">
                @switch($permission->detail?->hr_status)
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
            <div>{{ __('head/leaves.Status') }}</div>
            <div>{{ $permission->detail?->hrStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/leaves.date') }}</div>
            <div>
              @if (!blank($permission->detail?->hr_time))
                {{ date('m/d/Y', strtotime($permission->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('head/leaves.time') }}</div>
            <div>
              @if (!blank($permission->detail?->hr_time))
                {{ date('H:i:s', strtotime($permission->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('head/leaves.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $permission->detail?->hr_notes }}</div>
        </div>
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
        <form action="{{ route('sLeave.update', $permission->id) }}" method="post" id="actionForm">
          @csrf
          <div class="mb-3">
            <label for="action">{{ __('global.action') }}</label>
            <select name="action" id="" class="form-select">
              <option value="">{{ __('global.select') }}</option>
              <option value="1">{{ __('head/leaves.approve') }}</option>
              <option value="2">{{ __('head/leaves.decline') }}</option>
            </select>
          </div>
          <div class="row">
            <div class="col">
              <label for="notes">{{ __('head/leaves.notes') }}</label>
              <textarea class="form-control" name="head_notes" cols="30" rows="3" id="notes">{{ old('notes') }}</textarea>
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
@endsection