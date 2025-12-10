<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Paket Layanan</title>
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
        
        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .filter-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
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
            background: #d32f2f;
            color: white;
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

        .pagination-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials-pelanggan.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="page-header">
            <h2><i class="fas fa-camera me-2"></i>Semua Paket Layanan</h2>
            <p>Pilih paket layanan fotografi yang sesuai dengan kebutuhan Anda</p>
        </div>

        {{-- Filter Section --}}
        <div class="filter-section">
            <form method="GET" action="{{ route('pelanggan.layanan.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Cari Layanan</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama atau deskripsi layanan..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Urutkan</label>
                    <select name="sort" class="form-select">
                        <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga: Terendah ke Tertinggi</option>
                        <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga: Tertinggi ke Terendah</option>
                        <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama: A-Z</option>
                        <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama: Z-A</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Layanan Grid --}}
        @if($layanan->count() > 0)
        <div class="row g-4">
            @foreach($layanan as $item)
            <div class="col-lg-4 col-md-6">
                <div class="photographer-card">
                    <div class="card-image-wrapper">
                        @if($item->gambar)
                            <img src="{{ route('storage.layanan', ['filename' => $item->gambar]) }}?t={{ time() }}" 
                                 alt="{{ $item->nama_layanan }}" 
                                 onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
                        @else
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                 alt="{{ $item->nama_layanan }}">
                        @endif
                        <span class="category-badge">
                            <i class="fas fa-camera me-1"></i>{{ $item->nama_layanan }}
                        </span>
                    </div>
                    <div class="card-body-custom">
                        <h5 class="photographer-name">{{ $item->nama_layanan }}</h5>
                        <p class="photographer-desc">
                            {{ \Illuminate\Support\Str::limit($item->deskripsi ?? 'Layanan fotografi profesional dengan kualitas terbaik', 100) }}
                        </p>
                        <div class="price-tag">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-book w-100">
                            <i class="fas fa-camera me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($layanan->hasPages())
        <div class="pagination-wrapper">
            {{ $layanan->links() }}
        </div>
        @endif
        @else
        <div class="text-center text-white" style="padding: 60px 20px;">
            <i class="fas fa-search fa-3x mb-3" style="opacity: 0.5;"></i>
            <h4>Tidak ada layanan ditemukan</h4>
            <p>Coba ubah kata kunci pencarian Anda</p>
            <a href="{{ route('pelanggan.layanan.index') }}" class="btn btn-light mt-3">
                <i class="fas fa-redo me-2"></i>Reset Pencarian
            </a>
        </div>
        @endif
    </div>

    {{-- ================== FOOTER ================== --}}
    @include('partials-pelanggan.footer')
    {{-- ============================================ --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

