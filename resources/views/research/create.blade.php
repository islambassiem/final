@extends('layout.master')

@section('title')
  {{ __('research.research') }}
@endsection

@section('style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/select2.custom.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/rich-format-text.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/required.css') }}">

  <style>
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
  </style>
@endsection

@section('h1')
  {{ __('research.research') }}
@endsection

@section('breadcrumb')
  {{ __('research.research') . ' / ' . __('global.add') }}
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
            <h5 class="card-title">{{ __('research.details') }}</h5>

            <div class="progress my-3">
              <div class="progress-bar progress-bar-striped bg-success progress-bar-animated"
                role="progressBar"
                id="progressBar"
                aria-valuemin="0"
                aria-valuemax="100">50%</div>
            </div>


            <form action="{{ route('research.store') }}" method="POST">
              @csrf
              <div id="phase1">
                <div class="container">
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-3">
                        <div for="title" class="form-label" role="label">{{ __('research.title') }}</div>
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
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label for="type_id" class="form-label">{{ __('research.type') }}</label>
                      <select class="form-select" id="type_id" name="type_id" style="width:100%">
                        <option selected disabled>{{ __('global.select') }}</option>
                        @foreach ($type as $t)
                          <option value="{{ $t->id }}" @selected( $t->id == old('t->id'))>{{  $t->{'research_type' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="status_id" class="form-label">{{ __('research.status') }}</label>
                      <select class="form-select" id="status_id" name="status_id" style="width:100%">
                        <option selected disabled>{{ __('global.select') }}</option>
                        @foreach ($status as $s)
                          <option value="{{ $s->id }}" @selected( $s->id == old('s->id'))>{{  $s->{'research_status' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label for="lang_id" class="form-label">{{ __('research.lang') }}</label>
                      <select class="form-select" id="lang_id" name="lang_id" style="width:100%">
                        <option selected disabled>{{ __('global.select') }}</option>
                        @foreach ($language as $l)
                          <option value="{{ $l->id }}" @selected( $l->id == old('l->id'))>{{  $l->{'research_language' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="progress_id" class="form-label">{{ __('research.progress') }}</label>
                      <select class="form-select" id="progress_id" name="progress_id" style="width:100%">
                        <option selected disabled>{{ __('global.select') }}</option>
                        @foreach ($progress as $p)
                          <option value="{{ $p->id }}" @selected( $p->id == old('p->id'))>{{  $p->{'research_progress' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="nature_id" class="form-label">{{ __('research.nature') }}</label>
                      <select class="form-select" id="nature_id" name="nature_id" style="width:100%">
                        <option selected disabled>{{ __('global.select') }}</option>
                        @foreach ($nature as $n)
                          <option value="{{ $n->id }}" @selected( $n->id == old('n->id'))>{{  $n->{'research_nature' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-5">
                      <label for="domain_id" class="form-label">{{ __('research.domain') }}</label>
                      <select class="form-select" id="domain_id" name="domain_id" style="width:100%">
                        <option selected disabled>{{ __('global.select') }}</option>
                        @foreach ($domain as $d)
                          <option value="{{ $d->id }}" @selected( $d->id == old('d->id'))>{{  $d->{'research_domain' . session('_lang')} }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="date" class="form-label">{{ __('research.date') }}</label>
                      <div class="col-sm-12">
                        <input type="date" class="form-control" id="date" name="publishing_date" value="{{ old('publishing_date') }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5">
                      <label for="publisher" class="form-label">{{ __('research.publisher') }}</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" id="publisher" name="publisher" maxlength="60" value="{{ old('publisher') }}">
                        @error('publisher')
                          <small class="text-danger">{{ $message }}</small><br>
                        @enderror
                        <span class="text-secondary"><small id="publisherSmall"></small></span>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <label for="country_id" class="form-label">{{ __('research.location') }}</label>
                      <input type="text" class="form-control" id="publication_location" name="publication_location" maxlength="100"  value="{{ old('publication_location') }}">
                      <span class="text-secondary"><small id="locationSmall"></small></span>
                    </div>
                    <div class="col-md-2">
                      <label for="citation" class="form-label">{{ __('research.citation') }}</label>
                      <select class="form-select" id="citation" name="citation_type" style="width:100%">
                        <option selected disabled>{{ __('global.select') }}</option>
                        @foreach ($citations as $citation)
                          <option value="{{ $citation->id }}" @selected( $citation->id == old('citation->id'))>{{  $citation->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                    <div class="my-3 row">
                      <label for="magazine" class="col-sm-3 col-form-label">{{ __('research.magazine') }}</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="magazine" maxlength="100" name="magazine" value="{{ old('magazine') }}">
                        <span class="text-secondary"><small id="magazineSmall"></small></span>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="url" class="col-sm-3 col-form-label">{{ __('research.url') }}</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="url" name="publishing_url" maxlength="1000" value="{{ old('url') }}">
                        <span class="text-secondary"><small id="urlSmall"></small></span>
                      </div>
                    </div>
                  <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" id="next1">{{ __('global.next') }}</button>
                  </div>

                </div>
              </div>
              <div id="phase2">
                <div class="row">
                  <div class="col-12">
                    <label for="keyWords" class="col-sm-3 col-form-label">{{ __('research.words') }}</label>
                    <input type="text" class="form-control" id="keyWords" name="key_words" maxlength="200" value="{{ old('key_words') }}">
                    <span class="text-secondary"><small id="keyWordsSmall"></small></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="isbn" class="col-form-label">{{ __('research.isbn') }}</label>
                      <input type="text" class="form-control" id="isbn" maxlength="13" name="isbn" value="{{ old('isbn') }}">
                      <span class="text-secondary"><small id="isbnSmall"></small></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="edition" class="col-form-label">{{ __('research.edition') }}</label>
                      <input type="text" class="form-control" id="edition" name="edition" maxlength="10" value="{{ old('edition') }}">
                      <span class="text-secondary"><small id="editionSmall"></small></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="pagesNumber" class="col-form-label">{{ __('research.pageNo') }}</label>
                      <input type="text" maxlength="5" class="form-control" id="pagesNumber" name="pages_number" onkeypress="return /[0-9]/i.test(event.key)" value="{{ old('pages_number') }}">
                      <span class="text-secondary"><small id="pagesNumberSmall"></small></span>
                    </div>
                  </div>
                  </div>
                <div class="row">
                  <div class="col">
                    <div class="my-3">
                      <div for="summary" class="form-label">{{ __('research.summary') }}</label>
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
                  <button type="button" class="btn btn-danger" id="back1">{{ __('global.back') }}</button>
                  <button type="submit" class="btn btn-primary" id="submit">{{ __('global.submit') }}</button>
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

      let max = "{{ __('global.max') }}";
      let publication_location = document.getElementById('publication_location');
      let locationSmall = document.getElementById('locationSmall');
      let publisher = document.getElementById('publisher');
      let publisherSmall = document.getElementById('publisherSmall');
      let magazine = document.getElementById('magazine');
      let magazineSmall = document.getElementById('magazineSmall');
      let url = document.getElementById('url');
      let urlsmall = document.getElementById('urlSmall');
      let keyWords = document.getElementById('keyWords');
      let keyWordsSmall = document.getElementById('keyWordsSmall');
      let isbn = document.getElementById('isbn');
      let isbnSmall = document.getElementById('isbnSmall');
      let edition = document.getElementById('edition');
      let editionSmall = document.getElementById('editionSmall');
      let pagesNumber = document.getElementById('pagesNumber');
      let pagesNumberSmall = document.getElementById('pagesNumberSmall');

      pagesNumber.addEventListener('keyup', function(){
        let char = this.value.length;
        pagesNumberSmall.innerHTML = `${max} ${char} / 5`;
      });
      pagesNumberSmall.innerHTML = `${max} ${title.value.length} / 5`;

      edition.addEventListener('keyup', function(){
        let char = this.value.length;
        editionSmall.innerHTML = `${max} ${char} / 10`;
      });
      editionSmall.innerHTML = `${max} ${title.value.length} / 10`;

      isbn.addEventListener('keyup', function(){
        let char = this.value.length;
        isbnSmall.innerHTML = `${max} ${char} / 13`;
      });
      isbnSmall.innerHTML = `${max} ${title.value.length} / 13`;

      keyWords.addEventListener('keyup', function(){
        let char = this.value.length;
        keyWordsSmall.innerHTML = `${max} ${char} / 200`;
      });
      keyWordsSmall.innerHTML = `${max} ${title.value.length} / 200`;

      url.addEventListener('keyup', function(){
        let char = this.value.length;
        urlSmall.innerHTML = `${max} ${char} / 1000`;
      });
      urlSmall.innerHTML = `${max} ${title.value.length} / 1000`;

      magazine.addEventListener('keyup', function(){
        let char = this.value.length;
        magazineSmall.innerHTML = `${max} ${char} / 100`;
      });
      magazineSmall.innerHTML = `${max} ${title.value.length} / 100`;

      publication_location.addEventListener('keyup', function(){
        let char = this.value.length;
        locationSmall.innerHTML = `${max} ${char} / 100`;
      });
      locationSmall.innerHTML = `${max} ${title.value.length} / 100`;

      publisher.addEventListener('keyup', function(){
        let char = this.value.length;
        publisherSmall.innerHTML = `${max} ${char} / 60`;
      });
      publisherSmall.innerHTML = `${max} ${title.value.length} / 60`;

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