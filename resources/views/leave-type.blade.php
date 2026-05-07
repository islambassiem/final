@extends('layout.master')

@section('breadcrumb')
    {{ __('leaves.vacationTypes') }}
@endsection

@section('style')
    <style>
        .card:hover {
            background-color: #c5c1c1;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('leaves.index') }}">
                <div class="card">
                    <div class="card-body mt-4">
                        <input type="radio" data-link="{{ route('leaves.index') }}">
                        {{ __('leaves.ComingLate') }}
                    </div>
                </div>
            </a>
            <a href="{{ route('leaves.index') }}">
                <div class="card">
                    <div class="card-body mt-4">
                        <input type="radio" data-link="{{ route('leaves.index') }}">
                        {{ __('leaves.LeavingEarly') }}
                    </div>
                </div>
            </a>
            <a href="{{ route('leaves.index') }}">
                <div class="card">
                    <div class="card-body mt-4">
                        <input type="radio" data-link="{{ route('leaves.index') }}">
                        {{ __('leaves.LeavingDuringTheDay') }}
                    </div>
                </div>
            </a>
            <a href="{{ route('vacations.index') }}">
                <div class="card">
                    <div class="card-body mt-4">
                        <input type="radio" data-link="{{ route('vacations.index') }}">
                        {{ __('leaves.NotComingToWorkForTheWholeDay') }}
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const input = document.getElementsByTagName('input');
        for (let i = 0; i < input.length; i++) {
            input[i].addEventListener('click', function () {
                window.location.href = this.getAttribute('data-link');
            });
        }
    </script>
@endsection