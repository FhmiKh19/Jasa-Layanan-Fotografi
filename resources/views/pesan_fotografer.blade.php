<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Fotografer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #3e2723 0%, #6d4c41 60%, #a1887f 100%);
            min-height: 100vh;
            padding: 50px 0 80px;
            font-family: 'Poppins', sans-serif;
        }
        
        .welcome-header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }
        
        .welcome-header h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .welcome-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .stats-section {
            margin-bottom: 50px;
        }

        .stat-card {
            background: rgba(255,255,255,0.95);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: #8d5524;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #3e2723;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6b5345;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .photographer-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .photographer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .card-image-wrapper {
            position: relative;
            height: 280px;
            overflow: hidden;
        }
        
        .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .photographer-card:hover .card-image-wrapper img {
            transform: scale(1.1);
        }
        
        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        .card-body-custom {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .photographer-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3e2723;
            margin-bottom: 12px;
        }
        
        .photographer-desc {
            color: #6b5345;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
            flex-grow: 1;
        }
        
        .photographer-features {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }
        
        .photographer-features li {
            padding: 6px 0;
            color: #5c3d2e;
            font-size: 0.9rem;
        }
        
        .photographer-features li i {
            color: #8d5524;
            margin-right: 8px;
            width: 18px;
        }
        
        .price-tag {
            background: linear-gradient(135deg, #8d5524, #c08552);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            margin: 20px 0 15px;
            box-shadow: 0 4px 15px rgba(141, 85, 36, 0.3);
        }
        
        .btn-book {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }
        
        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
            color: white;
        }
        
        .alert-success {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            text-align: center;
            color: white;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 40px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="welcome-header">
            <h2>Selamat Datang, {{ $nama }} 👋</h2>
            <p>Silakan pilih fotografer sesuai kebutuhan Anda</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-auto" style="max-width: 800px;" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- STATISTIK SECTION --}}
        <div class="stats-section">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Klien Puas</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-camera"></i></div>
                        <div class="stat-number">2000+</div>
                        <div class="stat-label">Foto Terpilih</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-star"></i></div>
                        <div class="stat-number">4.9</div>
                        <div class="stat-label">Rating Rata-rata</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-award"></i></div>
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Tahun Pengalaman</div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="section-title">Pilih Fotografer Profesional</h3>

        <div class="row g-4 justify-content-center">
            
            <!-- Fotografer Wedding -->
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fotografer Wedding">
                        <span class="category-badge" style="background: #d32f2f; color: white;">
                            <i class="fas fa-heart me-1"></i>Wedding
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">Fotografer Wedding</h5>
                        <p class="photographer-desc">
                            Spesialis dokumentasi pernikahan dengan konsep editorial premium. Menangkap setiap momen berharga dengan gaya sinematik dan nuansa cokelat elegan.
                        </p>
                        <ul class="photographer-features">
                            <li><i class="fas fa-check-circle"></i>Full day coverage (8-12 jam)</li>
                            <li><i class="fas fa-check-circle"></i>Pre-wedding & engagement</li>
                            <li><i class="fas fa-check-circle"></i>Album premium & digital gallery</li>
                            <li><i class="fas fa-check-circle"></i>Retouch signature tone</li>
                        </ul>
                        <div class="price-tag">
                            Mulai dari Rp 1.500.000
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Fotografer Wisuda -->
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fotografer Wisuda">
                        <span class="category-badge" style="background: #f57c00; color: white;">
                            <i class="fas fa-graduation-cap me-1"></i>Wisuda
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">Fotografer Wisuda</h5>
                        <p class="photographer-desc">
                            Dokumentasi momen kelulusan yang berkesan. Menangkap kebahagiaan dan kebanggaan dengan gaya modern dan hasil yang elegan.
                        </p>
                        <ul class="photographer-features">
                            <li><i class="fas fa-check-circle"></i>Indoor & outdoor session</li>
                            <li><i class="fas fa-check-circle"></i>Foto individu & grup</li>
                            <li><i class="fas fa-check-circle"></i>Quick edit & delivery</li>
                            <li><i class="fas fa-check-circle"></i>Digital gallery HD</li>
                        </ul>
                        <div class="price-tag">
                            Mulai dari Rp 750.000
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Fotografer Keluarga & Studio -->
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1511895426328-dc8714191300?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fotografer Keluarga">
                        <span class="category-badge" style="background: #1976d2; color: white;">
                            <i class="fas fa-users me-1"></i>Keluarga & Studio
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">Fotografer Keluarga</h5>
                        <p class="photographer-desc">
                            Spesialis foto keluarga, produk, dan studio photography. Menciptakan momen hangat dengan hasil berkualitas profesional.
                        </p>
                        <ul class="photographer-features">
                            <li><i class="fas fa-check-circle"></i>Family portrait session</li>
                            <li><i class="fas fa-check-circle"></i>Product photography</li>
                            <li><i class="fas fa-check-circle"></i>Studio & outdoor</li>
                            <li><i class="fas fa-check-circle"></i>Professional retouch</li>
                        </ul>
                        <div class="price-tag">
                            Mulai dari Rp 950.000
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Fotografer Event -->
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fotografer Event">
                        <span class="category-badge" style="background: #7b1fa2; color: white;">
                            <i class="fas fa-calendar-alt me-1"></i>Event
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">Fotografer Event</h5>
                        <p class="photographer-desc">
                            Dokumentasi acara perusahaan, seminar, konferensi, dan event lainnya. Menangkap momen penting dengan profesional dan dinamis.
                        </p>
                        <ul class="photographer-features">
                            <li><i class="fas fa-check-circle"></i>Corporate event coverage</li>
                            <li><i class="fas fa-check-circle"></i>Seminar & konferensi</li>
                            <li><i class="fas fa-check-circle"></i>Live documentation</li>
                            <li><i class="fas fa-check-circle"></i>Same day preview</li>
                        </ul>
                        <div class="price-tag">
                            Mulai dari Rp 1.200.000
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Fotografer Corporate -->
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fotografer Corporate">
                        <span class="category-badge" style="background: #0288d1; color: white;">
                            <i class="fas fa-briefcase me-1"></i>Corporate
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">Fotografer Corporate</h5>
                        <p class="photographer-desc">
                            Spesialis fotografi corporate untuk kebutuhan bisnis, branding, dan dokumentasi profesional. Menciptakan visual yang powerful untuk perusahaan Anda.
                        </p>
                        <ul class="photographer-features">
                            <li><i class="fas fa-check-circle"></i>Corporate portrait & headshot</li>
                            <li><i class="fas fa-check-circle"></i>Branding photography</li>
                            <li><i class="fas fa-check-circle"></i>Office & workspace</li>
                            <li><i class="fas fa-check-circle"></i>Professional retouch</li>
                        </ul>
                        <div class="price-tag">
                            Mulai dari Rp 1.100.000
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Fotografer Pre-Wedding -->
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fotografer Pre-Wedding">
                        <span class="category-badge" style="background: #e91e63; color: white;">
                            <i class="fas fa-heart me-1"></i>Pre-Wedding
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">Fotografer Pre-Wedding</h5>
                        <p class="photographer-desc">
                            Dokumentasi romantis sebelum pernikahan dengan konsep editorial dan lokasi eksklusif. Menciptakan momen indah yang abadi.
                        </p>
                        <ul class="photographer-features">
                            <li><i class="fas fa-check-circle"></i>Outdoor & indoor session</li>
                            <li><i class="fas fa-check-circle"></i>Multiple location</li>
                            <li><i class="fas fa-check-circle"></i>Editorial style</li>
                            <li><i class="fas fa-check-circle"></i>Album & digital gallery</li>
                        </ul>
                        <div class="price-tag">
                            Mulai dari Rp 1.300.000
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
