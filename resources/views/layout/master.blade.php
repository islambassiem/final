<!DOCTYPE html>
<html lang="{{ session('lang') ?? 'en' }}" dir="{{ session('dir') ?? 'ltr' }}">
  <head>
    @include('layout.head')
    @include('layout.styles')
    @yield('style')
  </head>
  <body>
    @include('layout.header')
    @include('layout.sidebar')
    <main id="main" class="main">
      @include('layout.page-title')
      @yield('content')
    </main>
    @include('layout.footer')
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    @include('layout.scripts')
    @yield('script')
  </body>
</html>