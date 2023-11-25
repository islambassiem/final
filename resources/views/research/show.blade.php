@extends('layout.master')

@section('title')
  {{ __('Research') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('Research') }}
@endsection

@section('breadcrumb')
  {{ __('Research / Show') }}
@endsection

@section('content')

<section class="section profile">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <a href="{{ route('research.index') }}"
        class="btn btn-warning mx-2">
        <i class="bi bi-arrow-left-circle me-1"></i>
        {{ __('Back') }}
      </a>
      <button
        type="button"
        class="btn btn-danger btn-sm py-0 me-2"
        id="btn"
        data-id = "{{ $research->id }}"
        data-bs-toggle="modal"
        data-bs-target="#delteConfirmation">
        <i class="bi bi-trash3"></i>
        {{ __('Delete') }}
      </button>
      <a href="{{ route('research.edit',$research->id) }}"
        class="btn btn-primary">
        <i class="bi bi-pencil-square me-1"></i>
        {{ __('Edit') }}
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body pb-0">
            <h5 class="card-title pb-1">{{ __('Research Title') }}</h5>
            <div class="pb-3">{{ $research->title }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <!-- Bordered Tabs -->
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Publishing Details') }}</h5>
              <div class="row">
                <div class="col-md-4 label ">{{ __('Publisher') }}</div>
                <div class="col-md-8">{{ $research->publisher }}</div>
              </div>
              <div class="row">
                <div class="col-md-4 label">{{ __('Publication Date') }}</div>
                <div class="col-md-8">{{ $research->publishing_date }}</div>
              </div>
              <div class="row">
                <div class="col-md-4 label">{{ __('Key Words') }}</div>
                <div class="col-md-8">{{ $research->key_words }}</div>
              </div>
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <!-- Bordered Tabs -->
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Research Details') }}</h5>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Research Type') }}</div>
                <div class="col-md-8">{{ $research->type->{'research_type' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Research Status') }}</div>
                <div class="col-md-8">{{ $research->status->{'research_status' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Research Progress') }}</div>
                <div class="col-md-8">{{ $research->progress->{'research_progress' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Research Nature') }}</div>
                <div class="col-md-8">{{ $research->nature->{'research_nature' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Research Domain') }}</div>
                <div class="col-md-8">{{ $research->domain->{'research_domain' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Research Language') }}</div>
                <div class="col-md-8">{{ $research->language->{'research_language' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('Publication Location') }}</div>
                <div class="col-md-8">{{ $research->location->{'country' . session('_lang')} }}</div>
              </div>

            </div>
          </div><!-- End Bordered Tabs -->

        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card mb-2">
        <div class="card-body">
          <!-- Bordered Tabs -->
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Book') }}</h5>
              <div class="row">
                <div class="col-lg-3 col-md-4 label ">{{ __('ISBN') }}</div>
                <div class="col-lg-9 col-md-8">{{ $research->isbn }}</div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-md-4 label ">{{ __('Edition') }}</div>
                <div class="col-lg-9 col-md-8">{{ $research->edition }}</div>
              </div>
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <!-- Bordered Tabs -->
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Research') }}</h5>
              <div class="row">
                <div class="col-md-4 label ">{{ __('Magazine') }}</div>
                <div class="col-md-8">{{ $research->magazine }}</div>
              </div>
              <div class="row">
                <div class="col-md-4 label">{{ __('Publishing URL') }}</div>
                <div class="col-md-8"><a href="{{ blank($research->publishing_url) ? '' : url($research->publishing_url) }}" target="_blank">{{ $research->publishing_url }}</a></div>
              </div>
            </div>
          </div><!-- End Bordered Tabs -->

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
              <h5 class="card-title">{{ __('Summary') }}</h5>
              <div>{{ $research->summary }}</div>
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
            {{ __('Are you sure you want to delete the qualification and its related document?') }}
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
        form.action = "../qualifications/" + id;
        console.log(form.action);
      });
    });
  </script>
@endsection