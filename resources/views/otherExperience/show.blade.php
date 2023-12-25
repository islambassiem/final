@extends('layout.master')

@section('title')
  {{ __('otherExperience.otherExperience') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('otherExperience.otherExperience') }}
@endsection

@section('breadcrumb')
  {{ __('otherExperience.otherExperience')  . ' / ' . __('global.show') }}
@endsection

@section('content')

<section class="section profile">
  <div class="row">
    <div class="col d-flex justify-content-end mb-3">
      <a href="{{ route('other_experience.index') }}"
        class="btn btn-warning mx-2">
        <i class="bi bi-arrow-left-circle me-1"></i>
        {{ __('global.back') }}
      </a>
      <button
        type="button"
        class="btn btn-danger btn-sm py-0 me-2"
        id="btn"
        data-id = "{{ $experience->id }}"
        data-bs-toggle="modal"
        data-bs-target="#delteConfirmation">
        <i class="bi bi-trash3"></i>
        {{ __('global.del') }}
      </button>
      <a href="{{ route('other_experience.edit',$experience->id) }}"
        class="btn btn-primary">
        <i class="bi bi-pencil-square me-1"></i>
        {{ __('global.edit') }}
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <!-- Bordered Tabs -->
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">{{ __('Experience Details') }}</h5>

              <div class="row">
                <div class="col-md-4 label ">{{ __('otherExperience.organization') }}</div>
                <div class="col-md-8">{{ $experience->organization_name }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('otherExperience.position') }}</div>
                <div class="col-md-8">{{ $experience->profession }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('otherExperience.country') }}</div>
                <div class="col-md-8">{{ $experience->country?->{'country' . session('_lang')} }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('otherExperience.city') }}</div>
                <div class="col-md-8">{{ $experience->city }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('otherExperience.start') }}</div>
                <div class="col-md-8">{{ $experience->start_date }}</div>
              </div>

              <div class="row">
                <div class="col-md-4 label ">{{ __('otherExperience.end') }}</div>
                <div class="col-md-8">{{ $experience->end_date }}</div>
              </div>
            </div>
          </div><!-- End Bordered Tabs -->

        </div>
      </div>
    </div>
    <div class="col-md-5">
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
              {{ __('global.noAttach') }}
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
              <h5 class="card-title">{{ __('otherExperience.tasks') }}</h5>
                <div>{{ $experience->tasks() }}</div>
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
        form.action = "../other_experience/" + id;
      });
    });
  </script>
@endsection