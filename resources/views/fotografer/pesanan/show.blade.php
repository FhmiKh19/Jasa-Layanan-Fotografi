@extends('layouts-fotografer.corona')

@section('title', 'Detail Pesanan')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Detail Pesanan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.pesanan.index') }}">Pesanan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-info-circle me-2"></i>Informasi Pesanan #{{ $pesanan->id_pesanan }}</span>
                    @if($pesanan->status == 'selesai')
                        <span class="badge badge-success">Selesai</span>
                    @elseif($pesanan->status == 'diproses')
                        <span class="badge badge-primary">Diterima (Diproses)</span>
                    @elseif($pesanan->status == 'dibatalkan')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="text-secondary mb-2">Informasi Pelanggan</h6>
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pesanan->pengguna->nama_pengguna ?? 'U') }}&background=6c5ce7&color=fff&size=60" 
                                 alt="user" class="rounded-circle me-3">
                            <div>
                                <h5 class="mb-1">{{ $pesanan->pengguna->nama_pengguna ?? 'Unknown' }}</h5>
                                <p class="text-secondary mb-0">{{ $pesanan->pengguna->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="text-secondary mb-2">Layanan</h6>
                        <p class="mb-1">
                            <span class="badge badge-primary">{{ $pesanan->layanan->nama_layanan ?? '-' }}</span>
                        </p>
                        @if($pesanan->layanan)
                        <p class="text-secondary mb-0">
                            Rp {{ number_format($pesanan->layanan->harga, 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="text-secondary mb-2">Tanggal Acara</h6>
                        <p class="mb-1">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>
                            {{ $pesanan->tgl_acara ? \Carbon\Carbon::parse($pesanan->tgl_acara)->format('d M Y') : '-' }}
                        </p>
                    </div>
                </div>

                <hr style="border-color: var(--border-color);">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="text-secondary mb-2">Alamat</h6>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt me-2 text-danger"></i>
                            {{ $pesanan->alamat ?? '-' }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-secondary mb-2">Metode Pembayaran</h6>
                        <p class="mb-0">
                            <i class="bi bi-credit-card me-2 text-success"></i>
                            {{ ucfirst($pesanan->metode_pembayaran ?? '-') }}
                        </p>
                    </div>
                </div>

                @if($pesanan->bukti_pembayaran)
                <div class="mb-3">
                    <h6 class="text-secondary mb-2">Bukti Pembayaran</h6>
                    <img src="{{ asset('storage/payments/' . $pesanan->bukti_pembayaran) }}" 
                         alt="Bukti Pembayaran" class="img-preview" style="max-width: 300px; border-radius: 8px;">
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if($pesanan->status == 'pending')
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-check-circle me-2"></i>Aksi Pesanan</h6>
                <p class="text-secondary small mb-3">Pilih aksi untuk pesanan ini:</p>
                
                <form action="{{ route('fotografer.pesanan.updateStatus', $pesanan->id_pesanan) }}" method="POST" class="mb-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="diproses">
                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Terima pesanan ini? Jadwal akan otomatis dibuat.')">
                        <i class="bi bi-check-lg me-1"></i> Terima Pesanan
                    </button>
                </form>
                
                <form action="{{ route('fotografer.pesanan.updateStatus', $pesanan->id_pesanan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="dibatalkan">
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tolak pesanan ini?')">
                        <i class="bi bi-x-lg me-1"></i> Tolak Pesanan
                    </button>
                </form>
            </div>
        </div>
        @elseif($pesanan->status == 'diproses')
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Status Pesanan</h6>
                <div class="alert alert-info">
                    <i class="bi bi-calendar-check me-2"></i>
                    Pesanan sudah diterima dan jadwal telah dibuat otomatis.
                </div>
                <a href="{{ route('fotografer.jadwal.index') }}" class="btn btn-primary w-100">
                    <i class="bi bi-calendar-event me-1"></i> Lihat Jadwal
                </a>
            </div>
        </div>
        @elseif($pesanan->status == 'dibatalkan')
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-x-circle me-2"></i>Status Pesanan</h6>
                <div class="alert alert-danger">
                    Pesanan ini telah ditolak.
                </div>
            </div>
        </div>
        @elseif($pesanan->status == 'selesai')
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-check-circle me-2"></i>Status Pesanan</h6>
                <div class="alert alert-success">
                    <i class="bi bi-check2-circle me-2"></i>
                    Pesanan sudah selesai.
                </div>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-clock-history me-2"></i>Info Pesanan</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-secondary">ID Pesanan</td>
                        <td>{{ $pesanan->id_pesanan }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Tanggal Order</td>
                        <td>{{ $pesanan->tgl_pesanan ? \Carbon\Carbon::parse($pesanan->tgl_pesanan)->format('d M Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Dibuat</td>
                        <td>{{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <a href="{{ route('fotografer.pesanan.index') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
