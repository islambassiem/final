@extends('layout.master')

@section('title')
  {{ __('Dashboard') }}
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
  {{ __('Dashboard') }}
@endsection

@section('breadcrumb')
  {{ __('Dashboard') }}
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
                  {{ __('Availd Vacations') }}
                </h5>
                <div class="text-center text-info icon">
                  <i class="bi bi-battery-half fs-1"></i>
                </div>
                <div class="number text-center">{{ $availedMonth  . ' Days' }}</div>
                <div class="card-title text-center">{{ __('This Month') }}</div>
              </div>
            </div>
          </a>
          </div>
        <div class="col-xxl-4 col-md-6">
          <a href="{{ route('vacations.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('Availd Vacations') }}
                </h5>
                <div class="text-center text-danger icon">
                  <i class="bi bi-battery-full fs-1"></i>
                </div>
                <div class="number text-center">{{ $availedYear  . ' Days' }}</div>
                <div class="card-title text-center">{{ __('This Year') }}</div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xxl-4 col-xl-12">
          <a href="{{ route('vacations.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('Vacation Balance') }}
                </h5>
                <div class="text-center text-success icon">
                  <i class="bi bi-graph-down fs-1"></i>
                </div>
                <div class="number text-center">{{ $balance  . ' Days' }}</div>
                <div class="card-title text-center">{{ __('APL') }}</div>
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
                  {{ __('Availd Permissions') }}
                </h5>
                <div class="text-center text-info icon">
                  <i class="bi bi-alarm-fill fs-1"></i>
                </div>
                <div class="number text-center">{{ $leaveMonth . ' Hours' }}</div>
                <div class="card-title text-center">{{ __('This Month') }}</div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xxl-4 col-md-6">
          <a href="{{ route('leaves.index') }}">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">
                  {{ __('Availd Permissions') }}
                </h5>
                <div class="text-center text-danger icon">
                  <i class="bi bi-clock-history fs-1"></i>
                </div>
                <div class="number text-center">{{ $leaveYear . ' Hours' }}</div>
                <div class="card-title text-center">{{ __('This Year') }}</div>
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
          <h5 class="card-title">{{ __('Documents Expiry') }}</h5>
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
                  <div class="activite-label mx-3">{{ $document->getExpiryAttribute() . ' Days'}}</div>
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