    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link {{ request()->segment(2) == 'dashboard' ? '' : 'collapsed'  }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>{{ __('sidebar.dashboard') }}</span>
          </a>
        </li><!-- End Dashboard Nav -->


        <li class="nav-item">
          <a class="nav-link {{ request()->segment(2) == 'leaves' ? '' : 'collapsed'  }}" href="{{ route('admin.leaves') }}">
            <i class="bi bi-clock-fill"></i>
            <span>{{ __('sidebar.leaves') }}</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->segment(2) == 'vacations' ? '' : 'collapsed'  }}" href="{{ route('admin.vacations') }}">
            <i class="bi bi-person-walking"></i>
            <span>{{ __('sidebar.vacations') }}</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->segment(2) == 'staff' ? '' : 'collapsed'  }}" href="{{ route('admin.staff') }}">
            <i class="bi bi-people-fill"></i>
            <span>{{ __('sidebar.staff') }}</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->segment(2) == 'iqama' ? '' : 'collapsed'  }}" href="{{ route('admin.iqama') }}">
            <i class="bi bi-people-fill"></i>
            <span>{{ __('admin/iqama.iqama') }}</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->segment(2) == 'letters' ? '' : 'collapsed'  }}" href="{{ route('admin.letters') }}">
            <i class="bi bi-people-fill"></i>
            <span>{{ __('admin/letters.letters') }}</span>
          </a>
        </li><!-- End Dashboard Nav -->


        <li class="nav-item">
          <a class="nav-link {{ request()->segment(2) == 'visas' ? '' : 'collapsed'  }}" href="{{ route('admin.visas') }}">
            <i class="bi bi-people-fill"></i>
            <span>{{ __('admin/exit-reentry.visas') }}</span>
          </a>
        </li><!-- End Dashboard Nav -->

        {{--

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('dependents.*') || request()->routeIs('acquaintances.*') || request()->routeIs('profile.*') ? '' : 'collapsed'  }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-layout-text-window-reverse"></i><span>{{ __('sidebar.personal') }}</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse {{ request()->routeIs('dependents.*') || request()->routeIs('acquaintances.*') || request()->routeIs('profile.*')? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{ route('profile.index') }}" class="{{ Request::routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>{{ __('sidebar.profile') }}</span>
              </a>
            </li>
            <li>
              <a href="{{ route('dependents.index') }}" class="{{ Request::routeIs('dependents.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>{{ __("sidebar.dependents") }}</span>
              </a>
            </li>
            <li>
              <a href="{{ route('acquaintances.index') }}" class="{{ Request::routeIs('acquaintances.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i><span>{{ __('sidebar.acquaintances') }}</span>
              </a>
            </li>
          </ul>
        </li>
        <!-- End Tables Nav -->


      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('experience.*') || request()->routeIs('other_experience.*') ? '' : 'collapsed'  }}" data-bs-target="#leaves" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-workspace"></i><span>{{ __('sidebar.experience') }}</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="leaves" class="nav-content collapse {{ request()->routeIs('experience.*') || request()->routeIs('other_experience.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('experience.index') }}" class="{{ Request::routeIs('experience.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>{{ __('sidebar.academic') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('other_experience.index') }}" class="{{ request()->routeIs('other_experience.*') ? 'active' : ''  }}" >
              <i class="bi bi-circle"></i>
              <span>{{ __('sidebar.other') }}</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->


      <li class="nav-item">
        <a class="nav-link
            {{ request()->routeIs('vacations.*') ||
            request()->routeIs('leaves.*')
            ? '' : 'collapsed'  }}"
            data-bs-target="#charts-nav"
            data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-walking"></i><span>{{ __('sidebar.leaves') }}</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse
          {{ request()->routeIs('vacations.*') ||
          request()->routeIs('leaves.*')
          ? 'show' : '' }}"
          data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('vacations.index') }}" class="{{ request()->routeIs('vacations.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>{{ __('sidebar.vacations') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('leaves.index') }}" class="{{ request()->routeIs('leaves.*') ? 'active' : ''  }}" >
              <i class="bi bi-circle"></i>
              <span>{{ __('sidebar.permissions') }}</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('visits.*') || request()->routeIs('reentry.*') || request()->routeIs('letters.*') || request()->routeIs('transportation.*') || request()->routeIs('generics.*') ? '' : 'collapsed'  }}"
          data-bs-target="#requests"
          data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-raised-hand"></i><span>{{ __('sidebar.requests') }}</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="requests" class="nav-content collapse {{ request()->routeIs('visits.*') || request()->routeIs('reentry.*') || request()->routeIs('letters.*') || request()->routeIs('transportation.*') || request()->routeIs('generics.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          @if (auth()->user()->nationality_id != 1)
            <li>
              <a href="{{ route('visits.index') }}" class="{{ request()->routeIs('visits.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i>
                <span>{{ __('sidebar.familyVisit') }}</span>
              </a>
            </li>
          @endif
          @if (auth()->user()->nationality_id != 1)
            <li>
              <a href="{{ route('reentry.index') }}" class="{{ request()->routeIs('reentry.*') ? 'active' : '' }}">
                <i class="bi bi-circle"></i>
                <span>{{ __('sidebar.reentry') }}</span>
              </a>
            </li>
          @endif
          <li>
            <a href="{{ route('letters.index') }}" class="{{ request()->routeIs('letters.*') ? 'active' : ''  }}" >
              <i class="bi bi-circle"></i>
              <span>{{ __('sidebar.letters') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('transportation.index') }}" class="{{ request()->routeIs('transportation.*') ? 'active' : ''  }}" >
              <i class="bi bi-circle"></i>
              <span>{{ __('sidebar.transportation') }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('generics.index') }}" class="{{ request()->routeIs('generics.*') ? 'active' : ''  }}" >
              <i class="bi bi-circle"></i>
              <span>{{ __('sidebar.generic') }}</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.*') || request()->routeIs('lLeave.*') || request()->routeIs('sLeave.*') ? '' : 'collapsed'  }}" data-bs-target="#head" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-bounding-box"></i><span>{{ __('sidebar.head') }}</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="head" class="nav-content collapse {{ request()->routeIs('staff.*') || request()->routeIs('lLeave.*') || request()->routeIs('sLeave.*')? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('staff.index') }}" class="{{ Request::routeIs('staff.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>{{ __("sidebar.staff") }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('sLeave.index') }}" class="{{ Request::routeIs('sLeave.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>{{ __("sidebar.permissions") }}</span>
            </a>
          </li>
          <li>
            <a href="{{ route('lLeave.index') }}" class="{{ Request::routeIs('lLeave.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>{{ __('sidebar.vacations') }}</span>
            </a>
          </li>
        </ul>
      </li>



      <li class="nav-item">
        <a class="nav-link {{ request()->segment(1) == 'faq' ? '' : 'collapsed'  }}" href="{{ route('faq') }}">
          <i class="bi bi-question-circle"></i>
          <span>{{ __('sidebar.faq') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('documents.*') ? '' : 'collapsed'  }}" href="{{ route('documents.index') }}">
          <i class="bi bi-stickies-fill"></i>
          <span>{{ __('sidebar.documents') }}</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('salary.*') ? '' : 'collapsed'  }}" href="{{ route('salary.index') }}">
          <i class="bi bi-cash-coin"></i>
          <span>{{ __('sidebar.salary') }}</span>
        </a>
      </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('qualifications.*') ? '' : 'collapsed'  }}" href="{{ route('qualifications.index') }}">
            <i class="bi bi-mortarboard-fill"></i>
            <span>{{ __('sidebar.qualifications') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('achievements.*') ? '' : 'collapsed'  }}" href="{{ route('achievements.index') }}">
            <i class="bi bi-person-arms-up"></i>
            <span>{{ __('sidebar.achievements') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('courses.*') ? '' : 'collapsed'  }}" href="{{ route('courses.index') }}">
            <i class="bi bi-trophy-fill"></i>
            <span>{{ __('sidebar.courses') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->

        @if (auth()->user()->category_id == 1)
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('research.*') ? '' : 'collapsed'  }}" href="{{ route('research.index') }}">
            <i class="bi bi-journals"></i>
            <span>{{ __('sidebar.research') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->
        @endif

        <li class="nav-item">
          <a class="nav-link {{ request()->segment(1) == 'attachments' ? '' : 'collapsed'  }}" href="{{ route('attachments.index') }}">
            <i class="bi bi-paperclip"></i>
            <span>{{ __('sidebar.attachments') }}</span>
          </a>
        </li><!-- End Profile Page Nav -->
        --}}
      </ul>

    </aside><!-- End Sidebar-->