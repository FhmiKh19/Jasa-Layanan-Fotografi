<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kastamer - Jasa Fotografi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3cCe-6FctDtURN2U3VtZfPZIZdZQ4EEhy7Q&s") center/cover no-repeat fixed;
            position: relative;
            min-height: 100vh;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(20, 8, 4, 0.75);
            backdrop-filter: blur(3px);
            z-index: 0;
        }

        .info-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white !important;
            color: #333 !important;
            border: none;
            font-weight: 600;
            z-index: 999;
        }

        .google-btn {
            position: fixed;
            top: 20px;
            right: 180px;
            background: white !important;
            color: #333 !important;
            border: none;
            font-weight: 600;
            z-index: 999;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .google-btn:hover {
            background: white !important;
            color: #333 !important;
        }

        @media (max-width: 768px) {
            .google-btn {
                right: 20px;
                top: 70px;
            }
        }

        .welcome-banner {
            max-width: 960px;
            margin: 80px auto 20px;
            background: rgba(26, 12, 7, 0.75);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 24px;
            padding: 32px 40px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.35);
            backdrop-filter: blur(6px);
            position: relative;
            z-index: 1;
        }

        .welcome-text {
            text-align: center;
            margin: 0;
            color: #f7f0e8;
            text-shadow: 0 8px 25px rgba(0,0,0,0.55);
            font-size: 36px;
            letter-spacing: 1px;
            font-weight: 700;
            text-transform: uppercase;
            animation: fadeDown 0.8s ease-in-out;
            position: relative;
            z-index: 1;
        }

        .welcome-subtitle {
            max-width: 720px;
            margin: 20px auto 0;
            color: #f7f0e8;
            text-align: center;
            font-size: 1rem;
            letter-spacing: 0.5px;
            line-height: 1.7;
            text-shadow: 0 6px 20px rgba(0,0,0,0.5);
            position: relative;
            z-index: 1;
        }

        .login-wrap {
            width: 100%;
            display: flex;
            justify-content: center;
            padding-top: 150px;
            padding-bottom: 60px;
            position: relative;
            z-index: 1;
        }

        .login-box {
            background: rgba(255,255,255,0.95);
            padding: 35px;
            border-radius: 18px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.35);
            animation: fadeDown 0.8s ease;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,0.4);
        }

        .login-box .form-control {
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #d5c1b4;
        }

        .login-box .form-control:focus {
            border-color: #a46b43;
            box-shadow: 0 0 0 0.2rem rgba(164, 107, 67, 0.25);
        }

        .btn-custom {
            background: linear-gradient(120deg, #8d5524, #c08552);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 18px rgba(141, 85, 36, 0.35);
        }

        .info-grid {
            position: relative;
            z-index: 1;
            margin-top: -30px;
        }

        .info-card {
            background: rgba(255,250,245,0.95);
            border-radius: 18px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 30px 60px rgba(0,0,0,0.18);
            border: 1px solid rgba(255,255,255,0.4);
            color: #3b261b;
        }

        .info-card p {
            color: #6b5345;
        }

        .info-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            background: linear-gradient(120deg, #5c3d2e, #a7745b);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .info-section {
            width: 100%;
            background: #ffffff;
            color: #2c1810;
            padding: 60px 5%;
            margin-top: 80px;
            position: relative;
            z-index: 1;
        }

        .info-box {
            max-width: 1200px;
            margin: auto;
            padding: 50px;
            border-radius: 24px;
            border: 2px solid #e8ddd4;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }

        .info-chip {
            background: #ffffff;
            border-radius: 16px;
            padding: 25px;
            height: 100%;
            border: 2px solid #f0e6dc;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        }

        .info-chip i {
            font-size: 1.4rem;
            margin-right: 10px;
            color: #8d5524;
        }

        .info-section h3 {
            color: #2c1810;
            font-weight: 700;
        }

        .info-section .text-warning {
            color: #8d5524 !important;
            font-weight: 600;
        }

        .info-chip .text-dark {
            color: #2c1810 !important;
            font-weight: 600;
        }

        .info-chip .text-secondary {
            color: #5c3d2e !important;
        }

        .info-chip ul li {
            color: #5c3d2e;
            margin-bottom: 8px;
        }

        /* Style untuk fotografer di halaman login */
        .photographer-card-login {
            text-align: center;
            transition: transform 0.3s ease;
        }

        .photographer-card-login:hover {
            transform: translateY(-5px);
        }

        .photographer-photo-wrapper {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #8d5524;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .photographer-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photographer-types {
            margin-top: 15px;
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .badge-type {
            background: linear-gradient(120deg, #8d5524, #c08552);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <a href="{{ route('redirect.google') }}" class="btn google-btn">
        <i class="fab fa-google"></i> Login dengan Google
    </a>
    <a href="#informasi" class="btn btn-light info-btn">Lihat Informasi</a>

    <div class="welcome-banner">
        <h1 class="welcome-text">Selamat Datang di Jasa Layanan Fotografi Profesional</h1>
        <p class="welcome-subtitle">
            Kami hadir dengan sentuhan editorial premium, layanan concierge, dan hasil foto bernuansa cokelat elegan untuk setiap momen istimewa Anda.
        </p>
    </div>

    <div class="login-wrap">
        <div class="login-box text-center">
            <h3 class="mb-4" style="color:#2980b9;">LOGIN AKUN </h3>

            @if (session('success'))
                <div class="alert alert-success text-start">{{ session('success') }}</div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger text-start">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="mb-3 text-start">
                    <label class="form-label">Nomor Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-phone text-muted"></i></span>
                        <input type="tel" name="telepon" class="form-control border-start-0" placeholder="Masukkan nomor telepon" value="{{ old('telepon') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan password" required>
                    </div>
                </div>

                <!-- tombol login -->
                <button type="submit" class="btn btn-custom w-100 text-white mb-3">Masuk</button>

                <!-- tombol buat akun -->
                            <a href="{{ route('register.form') }}" class="btn w-100"
                style="border:2px solid #2980b9; color:#2980b9; font-weight:600; border-radius:8px;">
                Buat Akun
                </a>
            </form>
        </div>
    </div>

    {{-- SECTION FOTOGRAFER --}}
    <div class="container info-grid" style="margin-top: 40px;">
        <h3 class="text-center mb-4" style="color: #f7f0e8; text-shadow: 0 4px 15px rgba(0,0,0,0.5); font-weight: 700; position: relative; z-index: 1;">Tim Fotografer Profesional</h3>
        <div class="row g-4 justify-content-center">
            @foreach($fotografers as $fotografer)
            <div class="col-md-4">
                <div class="info-card photographer-card-login">
                    <div class="photographer-photo-wrapper">
                        <img src="{{ $fotografer['foto'] }}" alt="{{ $fotografer['nama'] }}" class="photographer-photo">
                    </div>
                    <h5 class="fw-bold mb-2 mt-3" style="color: #3b261b;">{{ $fotografer['nama'] }}</h5>
                    <p class="text-muted mb-2">
                        <i class="fas fa-phone me-2" style="color: #8d5524;"></i>{{ $fotografer['telepon'] }}
                    </p>
                    <div class="photographer-types">
                        @foreach($fotografer['jenis'] as $jenis)
                        <span class="badge-type">{{ $jenis }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container info-grid">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-gem"></i></div>
                    <h5 class="fw-bold mb-2">Premium Touch</h5>
                    <p class="text-muted mb-0">Konsep editorial, lighting sinematik, dan kurasi warna artisan untuk hasil sekelas brand besar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-shield-heart"></i></div>
                    <h5 class="fw-bold mb-2">Full Concierge</h5>
                    <p class="text-muted mb-0">Personal stylist & art director siap membantu dari konsep hingga penyerahan arsip akhir.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-clock"></i></div>
                    <h5 class="fw-bold mb-2">Express Delivery</h5>
                    <p class="text-muted mb-0">Preview 24 jam, finalisasi album 3 hari kerja dengan retouch signature tone cokelat.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="informasi" class="info-section">
        <div class="info-box text-center">
            <p class="text-uppercase text-warning fw-semibold mb-2">Our Studio</p>
            <h3 class="mb-3 text-dark">Jl. Cendana No. 18, Jakarta Selatan</h3>
            <p class="mb-4 lead text-secondary">Reservasi privat bernuansa earthy luxury dengan aroma cedarwood dan lounge artisan coffee untuk brief eksklusif.</p>
            <div class="row g-4 text-start mt-1">
                <div class="col-lg-4">
                    <div class="info-chip">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-headset"></i>
                            <span class="fw-semibold text-uppercase small text-dark">Kontak Concierge</span>
                        </div>
                        <p class="mb-1 text-secondary">WhatsApp: 0812-3456-7890</p>
                        <p class="mb-0 text-secondary">Email: concierge@fotofreelance.id</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-chip">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-star"></i>
                            <span class="fw-semibold text-uppercase small text-dark">Highlight</span>
                        </div>
                        <ul class="ps-3 mb-0 text-secondary">
                            <li>Wedding & engagement editorial</li>
                            <li>Corporate / campaign visual</li>
                            <li>Wisuda & keluarga signature tone</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-chip">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock"></i>
                            <span class="fw-semibold text-uppercase small text-dark">Jam Operasional</span>
                        </div>
                        <p class="mb-1 text-secondary">Senin - Jumat : 09.00 - 21.00</p>
                        <p class="mb-0 text-secondary">Sabtu - Minggu : 08.00 - 23.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
