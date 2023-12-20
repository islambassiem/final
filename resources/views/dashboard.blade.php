@extends('layout.master')

@section('title')
  {{ __('Dashboard') }}
@endsection

@section('style')
  <style>
    .icon{
      font-size:30px;
    }
    .number{
      font-size: 80px
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
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">
                {{ __('Vacations Availd') }}
              </h5>
              <div class="text-center text-info icon">
                <i class="bi bi-calendar3-week-fill"></i>
              </div>
              <div class="number text-center">{{ $availdMonth }}</div>
              <div class="card-title text-center">{{ __('This Month') }}</div>
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">
                {{ __('Vacations Availd') }}
              </h5>
              <div class="text-center text-danger icon">
                <i class="bi bi-bank"></i>
              </div>
              <div class="number text-center">{{ $availdYear }}</div>
              <div class="card-title text-center">{{ __('This Year') }}</div>
            </div>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title text-center">
                {{ __('Vacation Balance') }}
              </h5>
              <div class="text-center text-success icon">
                <i class="bi bi-graph-down"></i>
              </div>
              <div class="number text-center">{{ $balance }}</div>
              <div class="card-title text-center">{{ __('APL') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="col-lg-4">
      <!-- Recent Activity -->
      <div class="card">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div>

        <div class="card-body">
          <h5 class="card-title">Recent Activity <span>| Today</span></h5>

          <div class="activity">

            <div class="activity-item d-flex">
              <div class="activite-label">32 min</div>
              <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
              <div class="activity-content">
                Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">56 min</div>
              <i class="bi bi-circle-fill activity-badge text-danger align-self-start"></i>
              <div class="activity-content">
                Voluptatem blanditiis blanditiis eveniet
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">2 hrs</div>
              <i class="bi bi-circle-fill activity-badge text-primary align-self-start"></i>
              <div class="activity-content">
                Voluptates corrupti molestias voluptatem
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">1 day</div>
              <i class="bi bi-circle-fill activity-badge text-info align-self-start"></i>
              <div class="activity-content">
                Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">2 days</div>
              <i class="bi bi-circle-fill activity-badge text-warning align-self-start"></i>
              <div class="activity-content">
                Est sit eum reiciendis exercitationem
              </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
              <div class="activite-label">4 weeks</div>
              <i class="bi bi-circle-fill activity-badge text-muted align-self-start"></i>
              <div class="activity-content">
                Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
              </div>
            </div><!-- End activity item-->

          </div>

        </div>
      </div><!-- End Recent Activity -->
    </div> --}}
  </div>

@endsection

@section('script')
@endsection