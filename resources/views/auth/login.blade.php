<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <title>HRMS - Log in</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('assets/auth/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}">
  </head>
<body>
  <div class="main">
      <!-- Sing in  Form -->
      <section class="sign-in">
        <div class="container">
          <div class="signin-content">
            <div class="signin-image">
              <figure><img src="{{ asset('assets/auth/images/signup-image.jpg') }}" alt="sing up image"></figure>
            </div>
            <div class="signin-form">
              <h2 class="form-title">Sign In</h2>
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              @if (session()->has('error'))
                <div class="container-login100-form-btn">
                  <div class="alert alert-danger text-start">
                    {{ session()->get('error') }}
                  </div>
                </div>
              @endif
              <form action="{{ route('login') }}" method="POST" class="register-form" id="login-form">
                @csrf
                <div class="form-group">
                  <label for="empid"><i class="zmdi zmdi-account material-icons-name"></i></label>
                  <input type="text" name="empid" id="empid" placeholder="Your employee ID"/>
                  @error('empid')
                    <div class="alert alert-danger my-2">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password"><i class="zmdi zmdi-lock"></i></label>
                  <input type="password" name="password" id="password" placeholder="Password"/>
                  @error('password')
                    <div class="alert alert-danger my-2">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                  <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                </div>
                <div>
                  <a href="{{ route('forgot-password') }}">Forgot Password?</a>
                </div>
                <div class="form-group form-button">
                  <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                </div>
              </form>
              <div class="social-login">
                <span class="social-label">Or login with</span>
                <ul class="socials">
                    <li><a href="{{ route('google') }}"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                </ul>
            </div>
            </div>
          </div>
        </div>
      </section>

  </div>
  <!-- JS -->
  <script src="{{ asset('assets/auth/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/auth/js/main.js') }}"></script>
</body>
</html>