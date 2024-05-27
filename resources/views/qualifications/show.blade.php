@extends('layout.master')

@section('title')
  {{ __('qualifications.qualifications') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('qualifications.qualifications') }}
@endsection

@section('breadcrumb')
  {{ __('qualifications.qualifications') . ' / ' . __('global.show') }}
@endsection

@section('content')

<section class="section profile">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <a href="{{ route('qualifications.index') }}"
        class="btn btn-warning mx-2">
        <i class="bi bi-arrow-left-circle me-1"></i>
        {{ __('global.back') }}
      </a>
      <button
        type="button"
        class="btn btn-danger btn-sm py-0 me-2"
        id="btn"
        data-id = "{{ $qualification->id }}"
        data-bs-toggle="modal"
        data-bs-target="#delteConfirmation">
        <i class="bi bi-trash3"></i>
        {{ __('global.del') }}
      </button>
      <a href="{{ route('qualifications.edit',$qualification->id) }}"
        class="btn btn-primary">
        <i class="bi bi-pencil-square me-1"></i>
        {{ __('global.edit') }}
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
              <h5 class="card-title">{{ __('qualifications.details') }}</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">{{ __('qualifications.degree') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->qualificationName->{'qualification' . session('_lang') } }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.university') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->graduation_university }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.city') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->city }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.nature') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->studyType?->{'study_type' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.type') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->studyNature?->{'study_nature' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.major') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->major?->{'specialty' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.minor') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->minor?->{'specialty' . session('_lang')} }}</div>
              </div>


              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.date') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->graduation_date }}</div>
              </div>

              {{-- <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('Dissertation') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->thesis }}</div>
              </div> --}}

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.attested') }}</div>
                <div class="col-lg-9 col-md-8 fs-5">
                  @if ($qualification->attested)
                    <i class="bi bi-check-square-fill text-success"></i>
                  @else
                    <i class="bi bi-file-x-fill text-danger"></i>
                  @endif
                </div>
              </div>

              @if (!blank($qualification->thesis))
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">{{ __('qualifications.thesis') }}</div>
                  <div class="col-lg-9 col-md-8">{{ $qualification->thesis }}</div>
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
              <h5 class="card-title">{{ __('qualifications.performance') }}</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">{{ __('qualifications.gpa') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->gpa }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.gpaType') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->GPAType?->{'gpa_type' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">{{ __('qualifications.rating') }}</div>
                <div class="col-lg-9 col-md-8">{{ $qualification->ratings?->{'rating' . session('_lang')} }}</div>
              </div>

            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{ __('global.attachment') }}</h5>
          @if ($link)
            <div class="fs-1 text-center" style="cursor: pointer;">
              <a href="{{ url($link) }}" target="_blank" class="d-flex justify-content-center">
                <i class="bi bi-paperclip"></i>
              </a>
            </div>
          @else
            <div class="alert alert-danger text-center">
              {{ __('qualifications.noAtt') }}
            </div>
          @endif
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
          <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('global.delConf') }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" id="deleteForm">
            @csrf
            @method('delete')
            {{ __('global.deleteConfirmation') }}
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
          <button type="submit" class="btn btn-danger" form="deleteForm">{{ __('global.delete') }}</button>
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
        form.action = "../qualifications/" + id;
        console.log(form.action);
      });
    });
  </script>
@endsection