<!DOCTYPE html>
<html lang="{{ session('lang') ?? 'en' }}" dir="{{ session('dir') ?? 'ltr' }}">
  <head>
    @include('admin.layout.head')
    @include('admin.layout.styles')
    @yield('style')
  </head>
  <body>
    @include('admin.layout.header')
    @include('admin.layout.sidebar')
    <main id="main" class="main">
      @include('admin.layout.page-title')
      @yield('content')
    </main>
    @include('admin.layout.footer')
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    @include('admin.layout.scripts')
    @yield('script')
  </body>
</html>