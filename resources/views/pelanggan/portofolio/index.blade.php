<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio Fotografer</title>
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
        
        .container {
            position: relative;
            z-index: 2;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }
        
        .page-header h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .filter-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .category-btn {
            background: white;
            border: 2px solid #e9ecef;
            color: #333;
            padding: 8px 20px;
            border-radius: 25px;
            margin: 5px;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .category-btn:hover {
            border-color: #8d5524;
            color: #8d5524;
            transform: translateY(-2px);
        }

        .category-btn.active {
            background: linear-gradient(135deg, #8d5524, #c08552);
            border-color: #8d5524;
            color: white;
        }

        .category-btn.disabled {
            background: #f5f5f5;
            border-color: #e0e0e0;
            color: #999;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .category-btn.disabled:hover {
            transform: none;
            border-color: #e0e0e0;
            color: #999;
        }

        .portfolio-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transition: all 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .portfolio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.3);
        }

        .portfolio-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
        }

        .portfolio-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .portfolio-category {
            display: inline-block;
            background: linear-gradient(135deg, #8d5524, #c08552);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .portfolio-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 10px;
        }

        .portfolio-description {
            color: #666;
            font-size: 0.9rem;
            flex: 1;
            margin-bottom: 15px;
        }

        .portfolio-date {
            color: #999;
            font-size: 0.85rem;
            margin-top: auto;
        }

        .portfolio-photographer {
            color: #8d5524;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials-pelanggan.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="page-header">
            <h2><i class="fas fa-images me-2"></i>Portofolio Fotografer</h2>
            <p>Lihat karya terbaik dari fotografer profesional kami</p>
        </div>

        {{-- Filter Section --}}
        <div class="filter-section">
            <form method="GET" action="{{ route('pelanggan.portofolio.index') }}" id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold mb-2">Kategori</label>
                        <div>
                            <a href="{{ route('pelanggan.portofolio.index', ['search' => request('search')]) }}" 
                               class="category-btn {{ !request('kategori') || request('kategori') == 'semua' ? 'active' : '' }}">
                                Semua ({{ $kategoriCounts['semua'] ?? $portofolios->total() }})
                            </a>
                            @foreach($kategoris as $kategori)
                                @php
                                    $count = $kategoriCounts[$kategori] ?? 0;
                                    $canClick = $count > 1;
                                @endphp
                                @if($canClick)
                                    <a href="{{ route('pelanggan.portofolio.index', ['kategori' => $kategori, 'search' => request('search')]) }}" 
                                       class="category-btn {{ request('kategori') == $kategori ? 'active' : '' }}">
                                        {{ $kategori }} ({{ $count }})
                                    </a>
                                @else
                                    <span class="category-btn disabled" title="Kategori ini hanya memiliki 1 portofolio">
                                        {{ $kategori }} ({{ $count }})
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold mb-2">Cari</label>
                        <div class="input-group">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Cari portofolio..." 
                                   value="{{ request('search') }}"
                                   style="border-radius: 25px 0 0 25px;">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #8d5524, #c08552); color: white; border-radius: 0 25px 25px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Portfolio Grid --}}
        @if($portofolios->count() > 0)
        <div class="row g-4">
            @foreach($portofolios as $portfolio)
            <div class="col-md-4 col-lg-3">
                <div class="portfolio-card">
                    @if($portfolio->gambar)
                        <img src="{{ route('storage.portfolio', ['filename' => $portfolio->gambar]) }}?t={{ time() }}" 
                             alt="{{ $portfolio->judul }}" 
                             class="portfolio-image"
                             onerror="this.src='https://via.placeholder.com/400x250?text=No+Image'">
                    @else
                        <div class="portfolio-image d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="portfolio-body">
                        @if($portfolio->kategori)
                            <span class="portfolio-category">{{ $portfolio->kategori }}</span>
                        @endif
                        <h5 class="portfolio-title">{{ $portfolio->judul }}</h5>
                        <p class="portfolio-description">
                            {{ \Illuminate\Support\Str::limit($portfolio->deskripsi ?? 'Tidak ada deskripsi', 100) }}
                        </p>
                        <div class="mt-auto">
                            <div class="portfolio-date mb-2">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $portfolio->tgl_dibuat->format('d M Y') }}
                            </div>
                            @if($portfolio->fotografer)
                            <div class="portfolio-photographer">
                                <i class="fas fa-camera me-1"></i>
                                {{ $portfolio->fotografer->nama_pengguna }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $portofolios->links() }}
        </div>
        @else
        <div class="text-center text-white" style="padding: 60px 20px;">
            <i class="fas fa-images fa-3x mb-3" style="opacity: 0.5;"></i>
            <h4>Belum ada portofolio</h4>
            <p>Portofolio akan muncul di sini setelah fotografer mengupload karya mereka</p>
        </div>
        @endif
    </div>

    {{-- ================== FOOTER ================== --}}
    @include('partials-pelanggan.footer')
    {{-- ============================================ --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

