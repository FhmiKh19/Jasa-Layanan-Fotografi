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
      background-color: #fdfdfd;
      color: #222;
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
      background: url('/images/hero-photo.jpg') center/cover no-repeat;
      color: #fff;
      padding: 160px 0 140px;
      text-align: center;
      position: relative;
    }

    .hero-section::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.75), rgba(241, 196, 15, 0.55));
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
      background: linear-gradient(135deg, #f1c40f, #ff9800);
      color: #111;
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
    .card {
      border-radius: 12px;
      border: none;
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
  <nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="#">FotoFreelance</a>
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Layanan</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Portofolio</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container" data-aos="fade-up">
      <h1>Abadikan Momen Berharga Anda</h1>
      <p class="lead">{{ $deskripsi }}</p>
      <a href="#" class="btn btn-booking">Booking Sekarang</a>
    </div>
  </section>

  <!-- Services Section -->
  <section class="py-5 text-center">
    <div class="container">
      <h2 class="mb-4">Layanan Kami</h2>
      <div class="row justify-content-center">
        @foreach($layanan as $item)
          <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3">
              <i class="fa fa-camera fa-2x mb-2 text-warning"></i>
              <h5>{{ $item }}</h5>
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

  <!-- JS -->
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
