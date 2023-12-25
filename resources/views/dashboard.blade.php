@extends('layout.master')

@section('title')
  {{ __('dashboard.dashboard') }}
@endsection

@section('style')
  <style>
    .number{
      font-size: 30px
    }

    .w-40{
      width: 40%
    }

    a{
      /* display: block; */
    }
  </style>
@endsection

@section('h1')
{{ __('dashboard.dashboard') }}
@endsection

@section('breadcrumb')
{{ __('dashboard.dashboard') }}
@endsection

@section('content')

  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="col-xxl-4 col-md-6">
          <a href="{{ route('vacations.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('dashboard.avVacations') }}
                </h5>
                <div class="text-center text-info icon">
                  <i class="bi bi-battery-half fs-1"></i>
                </div>
                <div class="number text-center">{{ $availedMonth  . __('dashboard.days') }}</div>
                <div class="card-title text-center">{{ __('dashboard.month') }}</div>
              </div>
            </div>
          </a>
          </div>
        <div class="col-xxl-4 col-md-6">
          <a href="{{ route('vacations.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('dashboard.avVacations') }}
                </h5>
                <div class="text-center text-danger icon">
                  <i class="bi bi-battery-full fs-1"></i>
                </div>
                <div class="number text-center">{{ $availedYear  . __('dashboard.days') }}</div>
                <div class="card-title text-center">{{ __('dashboard.year') }}</div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xxl-4 col-xl-12">
          <a href="{{ route('vacations.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('dashboard.balance') }}
                </h5>
                <div class="text-center text-success icon">
                  <i class="bi bi-graph-down fs-1"></i>
                </div>
                <div class="number text-center">{{ $balance  . __('dashboard.days') }}</div>
                <div class="card-title text-center">{{ __('dashboard.APL') }}</div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-xxl-4 col-md-6">
          <a href="{{ route('leaves.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('dashboard.availedPermissions') }}
                </h5>
                <div class="text-center text-info icon">
                  <i class="bi bi-alarm-fill fs-1"></i>
                </div>
                <div class="number text-center">{{ $leaveMonth . __('dashboard.hours') }}</div>
                <div class="card-title text-center">{{ __('dashboard.month') }}</div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xxl-4 col-md-6">
          <a href="{{ route('leaves.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('dashboard.availedPermissions') }}
                </h5>
                <div class="text-center text-danger icon">
                  <i class="bi bi-clock-history fs-1"></i>
                </div>
                <div class="number text-center">{{ $leaveYear . __('dashboard.hours') }}</div>
                <div class="card-title text-center">{{ __('dashboard.year') }}</div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <!-- Recent Activity -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('dashboard.expiry') }}</h5>
          @foreach ($documents as $document)
            <div class="activity my-3">
              <div class="activity-item d-flex justify-content-between">
                <div class="activity-content">
                  {{ $document->description }}
                </div>
                <div class="d-flex w-40">
                  @if ($document->getExpiryAttribute() >= 30)
                    <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                    @else
                    <i class="bi bi-circle-fill activity-badge text-danger align-self-start"></i>
                  @endif
                  <div class="activite-label mx-3">{{ $document->getExpiryAttribute() . __('dashboard.days')}}</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div><!-- End Recent Activity -->
    </div><!-- End Right side columns -->
  </div>

@endsection

@section('script')
@endsection