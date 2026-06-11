@extends('layout.master')

@section('title')
    {{ __('attachments.attachments') }}
@endsection

@section('style')
    <style>
        nav {
            display: flex;
            gap: 10px;
            font-size: 1.2rem;
        }

        nav a {
            color: #444;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 6px;
            transition: 0.2s ease;
        }

        nav a:hover {
            background: #f0f0f0;
        }

        nav a.active-link {
            background: #007bff;
            color: white;
        }

        nav a:focus-visible {
            outline: 2px solid #007bff;
        }
    </style>
@endsection

@section('h1')
    {{ __('sidebar.bylaws') }}
@endsection

@section('breadcrumb')
    {{ __('sidebar.bylaws') }}
@endsection

@section('content')
<div class="row">
    <!-- Sidebar -->
    <div class="col-12 col-md-2 mb-3 mb-md-0">
        <nav class="d-flex flex-md-column flex-row flex-wrap gap-2">
            <a class="{{ request()->segment(2) == 'bylaws' ? 'active-link' : '' }}"
               href="{{ route('bylaws.index') }}">
                {{ __('sidebar.executive_regulations') }}
            </a>

            <a class="{{ request()->segment(2) == 'anti-smoking_regulations' ? 'active-link' : '' }}"
               href="{{ route('bylaws.anti-smoking_regulations') }}">
                {{ __('sidebar.anti-smoking') }}
            </a>

            <a class="{{ request()->segment(2) == 'buildings_regulations' ? 'active-link' : '' }}"
               href="{{ route('bylaws.buildings_regulations') }}">
                {{ __('sidebar.buildings_regulations') }}
            </a>

            <a class="{{ request()->segment(2) == 'dress_code_regulations' ? 'active-link' : '' }}"
               href="{{ route('bylaws.dress_code_regulations') }}">
                {{ __('sidebar.dress_code_regulations') }}
            </a>

            <a class="{{ request()->segment(2) == 'emergency_ethics_policy' ? 'active-link' : '' }}"
               href="{{ route('bylaws.emergency_ethics_policy') }}">
                {{ __('sidebar.emergency_ethics_policy') }}
            </a>

            <a class="{{ request()->segment(2) == 'internal_communication_regulations' ? 'active-link' : '' }}"
               href="{{ route('bylaws.internal_communication_regulations') }}">
                {{ __('sidebar.internal_communication_regulations') }}
            </a>

            <a class="{{ request()->segment(2) == 'maintenance_regulation' ? 'active-link' : '' }}"
               href="{{ route('bylaws.maintenance_regulation') }}">
                {{ __('sidebar.maintenance_regulation') }}
            </a>

            <a class="{{ request()->segment(2) == 'marketing_and_public_relations_regulations' ? 'active-link' : '' }}"
               href="{{ route('bylaws.marketing_and_public_relations_regulations') }}">
                {{ __('sidebar.marketing_and_public_relations_regulations') }}
            </a>

            <a class="{{ request()->segment(2) == 'procurement_egulations' ? 'active-link' : '' }}"
               href="{{ route('bylaws.procurement_egulations') }}">
                {{ __('sidebar.procurement_egulations') }}
            </a>

            <a class="{{ request()->segment(2) == 'use_of_transportation_regulations' ? 'active-link' : '' }}"
               href="{{ route('bylaws.use_of_transportation_regulations') }}">
                {{ __('sidebar.use_of_transportation_regulations') }}
            </a>
        </nav>
    </div>

    <!-- Content -->
    <div class="col-12 col-md-10">
        @yield('embed', 'No Document Found')
    </div>
</div>
@endsection