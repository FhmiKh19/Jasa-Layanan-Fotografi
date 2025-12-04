<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $judul }}</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- AOS (Animate on Scroll) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
      background-color: #fffaf5;
      color: #3b2a21;
    }

    /* Navbar */
    .navbar {
      background-color: #111 !important;
    }

    .navbar-brand {
      font-weight: 700;
      color: #f1c40f !important;
    }

    .navbar-nav .nav-link {
      color: #eee !important;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: #f1c40f !important;
    }

    /* Hero Section */
    .hero-section {
      background: url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
      color: #fff;
      padding: 170px 0 150px;
      text-align: center;
      position: relative;
    }

    .hero-section::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(33, 17, 11, 0.95), rgba(121, 85, 72, 0.65));
      z-index: 0;
    }

    .hero-section .container {
      position: relative;
      z-index: 1;
    }

    .hero-section h1 {
      font-size: 3.5rem;
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
      background: linear-gradient(135deg, #6d4c41, #d7b39a);
      color: #2a1b12;
      font-weight: 600;
      padding: 14px 40px;
      font-size: 1.1rem;
      border-radius: 50px;
      border: none;
      box-shadow: 0 6px 15px rgba(241, 196, 15, 0.4);
      transition: all 0.3s ease;
    }

    .btn-booking:hover {
      background: linear-gradient(135deg, #ffb347, #ffcc33);
      transform: translateY(-4px) scale(1.05);
      box-shadow: 0 10px 25px rgba(241, 196, 15, 0.6);
    }

    /* Services Section */
    .services-section {
      padding: 80px 0;
      background: linear-gradient(135deg, #fbeee6 0%, #f3d6c1 100%);
    }

    .service-card {
      border-radius: 15px;
      border: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
      padding: 30px 20px;
      background: white;
    }

    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .service-icon {
      font-size: 3rem;
      color: #2980b9;
      margin-bottom: 20px;
    }

    .service-title {
      color: #2c3e50;
      font-weight: 700;
      margin-bottom: 15px;
      font-size: 1.5rem;
    }

    .service-description {
      color: #7f8c8d;
      line-height: 1.6;
      font-size: 0.95rem;
    }

    /* Footer */
    .footer {
      background-color: #111;
      color: #ddd;
      padding: 30px 0;
      text-align: center;
      font-size: 0.95rem;
    }

    .footer p {
      margin: 0;
    }

    .social-icons a {
      color: #f1c40f;
      margin: 0 10px;
      font-size: 1.4rem;
      transition: transform 0.3s ease, color 0.3s ease;
    }

    .social-icons a:hover {
      color: #fff;
      transform: scale(1.2);
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(120deg, #1f1c2c, #928dab); box-shadow: 0 8px 30px rgba(0,0,0,0.2);">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('login.form') }}">FotoFreelance</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item me-lg-3">
            <a class="nav-link text-white fw-semibold" href="{{ route('login.form') }}"><i class="fas fa-home me-1"></i>Home</a>
          </li>
          <li class="nav-item me-lg-3">
            <a class="nav-link text-white fw-semibold" href="{{ route('booking.create') }}"><i class="fas fa-calendar-plus me-1"></i>Booking</a>
          </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-sm btn-light fw-semibold"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container" data-aos="fade-up">
      <h1>Abadikan Momen Berharga Anda</h1>
      <p class="lead">{{ $deskripsi }}</p>
      <a href="{{ route('booking.create') }}" class="btn btn-booking">Booking Sekarang</a>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services-section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="display-4 fw-bold mb-3" style="color: #2c3e50;">Jenis Layanan Fotografi</h2>
        <p class="lead text-muted">Kami menyediakan berbagai layanan fotografi profesional untuk kebutuhan Anda</p>
      </div>
      
      <div class="row g-4">
        @foreach($layanan as $item)
          <div class="col-md-6 col-lg-3 mb-4">
            <div class="service-card shadow text-center">
              <i class="fa {{ $item['icon'] }} service-icon"></i>
              <h4 class="service-title text-uppercase">{{ $item['nama'] }}</h4>
              <p class="service-description">{{ $item['deskripsi'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container" data-aos="fade-up">
      <p>&copy; {{ date('Y') }} Jasa Layanan Fotografi Freelance. All Rights Reserved.</p>
      <div class="social-icons mt-2">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </footer>

  {{--Java Script --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 1200,
      once: true
    });
  </script>
</body>
</html>
