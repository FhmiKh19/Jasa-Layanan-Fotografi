@extends('layouts.app')

@section('title', $judul ?? 'Dashboard Fotografer')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
<style>
  /* Hero Section */
  .hero-section {
    background: linear-gradient(135deg, rgba(62, 39, 35, 0.9), rgba(255, 213, 79, 0.8)), url('/images/hero-photo.jpg') center/cover no-repeat;
    color: #fff;
    padding: 100px 0;
    text-align: center;
    position: relative;
    border-radius: 16px;
    margin-bottom: 2rem;
  }

  .hero-section h1 {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 20px;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
  }

  .hero-section p.lead {
    font-size: 1.2rem;
    margin-bottom: 40px;
    font-weight: 400;
  }

  /* Tombol Booking */
  .btn-booking {
    background: linear-gradient(135deg, #FFD54F, #FFA726);
    color: #3E2723;
    font-weight: 600;
    padding: 14px 40px;
    font-size: 1.1rem;
    border-radius: 50px;
    border: none;
    box-shadow: 0 6px 15px rgba(255, 213, 79, 0.4);
    transition: all 0.3s ease;
  }

  .btn-booking:hover {
    background: linear-gradient(135deg, #FFA726, #FFD54F);
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 10px 25px rgba(255, 213, 79, 0.6);
    color: #3E2723;
  }

  /* Services Section */
  .service-card {
    border-radius: 12px;
    border: none;
    transition: all 0.3s ease;
    height: 100%;
  }

  .service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }

  .service-card i {
    color: #FFD54F;
  }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section" data-aos="fade-up">
  <div class="container">
    <h1>Abadikan Momen Berharga Anda</h1>
    <p class="lead">{{ $deskripsi ?? 'Website ini berisi informasi tentang layanan fotografi, galeri, dan portofolio.' }}</p>
    <a href="#" class="btn btn-booking">
      <i class="fas fa-calendar-check me-2"></i>Booking Sekarang
    </a>
  </div>
</section>

<!-- Services Section -->
<section class="mb-4">
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
      <h5 class="fw-bold mb-0">
        <i class="fas fa-list me-2"></i>Layanan Kami
      </h5>
    </div>
    <div class="card-body">
      <div class="row g-3">
        @foreach($layanan ?? [] as $item)
          <div class="col-md-3 col-sm-6">
            <div class="card service-card shadow-sm p-4 text-center">
              <i class="fas fa-camera fa-3x mb-3"></i>
              <h5 class="fw-bold">{{ $item }}</h5>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card card-stat p-3 text-center">
      <h6 class="text-muted">Total Pesanan</h6>
      <h3 class="fw-bold text-warning">12</h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-stat p-3 text-center">
      <h6 class="text-muted">Pesanan Aktif</h6>
      <h3 class="fw-bold text-primary">5</h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-stat p-3 text-center">
      <h6 class="text-muted">Rating</h6>
      <h3 class="fw-bold text-success">4.8 <i class="fas fa-star"></i></h3>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({
    duration: 1200,
    once: true
  });
</script>
@endpush
