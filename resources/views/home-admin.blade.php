@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<!-- Welcome Card -->
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-4">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h3 class="fw-bold mb-2 d-flex align-items-center">
          <i data-lucide="user-circle" class="me-2 text-primary"></i>
          Selamat Datang, {{ Auth::user()->nama_pengguna }}!
        </h3>
        <p class="text-muted mb-0">
          Kelola pesanan dan layanan fotografi Anda dengan mudah
        </p>
      </div>
      <div class="col-md-4 text-end">
        <a href="#" class="btn btn-primary btn-lg d-inline-flex align-items-center" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
          <i data-lucide="plus" class="me-2" style="width: 1em; height: 1em;"></i>Pesan Layanan
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card card-stat p-3 text-center">
      <h6 class="text-muted">Pesanan Aktif</h6>
      <h3 class="fw-bold text-primary">{{ $pesananAktif ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 text-center">
      <h6 class="text-muted">Pesanan Selesai</h6>
      <h3 class="fw-bold text-success">{{ $pesananSelesai ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 text-center">
      <h6 class="text-muted">Menunggu Pembayaran</h6>
      <h3 class="fw-bold text-warning">{{ $menungguPembayaran ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card card-stat p-3 text-center">
      <h6 class="text-muted">Total Pengeluaran</h6>
      <h3 class="fw-bold text-info">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</h3>
    </div>
  </div>
</div>

<!-- Pesanan Terbaru -->
<div class="card border-0 shadow-sm mb-4">
  <div class="card-header bg-white">
    <h5 class="fw-bold mb-0">
      <i data-lucide="list" class="me-2"></i>Pesanan Terbaru
    </h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Layanan</th>
            <th>Tanggal Acara</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pesananTerbaru ?? [] as $index => $pesanan)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $pesanan->layanan->nama_layanan ?? 'Layanan' }}</td>
            <td>{{ $pesanan->tgl_acara ? \Carbon\Carbon::parse($pesanan->tgl_acara)->format('d M Y') : '-' }}</td>
            <td>
              @if($pesanan->status == 'selesai')
                <span class="badge bg-success">Selesai</span>
              @elseif($pesanan->status == 'diproses')
                <span class="badge bg-primary">Diproses</span>
              @elseif($pesanan->status == 'menunggu_pembayaran')
                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
              @else
                <span class="badge bg-secondary">Pending</span>
              @endif
            </td>
            <td>
              <button class="btn btn-sm btn-outline-primary">
                <i data-lucide="eye" style="width: 0.9em; height: 0.9em;"></i> Detail
              </button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-4">
              <p class="text-muted mb-0">Belum ada pesanan</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Layanan Populer -->
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white">
    <h5 class="fw-bold mb-0">
      <i data-lucide="star" class="me-2"></i>Layanan Populer
    </h5>
  </div>
  <div class="card-body">
    <div class="row g-3">
      @forelse($layananPopuler ?? [] as $layanan)
      <div class="col-md-4">
        <div class="card border p-3 text-center">
          <i data-lucide="camera" class="text-primary mb-3" style="width: 3rem; height: 3rem;"></i>
          <h6 class="fw-bold">{{ $layanan->nama_layanan }}</h6>
          <p class="text-muted small mb-2">Mulai dari</p>
          <h5 class="text-primary">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</h5>
        </div>
      </div>
      @empty
      <div class="col-12">
        <p class="text-muted text-center">Belum ada layanan tersedia</p>
      </div>
      @endforelse
    </div>
  </div>
</div>
@endsection


