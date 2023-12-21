<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('assets/img/logo.png') }}" alt="">
      <span class="d-none d-lg-block">InayaColleges</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  {{-- <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar --> --}}

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      {{-- <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon--> --}}
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number">{{ auth()->user()->unreadNotifications()->count() }}</span>
        </a><!-- End Notification Icon -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          @if (auth()->user()->unreadNotifications()->count() == 0)
            <li class="dropdown-header">
              <span>{{ __('There are no notifications as of now') }}</span>
            </li>
          @else
            <li class="dropdown-header">
              {{ __('You have '. auth()->user()->unreadNotifications()->count()) . ' notifications' }}
              <a href="{{ route('read.all.notifications') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">{{ __('Mark All as read') }}</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            @foreach (auth()->user()->unreadNotifications()->get() as $notification)
              <a href="{{ route('read.notification', $notification->id) }}">
                <li class="notification-item">
                  <i class="bi bi-exclamation-circle text-warning"></i>
                  <div>
                    <h4>{{ $notification->data['type'] }}</h4>
                    <p>{{ $notification->data['title'] }}</p>
                    <p>{{ $notification->created_at }}</p>
                  </div>
                </li>
              </a>
            @endforeach
            <li>
              <hr class="dropdown-divider">
            </li>
          @endif
          {{-- <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
          </li> --}}
        </ul>
        <!-- End Notification Dropdown Items -->
      </li><!-- End Notification Nav -->
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-chat-left-text"></i>
          <span class="badge bg-success badge-number">0</span>
        </a><!-- End Messages Icon -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
          <li class="dropdown-header">
            <span>{{ __('There are no memos as of now') }}</span>
          </li>
          {{-- <li class="dropdown-header">
            You have 3 new messages
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
          </li> --}}
          {{-- <li class="dropdown-header">
            You have 3 new messages
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="message-item">
            <a href="#">
              <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
              <div>
                <h4>Maria Hudson</h4>
                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                <p>4 hrs. ago</p>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="message-item">
            <a href="#">
              <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
              <div>
                <h4>Anna Nelson</h4>
                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                <p>6 hrs. ago</p>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="message-item">
            <a href="#">
              <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
              <div>
                <h4>David Muldon</h4>
                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                <p>8 hrs. ago</p>
              </div>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="dropdown-footer">
            <a href="#">Show all messages</a>
          </li> --}}
        </ul>
        <!-- End Messages Dropdown Items -->
      </li><!-- End Messages Nav -->
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ asset('assets/img/weather.png') }}" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"></span>
        </a><!-- End Profile Iamge Icon -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="min-width: 150px;">
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('lang', 'en') }}">
              <i class="flag flag-united-states"></i>
              <span>English</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('lang', 'ar') }}">
              <i class="flag flag-saudi-arabia"></i>
              <span>العربية</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <a class="dropdown-item d-flex align-items-center" href="{{ route('lang', 'in') }}">
            <i class="flag flag-india"></i>
            <span>भारतीय</span>
          </a>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('lang', 'ph') }}">
              <i class="flag flag-philippines"></i>
              <span>Filipino</span>
            </a>
          </li>
        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ auth()->user()->picture() }}" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"></span>
        </a><!-- End Profile Iamge Icon -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ auth()->user()->{'first_name' .session('_lang')} . ' ' . auth()->user()->{'family_name' .session('_lang')} }}</h6>
            <span>{{ auth()->user()->position?->{'position'. session('_lang')} }}</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          {{-- <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
              <i class="bi bi-gear"></i>
              <span>Account Settings</span>
            </a>
          </li> --}}
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('faq') }}">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>
        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->
    </ul>
  </nav><!-- End Icons Navigation -->
</header><!-- End Header -->


