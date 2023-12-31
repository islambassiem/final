@extends('layout.master')

@section('title')
  {{ __('research.research') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('research.research') }}
@endsection

@section('breadcrumb')
  {{ __('research.research') . ' / ' . __('global.show') }}
@endsection

@section('content')

<section class="section profile">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <a href="{{ route('research.index') }}"
        class="btn btn-warning mx-2">
        <i class="bi bi-arrow-left-circle me-1"></i>
        {{ __('global.back') }}
      </a>
      <button
        type="button"
        class="btn btn-danger btn-sm py-0 me-2"
        id="btn"
        data-id = "{{ $research->id }}"
        data-bs-toggle="modal"
        data-bs-target="#delteConfirmation">
        <i class="bi bi-trash3"></i>
        {{ __('global.del') }}
      </button>
      <a href="{{ route('research.edit',$research->id) }}"
        class="btn btn-primary">
        <i class="bi bi-pencil-square me-1"></i>
        {{ __('global.edit') }}
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body pb-0">
            <h5 class="card-title pb-1">{{ __('research.title') }}</h5>
            <div class="pb-3">
              @php
                if(file_exists(public_path('storage/' . auth()->user()->id . '/text//'.$research->id.'_research_title.txt'))){
                  echo file_get_contents(public_path('storage/' . auth()->user()->id . '/text//'.$research->id.'_research_title.txt'));
                }
              @endphp
            </div>
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
              <h5 class="card-title">{{ __('research.details') }}</h5>
              <div class="row">
                <div class="col-md-4 label ">{{ __('research.publisher') }}</div>
                <div class="col-md-8">{{ $research->publisher }}</div>
              </div>
              <div class="row">
                <div class="col-md-4 label">{{ __('research.date') }}</div>
                <div class="col-md-8">{{ $research->publishing_date }}</div>
              </div>
              <div class="row">
                <div class="col-md-4 label">{{ __('research.words') }}</div>
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
              <h5 class="card-title">{{ __('research.details') }}</h5>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.type') }}</div>
                <div class="col-md-8">{{ $research->type?->{'research_type' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.status') }}</div>
                <div class="col-md-8">{{ $research->status?->{'research_status' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.progress') }}</div>
                <div class="col-md-8">{{ $research->progress?->{'research_progress' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.nature') }}</div>
                <div class="col-md-8">{{ $research->nature?->{'research_nature' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.domain') }}</div>
                <div class="col-md-8">{{ $research->domain?->{'research_domain' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.lang') }}</div>
                <div class="col-md-8">{{ $research->language?->{'research_language' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.location') }}</div>
                <div class="col-md-8">{{ $research->publication_location }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.citation') }}</div>
                <div class="col-md-8">{{ $research->citation?->name }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">{{ __('research.edition') }}</div>
                <div class="col-lg-9 col-md-8">{{ $research->edition }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('research.magazine') }}</div>
                <div class="col-md-8">{{ $research->magazine }}</div>
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
              <h5 class="card-title">{{ __('research.book') }}</h5>
              <div class="row">
                <div class="col-lg-3 col-md-4 label ">{{ __('research.isbn') }}</div>
                <div class="col-lg-9 col-md-8">{{ $research->isbn }}</div>
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
              <h5 class="card-title">{{ __('research.research') }}</h5>
              <div class="row">
                <div class="col-md-4 label">{{ __('research.url') }}</div>
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
              <h5 class="card-title">{{ __('research.summary') }}</h5>
              <div>
                @php
                  if(file_exists(public_path('storage/' . auth()->user()->id . '/text//'.$research->id.'_research_summary.txt'))){
                    echo file_get_contents(public_path('storage/' . auth()->user()->id . '/text//'.$research->id.'_research_summary.txt'));
                  }
                @endphp
              </div>
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
        form.action = "../research/" + id;
        console.log(form.action);
      });
    });
  </script>
@endsection