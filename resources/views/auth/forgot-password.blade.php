<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('assets/imgs/favicon.ico') }}">
    <title>Forgot Password</title>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/css/bootstrap/bootstrap.min.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/auth/css/app-light.css') }}" id="lightTheme">
  </head>
  <body class="light ">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100" style="margin-right:0; margin-left:0">
        <form action="{{ route('forgot-password.post') }}" method="post" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
          @csrf
          <div class="mx-auto text-center my-4">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
              <img src="{{ asset('assets/imgs/logo.png') }}" alt="" style="width: 100px; height: 100px">
            </a>
            <h2 class="my-3">Reset Password</h2>
          </div>
          <p class="text-muted">Please put your official email to reset your password</p>
          @if (session('success'))
            <div class="alert alert-success text-start">{{ session('success') }}</div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger text-start">
              @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
              @endforeach
            </div>
          @endif
          <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address" autofocus="">
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
          <p class="mt-5 mb-3 text-muted">© @php echo date('Y') @endphp</p>
        </form>
      </div>
    </div>
  </body>
</html>
</body>
</html>