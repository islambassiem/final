<div>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ request()->segment(1) == 'bylaws' ? 'active' : '' }}" href="{{ route('bylaws.index') }}">{{ __('sidebar.bylaws') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->segment(1) == 'behaviour' ? 'active' : '' }}" href="{{ route('behaviour.index') }}">{{ __('sidebar.behaviour') }}</a>
        </li>
    </ul>
</div>