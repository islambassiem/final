@extends('layout.master')

@section('title')
    {{ __('dashboard.gallary') }}
@endsection

@section('style')
    <style>
        img {
            /*
            display: block;
            max-width: 500px;
            max-height: 750px;
            width: auto;
            height: auto;
             */
        }

        #container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
    </style>
@endsection

@section('breadcrumb')
    {{ __('dashboard.gallary') }}
@endsection

@section('content')
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            {{-- <div class="carousel-item active">
                <img src="{{ asset('storage/gallary/0.webp') }}" class="d-block w-100" alt="0">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/1.webp') }}" class="d-block w-100" alt="1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/2.webp') }}" class="d-block w-100" alt="2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/3.webp') }}" class="d-block w-100" alt="3">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/4.webp') }}" class="d-block w-100" alt="4">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/5.webp') }}" class="d-block w-100" alt="5">
            </div> --}}
            <div class="carousel-item active">
                <img src="{{ asset('storage/gallary/6.webp') }}" class="d-block w-100" alt="6">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/7.webp') }}" class="d-block w-100" alt="7">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/8.webp') }}" class="d-block w-100" alt="8">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/9.webp') }}" class="d-block w-100" alt="9">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/10.webp') }}" class="d-block w-100" alt="10">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/11.webp') }}" class="d-block w-100" alt="11">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/12.webp') }}" class="d-block w-100" alt="12">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('storage/gallary/13.webp') }}" class="d-block w-100" alt="13">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div id="container">
        {{-- <img src="{{ asset('storage/gallary/national_day_male.webp') }}" class="d-block w-100" alt="4">
        <img src="{{ asset('storage/gallary/national_day_female.webp') }}" class="d-block w-100" alt="4"> --}}
        {{-- <img src="{{ asset('storage/gallary/fitnessTime.webp') }}" class="d-block w-100" alt="fitnessTime"> --}}
    </div>
@endsection
