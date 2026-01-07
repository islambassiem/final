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

    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

    .modal-backdrop.show {
      opacity: 0.8;
    }

    .congratulations-modal .modal-content {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header-custom {
      background: linear-gradient(135deg, #4a90e2 0%, #5ba3f5 50%, #a8d5ff 100%);
      padding: 40px 30px;
      position: relative;
      border: none;
    }

    .modal-header-custom::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(120deg, transparent 48%, rgba(255, 255, 255, 0.1) 50%, transparent 52%),
        linear-gradient(240deg, transparent 48%, rgba(255, 255, 255, 0.05) 50%, transparent 52%);
    }

    .ksu-logo {
      position: absolute;
      top: 20px;
      left: 20px;
      background: white;
      padding: 10px 15px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
    }

    .ksu-logo-text {
      color: #0066cc;
      font-weight: 700;
      font-size: 14px;
      margin: 0;
      line-height: 1.2;
    }

    .ksu-logo-subtext {
      color: #666;
      font-size: 11px;
      margin: 0;
    }

    .congratulations-icon {
      text-align: center;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .logo{
      max-width: 100px;
      max-height: 100px;
      margin-right: auto;
      margin-left: auto;
      position: relative;
      z-index: 100;
      left: 45%;
    }

    .congratulations-text {
      font-size: 48px;
      font-weight: 700;
      color: #0066cc;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
      margin: 0;
      font-family: 'Cairo', sans-serif;
    }

    .modal-body-custom {
      padding: 40px;
      background: white;
      text-align: center;
    }

    .announcement-title {
      font-size: 22px;
      font-weight: 600;
      color: #0066cc;
      margin-bottom: 15px;
      line-height: 1.8;
      font-family: 'Cairo', sans-serif;
    }

    .doctor-name {
      font-size: 26px;
      font-weight: 700;
      color: #2c5aa0;
      margin: 20px 0;
      font-family: 'Cairo', sans-serif;
    }

    .promotion-text {
      font-size: 20px;
      font-weight: 600;
      color: #333;
      margin-bottom: 30px;
      font-family: 'Cairo', sans-serif;
    }

    .wishes-text {
      font-size: 18px;
      color: #555;
      margin: 25px 0;
      font-weight: 500;
      font-family: 'Cairo', sans-serif;
    }

    .department-info {
      margin-top: 35px;
      padding-top: 25px;
      border-top: 2px solid #e0e0e0;
    }

    .department-name {
      font-size: 14px;
      color: #666;
      margin-bottom: 5px;
    }

    .department-english {
      font-size: 13px;
      color: #888;
      font-style: italic;
    }

    .close-btn-custom {
      position: absolute;
      top: 15px;
      right: 15px;
      background: white;
      border: none;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      font-size: 20px;
      color: #666;
      cursor: pointer;
      z-index: 10;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      transition: all 0.3s;
    }

    .close-btn-custom:hover {
      background: #f0f0f0;
      transform: rotate(90deg);
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


  {{-- Congratulations Modal --}}
  <div class="modal fade congratulations-modal" id="congratulationsModal" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header-custom">
          <button type="button" class="close-btn-custom" data-bs-dismiss="modal" aria-label="Close">
            ×
          </button>

          <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo">

          <div class="ksu-logo">
            <p class="ksu-logo-text">كليات العناية الطبية</p>
            <p class="ksu-logo-text">Inaya Medical College</p>
          </div>

          <div class="congratulations-icon">
            <p class="congratulations-text">🎊 تهنئة 🎊</p>
          </div>
        </div>

        <div class="modal-body-custom">
          <p class="announcement-title">
            يسر إدارة الموارد البشرية
          </p>

          <p class="doctor-name">
            تهنئة سعادة الدكتورة /    مريم خليف دبوس الشمري
          </p>

          <p class="promotion-text">
            بمناسبة تجديد تكليفها كرئيس للسنة الأولى المشتركة
          </p>

          <p class="wishes-text">
            سائلين المولى–عز وجل– لها التوفيق والسداد
          </p>

          <div class="department-info">
            <p class="department-name">
                 إدارة الموارد البشرية -    كليات العناية الطبية
            </p>
            <p class="department-english">
              Human Resources Department - Inaya Medical Colleges.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  {{-- Gallery Content --}}
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
          <img src="{{ asset(str_replace('public/', 'storage/', $file . '?v=20260107')) }}" class="img-thumbnail gallery-thumb"
            alt="Gallery Image {{ $index }}" data-bs-toggle="modal" data-bs-target="#imageModal" data-index="{{ $index }}">
          <div class="text-center" style="color: #5c5c5c; margin-top: 15px">{{ app()->getLocale() === 'ar' ? "منشور $index"  : "Post $index" }}</div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Image Viewer Modal --}}
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
      // Gallery functionality
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

      // Show congratulations modal on page load
      const congratsModal = new bootstrap.Modal(document.getElementById('congratulationsModal'));
      //congratsModal.show();
    });
  </script>
@endpush