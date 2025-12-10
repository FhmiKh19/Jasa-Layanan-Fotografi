<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 80px;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1920&h=1080&fit=crop') center/cover no-repeat;
            filter: brightness(0.5);
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.7) 0%, rgba(101, 67, 33, 0.7) 50%, rgba(62, 39, 35, 0.7) 100%);
            z-index: 1;
        }
        
        .welcome-header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
            position: relative;
            z-index: 2;
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
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
            height: 100%;
            position: relative;
            z-index: 2;
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
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
            position: relative;
            z-index: 2;
        }

        .container {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials-pelanggan.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="welcome-header">
            <h2>Selamat Datang, {{ Auth::user()->nama_pengguna }} 👋</h2>
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
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <div class="stat-number">{{ $pesananAktif }}</div>
                        <div class="stat-label">Pesanan Aktif</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-number">{{ $pesananSelesai }}</div>
                        <div class="stat-label">Pesanan Selesai</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="stat-number">{{ $menungguPembayaran }}</div>
                        <div class="stat-label">Menunggu Pembayaran</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                        <div class="stat-number">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Pengeluaran</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4" style="position: relative; z-index: 2;">
            <h3 class="section-title mb-0">Paket Layanan Fotografi</h3>
            <a href="{{ route('pelanggan.layanan.index') }}" class="btn btn-light" style="position: relative; z-index: 2;">
                <i class="fas fa-list me-2"></i>Lihat Semua
            </a>
        </div>

        @if($layananPopuler->count() > 0)
        <div class="row g-4 justify-content-center">
            @foreach($layananPopuler as $layanan)
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        @if($layanan->gambar)
                            <img src="{{ route('storage.layanan', ['filename' => $layanan->gambar]) }}?t={{ time() }}" 
                                 alt="{{ $layanan->nama_layanan }}" 
                                 onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
                        @else
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                 alt="{{ $layanan->nama_layanan }}">
                        @endif
                        <span class="category-badge" style="background: #d32f2f; color: white;">
                            <i class="fas fa-camera me-1"></i>{{ $layanan->nama_layanan }}
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">{{ $layanan->nama_layanan }}</h5>
                        <p class="photographer-desc">
                            {{ \Illuminate\Support\Str::limit($layanan->deskripsi ?? 'Layanan fotografi profesional dengan kualitas terbaik', 100) }}
                        </p>
                        <div class="price-tag">
                            Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-white" style="position: relative; z-index: 2;">
            <p class="fs-5">Belum ada layanan yang tersedia saat ini.</p>
        </div>
        @endif
    </div>

    {{-- ================== FOOTER ================== --}}
    @include('partials-pelanggan.footer')
    {{-- =========================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

