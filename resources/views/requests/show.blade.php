@extends('layout.master')

@section('title')
  {{ __('requests.requests')}}
@endsection

@section('style')
@endsection

@section('h1')
  {{ __('requests.generic') }}
@endsection

@section('breadcrumb')
  {{__('requests.requests') .  ' / ' . __('requests.generic') . ' / ' . __('global.all')}}
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          {{ __('requests.addReq') }}
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
                <label for="title" class="form-label">{{ __('requests.title') }}</label>
                <input type="text" class="form-control" id="title" name="title" readonly value="{{ $generic->title }}">
              </div>
              <div class="mb-3">
                <label for="subject" class="form-label">{{ __('requests.subject') }}</label>
                <div id="subject" class="form-control">
                  @php echo file_get_contents(public_path('storage/' . auth()->user()->id . '/text//' . $generic->id . '.txt')) @endphp
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
  <script src="{{ asset('assets/js/rich-format-text.js') }}"></script>
  <script>
    document.getElementsByTagName("form")[0].addEventListener("submit", function () {
      document.getElementById("subject").value = document.getElementById("text-input").innerHTML;
    });
  </script>
@endsection