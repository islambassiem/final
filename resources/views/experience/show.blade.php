@extends('layout.master')

@section('title')
  {{ __('Experiences') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('Experience') }}
@endsection

@section('breadcrumb')
  {{ __('Experience / Show') }}
@endsection

@section('content')

<section class="section profile">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <a href="{{ route('experience.index') }}"
        class="btn btn-warning mx-2">
        <i class="bi bi-arrow-left-circle me-1"></i>
        {{ __('Back') }}
      </a>
      <button
        type="button"
        class="btn btn-danger btn-sm py-0 me-2"
        id="btn"
        data-id = "{{ $experience->id }}"
        data-bs-toggle="modal"
        data-bs-target="#delteConfirmation">
        <i class="bi bi-trash3"></i>
        {{ __('Delete') }}
      </button>
      <a href="{{ route('experience.edit',$experience->id) }}"
        class="btn btn-primary">
        <i class="bi bi-pencil-square me-1"></i>
        {{ __('Edit') }}
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-7">
      <div class="card">
        <div class="card-body">
          <!-- Bordered Tabs -->
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Experience Details') }}</h5>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Position') }}</div>
                <div class="col-md-8">{{ $experience->position ?? __('N/A') }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label">{{ __('Institution') }}</div>
                <div class="col-md-8">{{ $experience->institution->{'institute'. session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label">{{ __('College') }}</div>
                <div class="col-md-8">{{ $experience->college->{'college' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label">{{ __('Department') }}</div>
                <div class="col-md-8">{{ $experience->section->{'section' . session('_lang')} }}</div>
              </div>

              @if (auth()->user()->category_id == 1)
                <div class="row">
                  <div class="col-md-4 label">{{ __('Academic Rank') }}</div>
                  <div class="col-md-8">{{ $experience->academicRank->{'rank' . session('_lang')} }}</div>
                </div>
                <div class="row">
                  <div class="col-md-4 label">{{ __('Appotintment Type') }}</div>
                  <div class="col-md-8">{{ $experience->appointment->{'appointment_type' . session('_lang')} }}</div>
                </div>
                <div class="row">
                  <div class="col-md-4 label">{{ __('Employement Status') }}</div>
                  <div class="col-md-8">{{ $experience->employment->{'employment_status' . session('_lang')} }}</div>
                </div>
                <div class="row">
                  <div class="col-md-4 label">{{ __('Job Type') }}</div>
                  <div class="col-md-8">{{ $experience->jobType->{'job_type' . session('_lang')} }}</div>
                </div>
                <div class="row">
                  <div class="col-md-4 label">{{ __('Major') }}</div>
                  <div class="col-md-8">{{ $experience->major->{'specialty' . session('_lang')} }}</div>
                </div>
                <div class="row">
                  <div class="col-md-4 label">{{ __('Minor') }}</div>
                  <div class="col-md-8">{{ $experience->minor->{'specialty' . session('_lang')} }}</div>
                </div>
              @else
                <div class="row">
                  <div class="col-md-4 label">{{ __('Professional Rank') }}</div>
                  <div class="col-md-8">{{ $experience->professionalRank->{'rank' . session('_lang')} }}</div>
                </div>
                <div class="row">
                  <div class="col-md-4 label">{{ __('Accommodation Type') }}</div>
                  <div class="col-md-8">{{ $experience->accommodation->{'accommodation_status' . session('_lang')} }}</div>
                </div>
              @endif

            </div>
          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>

    <div class="col-xl-5">
      <div class="card">
        <div class="card-body">
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Key Dates') }}</h5>


              <div class="row">
                <div class="col-md-4 label">{{ __('Hiring Date') }}</div>
                <div class="col-md-8">{{ $experience->hiring_date}}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label">{{ __('Joining Date') }}</div>
                <div class="col-md-8">{{ $experience->joining_date}}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label">{{ __('End Date') }}</div>
                <div class="col-md-8">{{ $experience->resignation_date}}</div>
              </div>

            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('Attachment') }}</h5>
          @if ($link)
            <div class="fs-1 text-center" style="cursor: pointer;">
              <a href="{{ url($link) }}" target="_blank" class="d-flex justify-content-center">
                <i class="bi bi-paperclip"></i>
              </a>
            </div>
          @else
            <div class="alert alert-danger text-center">
              {{ __("No Attachments") }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Tasks') }}</h5>
              <div>{{ $experience->tasks ?? __('N/A') }}</div>
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>
    </div>
  </div>
</section>


  <!-- Modal -->
  <div class="modal fade" id="delteConfirmation" tabindex="-1" aria-labelledby="delteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('Delete Confirmation!') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" id="deleteForm">
            @csrf
            @method('delete')
            {{ __('Are you sure you want to delete the experience?') }}
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
          <button type="submit" class="btn btn-danger" form="deleteForm">{{ __('Yes, Delete') }}</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
<script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script>
    $(document).ready(function (){
      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "../experience/" + id;
      });
    });
  </script>
@endsection