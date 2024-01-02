@extends('layout.master')

@section('title')
  {{ __('vacations.vacations') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/dropfiy/css/dropify.min.css') }}">
@endsection

@section('h1')
  {{ __('vacations.vacations') }}
@endsection

@section('breadcrumb')
  {{ __('vacations.vacations') . ' / ' . __('global.show')}}
@endsection

@section('content')
  <section class="section">
    @if (session('message'))
      <div class="alert alert-warning" role="alert">
        {{ session('message') }}
      </div>
    @endif
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <a href="{{ route('vacations.history') }}"
          class="btn btn-warning mx-2">
          <i class="bi bi-arrow-left-circle me-1"></i>
          {{ __('global.back') }}
        </a>
        <button
          type="button"
          class="btn btn-danger btn-sm py-0 me-2"
          id="btn"
          data-id = "{{ $vacation->id }}"
          data-bs-toggle="modal"
          data-bs-target="#delteConfirmation">
          <i class="bi bi-trash3"></i>
          {{ __('global.del') }}
        </button>
        @if (blank($vacation->attachment?->link))
        <button
          type="button"
          id="editBtn"
          data-id="{{ $vacation->id }}"
          class="btn btn-primary mx-2"
          data-bs-toggle="modal"
          data-bs-target="#attach">
          <i class="bi bi-cloud-upload-fill me-1"></i>
          {{ __('vacations.attach') }}
        </button>
        @else
        <a
          href="{{ route('attachment.vacation', $vacation->id) }}"
          target="_blank"
          class="btn btn-info mx-2">
          <i class="bi bi-paperclip"></i>
          {{ __('global.attachment') }}
        @endif
        </a>
      </div>
    </div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
    <div class="row text-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body pb-1">
            <h2 class="card-title h2 pb-0">{{ __('vacations.start') }}</h2>
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
            <h5 class="card-title pb-0">{{ __('vacations.end') }}</h5>
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
            <h5 class="card-title pb-0">{{ __('vacations.type') }}</h5>
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
            <h5 class="card-title pb-0">{{ __('vacations.status') }}</h5>
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
                {{ __('vacations.details') }}
              </h5>
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('vacations.days') }}</div>
            <div>{{ $vacation->days }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('vacations.date') }}</div>
            <div>
              @if (!blank($vacation->detail?->employee_time))
                {{ date('d/m/Y', strtotime($vacation->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('vacations.time') }}</div>
            <div>
              @if (!blank($vacation->detail?->employee_time))
                {{ date('H:i:s', strtotime($vacation->detail?->employee_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('vacations.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->employee_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('vacations.deptHead') }}
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
            <div>{{ __('vacations.status') }}</div>
            <div>{{ $vacation->detail?->headStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('vacations.date') }}</div>
            <div>
              @if (!blank($vacation->detail?->head_time))
                {{ date('m/d/Y', strtotime($vacation->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('vacations.time') }}</div>
            <div>
              @if (!blank($vacation->detail?->head_time))
                {{ date('H:i:s', strtotime($vacation->detail?->head_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('vacations.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->head_notes }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">
                {{ __('vacations.hr') }}
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
            <div>{{ __('vacations.status') }}</div>
            <div>{{ $vacation->detail?->hrStatus->{ 'workflow_status' . session('_lang') } }}</div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('vacations.date') }}</div>
            <div>
              @if (!blank($vacation->detail?->hr_time))
                {{ date('m/d/Y', strtotime($vacation->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="d-flex justify-content-between px-3 py-2">
            <div>{{ __('vacations.time') }}</div>
            <div>
              @if (!blank($vacation->detail?->hr_time))
                {{ date('H:i:s', strtotime($vacation->detail?->hr_time)) }}
              @endif
            </div>
          </div>
          <div class="card-title ps-3 pt-3 pb-0">{{ __('vacations.notes') }}</div>
          <div class="border pt-2 ps-3 mx-3 mb-3" style="min-height:50px">{{ $vacation->detail?->hr_notes }}</div>
        </div>
      </div>
    </div>
  </section>

    <!-- Modal -->
    <div class="modal fade" id="attach" tabindex="-1" aria-labelledby="attachLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="attachLabel">{{ __('vacations.addAttach') }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('vacation.addAttachment', $vacation->id) }}" method="post" id="attachmentForm" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-12">
                  <label for="attachment" class="col-sm-2 col-form-label">{{ __('global.attachment') }}</label>
                  <div class="col-sm-12">
                    <input
                      type="file"
                      class="dropify"
                      id="attachment"
                      name="attachment"
                      data-height="100"
                      accept="image/*, .pdf">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('global.close') }}</button>
            <button type="submit" form="attachmentForm" class="btn btn-primary">{{ __('global.submit') }}</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
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
<script src="{{ asset('assets/vendor/dropfiy/js/dropify.min.js') }}"></script>
  <script>
    $(document).ready(function (){
      $('#delteConfirmation').on('show.bs.modal', function (event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let form = document.getElementById('deleteForm');
        form.action = "../vacations/" + id;
      });
      $('.dropify').dropify({
        messages: {
          'default': "",
          'replace': "{{ __('global.dnd') }}",
          'remove':  "{{ __('global.del') }}",
          'error': "{{ __('global.error') }}"
        }
      });
    });
  </script>
@endsection