@extends('layout.master')

@section('title')
  {{ __('Research') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/rich-format-text.css') }}">

  <style>
    .book, .research{
      display: none;
    }
    #phase2{
      display: none;
    }
    #progressBar{
      width: 50%;
    }

    #text-input-title{
      margin-top: 10px;
      border: 1px solid #dddddd;
      padding: 6px 10px;
      height: 38px;
      overflow: auto;
      border-radius: 5px;
    }

    #text-input{
      height: 30vh
    }
  </style>
@endsection

@section('h1')
  {{ __('Research') }}
@endsection

@section('breadcrumb')
  {{ __('Research / Add') }}
@endsection

@section('content')
  <section class="section">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ __('Research Details') }}</h5>

            <div class="progress my-3">
              <div class="progress-bar progress-bar-striped bg-success progress-bar-animated"
                role="progressBar"
                id="progressBar"
                aria-valuemin="0"
                aria-valuemax="100">50%</div>
            </div>


            <form action="{{ route('research.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div id="phase1">
                <div class="container">
                  <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-3">
                        <div for="title" class="form-label" role="label">{{ __('Research Title') }}</div>
                        <div class="options">
                          <button type="button" id="superscript" class="option-button script button">
                            <i class="fa-solid fa-superscript"></i>
                          </button>
                          <button type="button" id="subscript" class="option-button script button">
                            <i class="fa-solid fa-subscript"></i>
                          </button>
                        </div>
                        <div id="text-input-title" contenteditable="true"></div>
                        <input id="title" type="hidden" class="form-control" name="title" value="{{ old('title') }}" >
                        {{-- <span class="text-secondary"><small id="small"></small></span> --}}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label for="type_id" class="form-label">{{ __('Research Type') }}</label>
                      <select class="form-select" id="type_id" name="type_id" style="width:100%">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($type as $t)
                          <option value="{{ $t->id }}" @selected( $t->id == old('t->id'))>{{  $t->{'research_type' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="status_id" class="form-label">{{ __('Research Status') }}</label>
                      <select class="form-select" id="status_id" name="status_id" style="width:100%">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($status as $s)
                          <option value="{{ $s->id }}" @selected( $s->id == old('s->id'))>{{  $s->{'research_status' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label for="lang_id" class="form-label">{{ __('Research Language') }}</label>
                      <select class="form-select" id="lang_id" name="lang_id" style="width:100%">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($language as $l)
                          <option value="{{ $l->id }}" @selected( $l->id == old('l->id'))>{{  $l->{'research_language' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="progress_id" class="form-label">{{ __('Research Progress') }}</label>
                      <select class="form-select" id="progress_id" name="progress_id" style="width:100%">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($progress as $p)
                          <option value="{{ $p->id }}" @selected( $p->id == old('p->id'))>{{  $p->{'research_progress' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="nature_id" class="form-label">{{ __('Research Narure') }}</label>
                      <select class="form-select" id="nature_id" name="nature_id" style="width:100%">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($nature as $n)
                          <option value="{{ $n->id }}" @selected( $n->id == old('n->id'))>{{  $n->{'research_nature' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-5">
                      <label for="domain_id" class="form-label">{{ __('Research Domain') }}</label>
                      <select class="form-select" id="domain_id" name="domain_id" style="width:100%">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($domain as $d)
                          <option value="{{ $d->id }}" @selected( $d->id == old('d->id'))>{{  $d->{'research_domain' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="country_id" class="form-label">{{ __('Research Country') }}</label>
                      <select class="form-select" id="country_id" name="publication_location" style="width:100%">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($location as $c)
                          <option value="{{ $c->id }}" @selected( $c->id == old('c->id'))>{{  $c->{'country' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-9">
                      <label for="publisher" class="form-label">{{ __('Publisher') }}</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" id="publisher" name="publisher" value="{{ old('publisher') }}">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label for="date" class="form-label">{{ __('Publishing Date') }}</label>
                      <div class="col-sm-12">
                        <input type="date" class="form-control" id="date" name="publishing_date" value="{{ old('publishing_date') }}">
                      </div>
                    </div>
                  </div>
                  <div class="book">
                    <div class="my-3 row">
                      <label for="isbn" class="col-sm-1 col-form-label">{{ __('ISBN') }}</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control" id="isbn" name="isbn">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="edition" class="col-sm-1 col-form-label">{{ __('Edition') }}</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control" id="edition" name="edition" value="{{ old('edition') }}">
                      </div>
                    </div>
                  </div>
                  <div class="research">
                    <div class="my-3 row">
                      <label for="magazine" class="col-sm-3 col-form-label">{{ __('Publishing Magazine') }}</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="magazine" name="magazine" value="{{ old('magazine') }}">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="url" class="col-sm-3 col-form-label">{{ __('URL') }}</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="url" name="publishing_url" value="{{ old('url') }}">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" id="next1">{{ __("Next") }}</button>
                  </div>

                </div>
              </div>
              <div id="phase2">
                <div class="row">
                  <div class="col-md-10">
                    <label for="keyWords" class="col-sm-3 col-form-label">{{ __('Key Words') }}</label>
                    <input type="text" class="form-control" id="keyWords" name="key_words" value="{{ old('key_words') }}">
                  </div>
                  <div class="col-md-2">
                      <label for="pagesNumber" class="col-form-label">{{ __('Page Numbers') }}</label>
                      <input type="text" class="form-control" id="pagesNumber" name="pages_number" value="{{ old('pages_number') }}">
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="my-3">
                      <label for="summary" class="form-label">{{ __('Research Summary') }}</label>
                      <div class="options">
                        <button type="button" id="superscript" class="option-button script button">
                          <i class="fa-solid fa-superscript"></i>
                        </button>
                        <button type="button" id="subscript" class="option-button script button">
                          <i class="fa-solid fa-subscript"></i>
                        </button>
                      </div>
                      <div id="text-input" contenteditable="true"></div>
                      <input type="hidden" id="summary" name="summary" value="{{ old('summary') }}">
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-between my-3">
                  <button type="button" class="btn btn-danger" id="back1">{{ __("Back") }}</button>
                  <button type="submit" class="btn btn-primary" id="submit">{{ __("Submit") }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/js/rich-format-text.js') }}"></script>
  <script>
    $(document).ready(function (){
      $('select').select2();

      $('#type_id').on('change.select2', function (){
        var type_id = $(this).val();
        console.log(type_id)
        if (type_id == 1) {
          $('.book').show();
          $('.research').hide();
        }else{
          $('.book').hide();
          $('.research').show();
        }
      });

      // let title = document.getElementById('title');
      // let small = document.getElementById('small');

      // title.addEventListener('keyup', function(){
      //   let char = this.value.length;
      //   small.innerHTML = `Max characters ${char} / 255`;
      // });

      // small.innerHTML = `Max characters ${title.value.length} / 255`;

      document.getElementById('next1').addEventListener('click', () => {
        document.getElementById('phase1').style.display = "none";
        document.getElementById('phase2').style.display = "block";
        document.getElementById('progressBar').style.width = "100%";
        document.getElementById('progressBar').innerHTML = "100%";
      });

      document.getElementById('back1').addEventListener('click', () => {
        document.getElementById('phase2').style.display = "none";
        document.getElementById('phase1').style.display = "flex";
        document.getElementById('progressBar').style.width = "50%"
        document.getElementById('progressBar').innerHTML = "50%";
      });

      document.getElementById('submit').addEventListener('click', function(){
        document.getElementsByTagName('form')[0].submit();
      });

      document.getElementById('text-input-title').innerHTML = document.getElementById('title').value;
      document.getElementById('text-input').innerHTML = document.getElementById('summary').value;

      document.getElementsByTagName("form")[0].addEventListener("submit", function () {
        document.getElementById("title").value = document.getElementById("text-input-title").innerHTML;
        document.getElementById("summary").value = document.getElementById("text-input").innerHTML;
      });
    });
  </script>
@endsection