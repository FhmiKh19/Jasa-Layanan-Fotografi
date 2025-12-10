<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
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

        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .stat-item {
            text-align: center;
            padding: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #8d5524;
        }

        .stat-label {
            color: #6b5345;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .filter-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .table-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #8d5524;
            color: white;
            border: none;
            font-weight: 600;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background: rgba(141, 85, 36, 0.1);
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials-pelanggan.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="page-header">
            <h2><i class="fas fa-shopping-bag me-2"></i>Pesanan Saya</h2>
            <p>Kelola dan pantau semua pesanan Anda</p>
        </div>

        {{-- Statistik --}}
        <div class="stats-card">
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Pesanan</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number text-warning">{{ $stats['pending'] }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number text-info">{{ $stats['diproses'] }}</div>
                        <div class="stat-label">Diproses</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number text-success">{{ $stats['selesai'] }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="filter-section">
            <form method="GET" action="{{ route('pelanggan.pesanan.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Cari Pesanan</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari berdasarkan nama layanan..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Filter Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Table Pesanan --}}
        <div class="table-card">
            @if($pesanan->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Layanan</th>
                            <th>Fotografer</th>
                            <th>Tanggal Pesanan</th>
                            <th>Tanggal Acara</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan as $p)
                        <tr>
                            <td><strong>#{{ $p->id_pesanan }}</strong></td>
                            <td>
                                <div>
                                    <strong>{{ $p->layanan->nama_layanan }}</strong>
                                </div>
                            </td>
                            <td>
                                @if($p->fotografer)
                                    {{ $p->fotografer->nama_pengguna }}
                                @else
                                    <span class="text-muted">Belum di-assign</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $p->tgl_pesanan->format('d M Y') }}</small>
                            </td>
                            <td>
                                @if($p->tgl_acara)
                                    <small>{{ \Carbon\Carbon::parse($p->tgl_acara)->format('d M Y') }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <strong>Rp {{ number_format($p->layanan->harga, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                @if($p->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($p->status === 'diproses')
                                    <span class="badge bg-info">Diproses</span>
                                @elseif($p->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status === 'pending')
                                    <a href="{{ route('pelanggan.booking.edit', $p->id_pesanan) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($pesanan->hasPages())
            <div class="mt-4">
                {{ $pesanan->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pesanan</h5>
                <p class="text-muted">Mulai booking layanan fotografi Anda sekarang!</p>
                <a href="{{ route('pelanggan.booking.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- ================== FOOTER ================== --}}
    @include('partials-pelanggan.footer')
    {{-- ============================================ --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
