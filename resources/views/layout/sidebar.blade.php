    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed'  }}" href="{{ route('dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dependents.*') || request()->routeIs('acquaintances.*') ? '' : 'collapsed'  }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>{{ __('Personal') }}</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse {{ request()->routeIs('dependents.*') || request()->routeIs('acquaintances.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{ route('dependents.index') }}" class="{{ Request::routeIs('dependents.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>{{ __("Dependents") }}</span>
              </a>
            </li>
            <li>
              <a href="{{ route('acquaintances.index') }}" class="{{ Request::routeIs('acquaintances.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>{{ __('Acquaintances') }}</span>
              </a>
            </li>
          </ul>
        </li>
        <!-- End Tables Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('qualifications.*') ? '' : 'collapsed'  }}" href="{{ route('qualifications.index') }}">
            <i class="bi bi-person"></i>
            <span>{{ __('Qualifications') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('achievements.*') ? '' : 'collapsed'  }}" href="{{ route('achievements.index') }}">
            <i class="bi bi-person"></i>
            <span>{{ __('Achievements') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('courses.*') ? '' : 'collapsed'  }}" href="{{ route('courses.index') }}">
            <i class="bi bi-person"></i>
            <span>{{ __('Courses') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->


      </ul>

    </aside><!-- End Sidebar-->