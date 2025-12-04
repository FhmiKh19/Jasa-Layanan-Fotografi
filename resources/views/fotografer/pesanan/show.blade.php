@extends('layouts.corona')

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
                        <span class="badge badge-primary">Diproses</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="text-secondary mb-2">Informasi Pelanggan</h6>
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pesanan->user->name ?? 'U') }}&background=6c5ce7&color=fff&size=60" 
                                 alt="user" class="rounded-circle me-3">
                            <div>
                                <h5 class="mb-1">{{ $pesanan->user->name ?? 'Unknown' }}</h5>
                                <p class="text-secondary mb-0">{{ $pesanan->user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="text-secondary mb-2">Tanggal & Waktu</h6>
                        <p class="mb-1">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>
                            {{ $pesanan->tgl_acara ? \Carbon\Carbon::parse($pesanan->tgl_acara)->format('d M Y') : '-' }}
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-clock me-2 text-info"></i>
                            {{ $pesanan->jam ?? '-' }}
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
                    <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" 
                         alt="Bukti Pembayaran" class="img-preview">
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-gear me-2"></i>Update Status</h6>
                <form action="{{ route('fotografer.pesanan.updateStatus', $pesanan->id_pesanan) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

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
