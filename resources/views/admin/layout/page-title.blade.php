<div class="pagetitle">
  <h1>
    @yield('h1')
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('global.home') }}</a></li>
      <li class="breadcrumb-item active">@yield('breadcrumb')</li>
    </ol>
  </nav>
</div><!-- End Page Title -->