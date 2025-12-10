@extends('layouts-fotografer.corona')

@section('title', 'Kelola Pesanan')

@section('content')
<!-- Page Header -->
<div class="page-header mb-4">
    <div>
        <h3 class="mb-2" style="font-size: 28px; font-weight: 600; color: #ffffff; letter-spacing: -0.5px;">
            <i class="bi bi-cart-check me-2" style="color: #6c5ce7;"></i>Kelola Pesanan
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}" style="color: #6c7293; text-decoration: none;">Dashboard</a></li>
                <li class="breadcrumb-item active" style="color: #6c5ce7;">Pesanan</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card bg-gradient-info" style="padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(143, 95, 232, 0.2); transition: transform 0.3s ease;">
            <div class="stat-content">
                <h3 style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 8px;">{{ $pesanan->count() }}</h3>
                <p class="mb-0" style="font-size: 14px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Total Pesanan</p>
            </div>
            <div class="stat-icon" style="font-size: 52px; opacity: 0.25;">
                <i class="bi bi-cart3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card bg-gradient-warning" style="padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 171, 0, 0.2); transition: transform 0.3s ease;">
            <div class="stat-content">
                <h3 style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 8px;">{{ $pesanan->where('status', 'pending')->count() }}</h3>
                <p class="mb-0" style="font-size: 14px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Pesanan Pending</p>
            </div>
            <div class="stat-icon" style="font-size: 52px; opacity: 0.25;">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card bg-gradient-primary" style="padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(108, 92, 231, 0.2); transition: transform 0.3s ease;">
            <div class="stat-content">
                <h3 style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 8px;">{{ $pesanan->where('status', 'diproses')->count() }}</h3>
                <p class="mb-0" style="font-size: 14px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Sedang Diproses</p>
            </div>
            <div class="stat-icon" style="font-size: 52px; opacity: 0.25;">
                <i class="bi bi-gear"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card bg-gradient-success" style="padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 210, 91, 0.2); transition: transform 0.3s ease;">
            <div class="stat-content">
                <h3 style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 8px;">{{ $pesanan->where('status', 'selesai')->count() }}</h3>
                <p class="mb-0" style="font-size: 14px; color: rgba(255, 255, 255, 0.9); font-weight: 500;">Pesanan Selesai</p>
            </div>
            <div class="stat-icon" style="font-size: 52px; opacity: 0.25;">
                <i class="bi bi-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card" style="border: 1px solid #2c2e33; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body" style="padding: 25px;">
                <div class="card-title mb-4" style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #2c2e33; padding-bottom: 15px;">
                    <h4 style="font-size: 18px; font-weight: 600; color: #ffffff; margin: 0;">
                        <i class="bi bi-list-ul me-2" style="color: #6c5ce7;"></i>Daftar Pesanan
                    </h4>
                    <span style="font-size: 13px; color: #6c7293;">Total: <strong style="color: #6c5ce7;">{{ $pesanan->count() }}</strong> pesanan</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #191c24 0%, #2c2e33 100%);">
                                <th style="font-size: 12px; font-weight: 600; color: #6c7293; text-transform: uppercase; letter-spacing: 0.5px; padding: 18px 15px; border: none;">Pelanggan</th>
                                <th style="font-size: 12px; font-weight: 600; color: #6c7293; text-transform: uppercase; letter-spacing: 0.5px; padding: 18px 15px; border: none;">Layanan</th>
                                <th style="font-size: 12px; font-weight: 600; color: #6c7293; text-transform: uppercase; letter-spacing: 0.5px; padding: 18px 15px; border: none;">Tanggal Acara</th>
                                <th style="font-size: 12px; font-weight: 600; color: #6c7293; text-transform: uppercase; letter-spacing: 0.5px; padding: 18px 15px; border: none;">Alamat</th>
                                <th style="font-size: 12px; font-weight: 600; color: #6c7293; text-transform: uppercase; letter-spacing: 0.5px; padding: 18px 15px; border: none;">Status</th>
                                <th style="font-size: 12px; font-weight: 600; color: #6c7293; text-transform: uppercase; letter-spacing: 0.5px; padding: 18px 15px; border: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanan as $item)
                            <tr style="border-bottom: 1px solid #2c2e33; transition: all 0.3s ease;">
                                <td style="padding: 18px 15px; vertical-align: middle;">
                                    <div class="user-cell" style="display: flex; align-items: center; gap: 12px;">
                                        @if($item->user)
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=6c5ce7&color=fff&size=128&bold=true" 
                                             alt="user" 
                                             style="width: 42px; height: 42px; border-radius: 50%; border: 2px solid #6c5ce7; object-fit: cover;">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 600; color: #ffffff; margin-bottom: 2px;">{{ $item->user->name }}</div>
                                            <div style="font-size: 12px; color: #6c7293;">{{ $item->user->email ?? '' }}</div>
                                        </div>
                                        @else
                                        <img src="https://ui-avatars.com/api/?name=U&background=6c5ce7&color=fff" alt="user" style="width: 42px; height: 42px; border-radius: 50%;">
                                        <span style="color: #6c7293; font-size: 14px;">User tidak ditemukan</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="padding: 18px 15px; vertical-align: middle;">
                                    @if(isset($item->layanan) && $item->layanan)
                                        <span class="badge badge-info" style="font-size: 12px; font-weight: 600; padding: 8px 14px; border-radius: 20px; background: rgba(143, 95, 232, 0.15); color: #8f5fe8; border: 1px solid rgba(143, 95, 232, 0.3);">
                                            <i class="bi bi-camera me-1"></i>{{ $item->layanan->nama_layanan }}
                                        </span>
                                    @else
                                        <span style="color: #6c7293; font-size: 14px;">-</span>
                                    @endif
                                </td>
                                <td style="padding: 18px 15px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="bi bi-calendar3" style="color: #6c5ce7; font-size: 16px;"></i>
                                        <span style="font-size: 14px; color: #ffffff; font-weight: 500;">
                                            {{ $item->tgl_acara ? \Carbon\Carbon::parse($item->tgl_acara)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td style="padding: 18px 15px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="bi bi-geo-alt" style="color: #6c7293; font-size: 14px;"></i>
                                        <span style="font-size: 14px; color: #ffffff;">{{ Str::limit($item->alamat ?? '-', 35) }}</span>
                                    </div>
                                </td>
                                <td style="padding: 18px 15px; vertical-align: middle;">
                                    @if($item->status == 'selesai')
                                        <span class="badge badge-success" style="font-size: 12px; font-weight: 600; padding: 8px 14px; border-radius: 20px; background: rgba(0, 210, 91, 0.15); color: #00d25b; border: 1px solid rgba(0, 210, 91, 0.3);">
                                            <i class="bi bi-check-circle me-1"></i>Selesai
                                        </span>
                                    @elseif($item->status == 'diproses')
                                        <span class="badge badge-primary" style="font-size: 12px; font-weight: 600; padding: 8px 14px; border-radius: 20px; background: rgba(108, 92, 231, 0.15); color: #6c5ce7; border: 1px solid rgba(108, 92, 231, 0.3);">
                                            <i class="bi bi-gear me-1"></i>Diproses
                                        </span>
                                    @else
                                        <span class="badge badge-warning" style="font-size: 12px; font-weight: 600; padding: 8px 14px; border-radius: 20px; background: rgba(255, 171, 0, 0.15); color: #ffab00; border: 1px solid rgba(255, 171, 0, 0.3);">
                                            <i class="bi bi-hourglass-split me-1"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 18px 15px; vertical-align: middle; text-align: center;">
                                    <a href="{{ route('fotografer.pesanan.show', $item->id_pesanan) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       style="font-size: 13px; font-weight: 500; padding: 8px 16px; border-radius: 8px; border: 1.5px solid #6c5ce7; color: #6c5ce7; background: transparent; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="padding: 60px 20px; text-align: center;">
                                    <div class="empty-state" style="color: #6c7293;">
                                        <i class="bi bi-inbox" style="font-size: 64px; color: #2c2e33; margin-bottom: 20px; display: block;"></i>
                                        <h5 style="font-size: 18px; font-weight: 600; color: #ffffff; margin-bottom: 10px;">Belum ada pesanan</h5>
                                        <p style="font-size: 14px; color: #6c7293; margin: 0;">Pesanan dari pelanggan akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
}

.table tbody tr:hover {
    background: rgba(108, 92, 231, 0.08) !important;
    transform: scale(1.01);
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #6c5ce7 !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 92, 231, 0.4);
}

.user-cell img {
    transition: transform 0.3s ease;
}

.user-cell:hover img {
    transform: scale(1.1);
}
</style>
@endpush
@endsection
