
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <title>Log in</title>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('assets/auth/auth/css/app-light.css') }}" id="lightTheme">
    <link rel="stylesheet" href="{{ asset('assets/plugins/dashboard/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/show_password.css') }}">

  </head>
  <body class="light ">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100" style="margin-right:0; margin-left:0">
        <form action="{{ route('login') }}" method="POST" class="col-lg-3 col-md-4 col-10 mx-auto text-center" autocomplete="off">
          @csrf
          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
            <img src="{{ asset('assets/img/logo.png') }}" alt="" style="width: 100px; height: 100px">
          </a>
          <h1 class="h5 my-3">Employee Login</h1>
          <div class="form-group">
            <label for="empid" class="sr-only">Employee ID</label>
            <input type="text" id="empid" name="empid" class="form-control form-control-lg" placeholder="Employee ID" autofocus="" value="{{ old('empid') }}">
          </div>
          <div class="form-group position-relative">
            <label for="inputPassword" class="sr-only">Password</label>
            <i class="mdi mdi-eye" id="eye-open"></i>
            <i class="mdi mdi-eye-off" id="eye-closed"></i>
            <input type="password" name="password" id="inputPassword" class="form-control form-control-lg" placeholder="Password">
          </div>
          @if (session()->has('error'))
            <div class="container-login100-form-btn">
              <div class="alert alert-danger text-start">
                {{ session()->get('error') }}
              </div>
            </div>
          @endif
          @if (session()->has('success'))
          <div class="container-login100-form-btn">
            <div class="alert alert-success text-start">
              {{ session()->get('success') }}
            </div>
          </div>
          @endif
          <div class="checkbox mb-3 d-flex felx-column justify-content-between">
            <div>
              <label>
                <input type="checkbox" name="remember"> Remember me
              </label>
            </div>
            <div>
              <a href="{{ route('forgot-password') }}">Forgot Password?</a>
            </div>
          </div>
          <div class="checkbox mb-3 d-flex felx-column justify-content-between">
            <div>
              <label>
                Sign in as
              </label>
            </div>
            <div class="d-flex justify-content-end w-50">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="hr">
                <label class="form-check-label" for="flexSwitchCheckDefault">Sign as HR</label>
              </div>
            </div>
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
          <div class="mb-3">
            <a href="{{ route('google') }}" class="mt-5">
              <img src="{{ asset('assets/img/google.jpeg') }}" alt="" style="width: 100%; margin-top:2.5rem;">
            </a>
          </div>
          <p class="mt-5 mb-3 text-muted">© @php echo date('Y') @endphp</p>
        </form>
      </div>
    </div>
    <script src="{{ asset('assets/js/show_password.js') }}"></script>
  </body>
</html>
</body>
</html>