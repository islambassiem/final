@extends('layout.master')

@section('title')
  {{ __('Qualifications') }}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('Qualifications') }}
@endsection

@section('breadcrumb')
  {{ __('Qualifications / All') }}
@endsection

@section('content')
  <section class="section">
    <div class="row">
      <div class="col d-flex justify-content-end mb-3">
        <a href="{{ route('qualifications.create') }}"
          class="btn btn-success">
          <i class="bi bi-plus-square-fill me-1"></i>
          {{ __('Add') }}
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            @if (count($qualifications) == 0)
              <div class="alert alert-danger my-5" role="alert">
                {{ __('There are no qualifications Registered') }}
              </div>
            @else
              <h5 class="card-title">{{ __('Qualifications') }}</h5>
              @if (session('success'))
                <div class="alert alert-success" role="alert">
                  {{ session('success') }}
                </div>
              @endif
              @if (session('message'))
              <div class="alert alert-warning" role="alert">
                {{ session('message') }}
              </div>
              @endif
              <!-- Table with stripped rows -->
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Qualification</th>
                    <th scope="col">University</th>
                    <th scope="col">Major</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php $c = 1; @endphp
                  @foreach ($qualifications as $qualification)
                    <tr>
                      <td>{{ $c }}</td>
                      <td>{{ $qualification->qualificationName->{'qualification' . session('_lang')} }}</td>
                      <td>{{ $qualification->graduation_university }}</td>
                      <td>{{ $qualification->major->{'specialty' . session('_lang')} }}</td>
                      <td>{{ $qualification->graduation_date }}</td>
                      <td>
                        <a
                          href="{{ route('qualifications.show', $qualification->id) }}"
                          class="btn btn-secondary btn-sm py-0">
                          <i class="bi bi-eye-fill"></i>
                        </a>
                        <a
                          href="{{ route('qualifications.edit', $qualification->id) }}"
                          class="btn btn-warning btn-sm py-0">
                          <i class="bi bi-pencil-square"></i>
                        </a>
                        <button
                          type="button"
                          class="btn btn-danger btn-sm py-0"
                          id="btn"
                          data-id = "{{ $qualification->id }}"
                          data-bs-toggle="modal"
                          data-bs-target="#delteConfirmation">
                          <i class="bi bi-trash3"></i>
                        </button>
                        <a
                        href="{{ route('qualification.attachment', $qualification->id) }}"
                        class="btn btn-info btn-sm py-0">
                        <i class="bi bi-paperclip"></i>
                      </a>
                      </td>
                    </tr>
                    @php $c++; @endphp
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
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
        <h1 class="modal-title fs-5" id="delteConfirmationLabel">{{ __('Delete Confirmation!') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="deleteForm">
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
        form.action = "qualifications/" + id;
      });
    });
  </script>
@endsection