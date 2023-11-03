<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}">
    <title>Reset Password</title>
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('assets/auth/css/forfot-password.css') }}" id="lightTheme">
    <link rel="stylesheet" href="{{ asset('assets/vendor/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/show_password.css') }}">
    <style>
      #eye-open2, #eye-closed2{
        font-size: 30px;
        position: absolute;
        right: 0;
        padding-right: 10px;
      }
      #eye-open2{
        display: none;
      }
    </style>
  </head>
  <body class="light ">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100">
        <form action="{{ route('reset-password.post') }}" method="post" class="col-lg-3 col-md-4 col-10 mx-auto text-center">
          @csrf
          <input type="text" hidden name="token" value="{{ $token }}">
          <div class="mx-auto text-center my-4">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
              <img src="{{ asset('assets/img/logo.png') }}" alt="" style="width: 100px; height: 100px">
            </a>
            <h2 class="my-3">Reset Password</h2>
          </div>
          <p class="text-muted">Enter your email address and a confirmed new password</p>
          @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                  <div>{{ $error }}</div>
                @endforeach
            </div>
          @endif
          <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address" autofocus="" value="{{ old('email') }}">
          </div>
          <div class="form-group position-relative">
            <label for="password" class="sr-only">Email address</label>
            <i class="mdi mdi-eye" id="eye-open"></i>
            <i class="mdi mdi-eye-off" id="eye-closed"></i>
            <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="New Password" autofocus="">
          </div>
          <div class="form-group position-relative">
            <label for="passwordConfirmation" class="sr-only">Email address</label>
            <i class="mdi mdi-eye" id="eye-open2"></i>
            <i class="mdi mdi-eye-off" id="eye-closed2"></i>
            <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-control form-control-lg" placeholder="Confirm password" autofocus="">
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Change Password</button>
          <p class="mt-5 mb-3 text-muted">© @php echo date('Y') @endphp</p>
        </form>
      </div>
    </div>
    <script src="{{ asset('assets/js/show_password.js') }}"></script>

    <script>
      var eyeOpen2 = document.getElementById('eye-open2');
      var eyeClosed2 = document.getElementById('eye-closed2');
      var password2 = document.getElementsByName('password_confirmation');


      eyeClosed2.addEventListener('click', function(){
        this.style.display = "none";
        eyeOpen2.style.display = "block";
        password2[0].type = 'text';
      });

      eyeOpen2.addEventListener('click', function(){
        this.style.display = "none";
        eyeClosed2.style.display = "block";
        password2[0].type = 'password';
      });
    </script>
  </body>
</html>
</body>
</html>