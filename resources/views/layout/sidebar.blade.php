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
          <a class="nav-link {{ request()->routeIs('dependents.*') || request()->routeIs('acquaintances.*') || request()->routeIs('profile.*') ? '' : 'collapsed'  }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>{{ __('Personal') }}</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse {{ request()->routeIs('dependents.*') || request()->routeIs('acquaintances.*') || request()->routeIs('profile.*')? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{ route('profile.index') }}" class="{{ Request::routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>{{ __("Profile") }}</span>
              </a>
            </li>
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
        <a class="nav-link {{ request()->routeIs('experience.*') || request()->routeIs('other_experience.*') ? '' : 'collapsed'  }}" data-bs-target="#leaves" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-workspace"></i><span>{{ __('Experience') }}</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="leaves" class="nav-content collapse {{ request()->routeIs('experience.*') || request()->routeIs('other_experience.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('experience.index') }}" class="{{ Request::routeIs('experience.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>{{ __('Academic - KSA') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('other_experience.index') }}" class="{{ request()->routeIs('other_experience.*') ? 'active' : ''  }}" >
              <i class="bi bi-circle"></i>
              <span>{{ __('Other') }}</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->


      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('vacations.*') || request()->routeIs('permissions.*') ? '' : 'collapsed'  }}" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-walking"></i><span>{{ __('Leaves') }}</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse {{ request()->routeIs('vacations.*') || request()->routeIs('permissions.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('vacations.index') }}" class="{{ Request::routeIs('vacations.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>{{ __('Vacations') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('permissions.index') }}" class="{{ request()->routeIs('permissions.*') ? 'active' : ''  }}" >
              <i class="bi bi-circle"></i>
              <span>{{ __('Permissions') }}</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('documents.*') ? '' : 'collapsed'  }}" href="{{ route('documents.index') }}">
          <i class="bi bi-stickies-fill"></i>
          <span>{{ __('Documents') }}</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('salary.*') ? '' : 'collapsed'  }}" href="{{ route('salary.index') }}">
          <i class="bi bi-cash-coin"></i>
          <span>{{ __('Salary') }}</span>
        </a>
      </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('qualifications.*') ? '' : 'collapsed'  }}" href="{{ route('qualifications.index') }}">
            <i class="bi bi-mortarboard-fill"></i>
            <span>{{ __('Qualifications') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('achievements.*') ? '' : 'collapsed'  }}" href="{{ route('achievements.index') }}">
            <i class="bi bi-person-arms-up"></i>
            <span>{{ __('Achievements') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('courses.*') ? '' : 'collapsed'  }}" href="{{ route('courses.index') }}">
            <i class="bi bi-trophy-fill"></i>
            <span>{{ __('Courses') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('research.*') ? '' : 'collapsed'  }}" href="{{ route('research.index') }}">
            <i class="bi bi-journals"></i>
            <span>{{ __('Research') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->segment(1) == 'attachments' ? '' : 'collapsed'  }}" href="{{ route('attachments.index') }}">
            <i class="bi bi-paperclip"></i>
            <span>{{ __('Attachments') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->
      </ul>

    </aside><!-- End Sidebar-->