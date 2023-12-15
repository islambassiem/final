@extends('layout.master')

@section('title')
  {{ __('Requests') }}
@endsection

@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/rich-format-text.css') }}">
@endsection

@section('h1')
  {{ __('Requests') }}
@endsection

@section('breadcrumb')
  {{ __('Requests / Add') }}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('Add your request') }}
        </h5>
        <div class="row">
          <div class="col">
            <form action="{{ route('generics.store') }}" method='post'>
              @csrf
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <div class="mb-3">
                <label for="title" class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control" id="title" name="title"  value="{{ old('title') }}">
              </div>
              <div class="row">
                <div class="col">
                  <div class="my-3">
                    <span for="subject" class="form-label">{{ __('Subject') }}</span>
                    <div class="options">
                      <!-- Text Format -->
                      <button type="button" id="bold" class="option-button format button">
                        <i class="fa-solid fa-bold"></i>
                      </button>
                      <button type="button" id="italic" class="option-button format button">
                        <i class="fa-solid fa-italic"></i>
                      </button>
                      <button type="button" id="underline" class="option-button format button">
                        <i class="fa-solid fa-underline"></i>
                      </button>
                      <button type="button" id="superscript" class="option-button script button">
                        <i class="fa-solid fa-superscript"></i>
                      </button>
                      <button type="button" id="subscript" class="option-button script button">
                        <i class="fa-solid fa-subscript"></i>
                      </button>

                      <!-- List -->
                      <button type="button" id="insertOrderedList" class="option-button button">
                        <div class="fa-solid fa-list-ol"></div>
                      </button>

                      <!-- Alignment -->
                      <button type="button" id="justifyLeft" class="option-button align button">
                        <i class="fa-solid fa-align-left"></i>
                      </button>
                      <button type="button" id="justifyCenter" class="option-button align button">
                        <i class="fa-solid fa-align-center"></i>
                      </button>
                      <button type="button" id="justifyRight" class="option-button align button">
                        <i class="fa-solid fa-align-right"></i>
                      </button>
                      <button type="button" id="justifyFull" class="option-button align button">
                        <i class="fa-solid fa-align-justify"></i>
                      </button>
                      <button type="button" id="indent" class="option-button spacing button">
                        <i class="fa-solid fa-indent"></i>
                      </button>
                      <button type="button" id="outdent" class="option-button spacing button">
                        <i class="fa-solid fa-outdent"></i>
                      </button>

                    </div>
                    <div id="text-input" contenteditable="true"></div>
                    <input type="hidden" class="form-control" id="subject" name="subject" value="{{ old('subject') }}">
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary float-end" >{{ __('Submit') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script src="{{ asset('assets/js/rich-format-text.js') }}"></script>
  <script>
    document.getElementsByTagName("form")[0].addEventListener("submit", function () {
      document.getElementById("subject").value = document.getElementById("text-input").innerHTML;
    });
  </script>
@endsection