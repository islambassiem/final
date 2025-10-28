@extends('layout.master')

@section('title')
  {{ __('dashboard.gallery') }}
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
  {{ __('dashboard.gallery') }}
@endsection

@section('content')
  {{-- <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
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
      </div>
      <div class="carousel-item">
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
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div> --}}
  @php
    // Get all images from storage/gallary
    $files = collect(Storage::files('public/gallary/intellectual-awarness'))
      ->filter(fn($file) => in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
      ->values();
  @endphp

  <div class="container py-4">
    {{-- Thumbnails Grid --}}
    <div class="row g-3">
      @foreach ($files as $index => $file)
        <div class="col-6 col-md-3 col-lg-2">
          <img src="{{ asset(str_replace('public/', 'storage/', $file)) }}" class="img-thumbnail gallery-thumb"
            alt="Gallery Image {{ $index }}" data-bs-toggle="modal" data-bs-target="#imageModal" data-index="{{ $index }}">
          <div class="text-center" style="color: #5c5c5c; margin-top: 15px">{{ app()->getLocale() === 'ar' ? "منشور $index"  : "Post $index" }}</div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-dark text-white">
        <div class="modal-body text-center position-relative">
          <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2"
            data-bs-dismiss="modal"></button>
          <img id="modalImage" src="" class="img-fluid rounded" alt="">
          <button id="prevImage" class="btn btn-light position-absolute top-50 start-0 translate-middle-y ms-2">
            ‹
          </button>
          <button id="nextImage" class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-2">
            ›
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="container">
    {{-- <img src="{{ asset('storage/gallary/national_day_male.webp') }}" class="d-block w-100" alt="4">
    <img src="{{ asset('storage/gallary/national_day_female.webp') }}" class="d-block w-100" alt="4"> --}}
    {{-- <img src="{{ asset('storage/gallary/fitnessTime.webp') }}" class="d-block w-100" alt="fitnessTime"> --}}
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const images = Array.from(document.querySelectorAll('.gallery-thumb'));
      const modalImage = document.getElementById('modalImage');
      const modal = new bootstrap.Modal(document.getElementById('imageModal'));
      let currentIndex = 0;

      const showImage = (index) => {
        if (index < 0 || index >= images.length) return;
        modalImage.src = images[index].src;
        currentIndex = index;
      };

      images.forEach((img, i) => {
        img.addEventListener('click', () => showImage(i));
      });

      document.getElementById('prevImage').addEventListener('click', () => {
        showImage((currentIndex - 1 + images.length) % images.length);
      });

      document.getElementById('nextImage').addEventListener('click', () => {
        showImage((currentIndex + 1) % images.length);
      });
    });
  </script>
@endpush