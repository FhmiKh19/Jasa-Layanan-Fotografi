@extends('layouts.app')

@section('title', 'Manajemen Layanan')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@push('custom-styles')
<style>
  .stat-card {
    border-radius: 20px;
    border: none;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    padding: 1.5rem;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--stat-color-1), var(--stat-color-2));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
  }

  .stat-card:hover::before {
    transform: scaleX(1);
  }

  .stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
  }

  .stat-card .stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--stat-color-1), var(--stat-color-2));
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
  }

  .stat-card:hover .stat-icon-wrapper {
    transform: rotate(5deg) scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
  }

  .stat-card .stat-value {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--stat-color-1), var(--stat-color-2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
  }

  .stat-card .stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
  }

  .stat-card.stat-primary { --stat-color-1: #667eea; --stat-color-2: #764ba2; }
  .stat-card.stat-success { --stat-color-1: #28a745; --stat-color-2: #20c997; }
  .stat-card.stat-secondary { --stat-color-1: #6c757d; --stat-color-2: #5a6268; }

  .filter-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
  }

  .user-avatar {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    object-fit: cover;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
  }

  .user-avatar:hover {
    border-color: #667eea;
    transform: scale(1.05);
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="package" class="me-2 text-primary"></i>Manajemen Layanan
    </h3>
    <p class="text-muted mb-0">Kelola layanan fotografi yang tersedia</p>
  </div>
  <a href="{{ route('admin.services.create') }}" class="btn btn-primary d-inline-flex align-items-center">
    <i data-lucide="plus" class="me-2" style="width: 1em; height: 1em;"></i>Tambah Layanan
  </a>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="stat-card stat-primary">
      <div class="stat-icon-wrapper">
        <i data-lucide="package"></i>
      </div>
      <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
      <p class="stat-label mb-0">Total Layanan</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card stat-success">
      <div class="stat-icon-wrapper">
        <i data-lucide="check-circle"></i>
      </div>
      <div class="stat-value">{{ $stats['aktif'] ?? 0 }}</div>
      <p class="stat-label mb-0">Aktif</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="stat-card stat-secondary">
      <div class="stat-icon-wrapper">
        <i data-lucide="pause-circle"></i>
      </div>
      <div class="stat-value">{{ $stats['nonaktif'] ?? 0 }}</div>
      <p class="stat-label mb-0">Nonaktif</p>
    </div>
  </div>
</div>

<!-- Layanan Populer -->
@if($stats['layanan_populer'] && count($stats['layanan_populer']) > 0)
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-0 d-flex align-items-center">
      <i data-lucide="trending-up" class="me-2"></i>Layanan Paling Populer
    </h5>
  </div>
  <div class="card-body">
    <div class="row g-3">
      @foreach($stats['layanan_populer'] as $layananPopuler)
        <div class="col-md-6">
          <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
            <div>
              <strong>{{ $layananPopuler->nama_layanan }}</strong>
              <br>
              <small class="text-muted">{{ $layananPopuler->pesanan_count }}x dipesan</small>
            </div>
            <span class="badge bg-primary">{{ $layananPopuler->pesanan_count }}x</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.services.index') }}" class="row g-3">
      <div class="col-md-8">
        <label class="form-label fw-bold">Cari Layanan</label>
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="Nama layanan atau deskripsi..."
               value="{{ request('search') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-bold">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua Status</option>
          <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center">
          <i data-lucide="search" class="me-1" style="width: 1em; height: 1em;"></i>Filter
        </button>
      </div>
    </form>
    @if(request()->hasAny(['search', 'status']))
      <div class="mt-3">
        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
          <i data-lucide="x" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Reset Filter
        </a>
      </div>
    @endif
  </div>
</div>

<!-- Table Layanan -->
<div class="card">
  <div class="card-header">
    <h5 class="mb-0 d-flex align-items-center">
      <i data-lucide="list" class="me-2"></i>Daftar Layanan
      <span class="badge bg-light text-dark ms-2">{{ method_exists($layanan, 'total') ? $layanan->total() : $layanan->count() }} Layanan</span>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 80px;">Gambar</th>
            <th>Nama Layanan</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Dibuat</th>
            <th style="width: 180px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($layanan as $item)
            <tr>
                <td>
                  @if($item->gambar)
                    <img src="{{ asset('storage/layanan/' . $item->gambar) }}" 
                         alt="{{ $item->nama_layanan ?? 'Layanan' }}" 
                         class="user-avatar"
                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                         onerror="console.error('Gambar tidak ditemukan: storage/layanan/{{ $item->gambar }}'); this.onerror=null; this.parentElement.innerHTML='<div class=\'user-avatar bg-light d-flex align-items-center justify-content-center\' style=\'width: 60px; height: 60px; border-radius: 8px;\'><i data-lucide=\'image\' class=\'text-muted\' style=\'width: 1.5rem; height: 1.5rem;\'></i></div>'; lucide.createIcons();">
                  @else
                    <div class="user-avatar bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 8px;">
                      <i data-lucide="image" class="text-muted" style="width: 1.5rem; height: 1.5rem;"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <strong>{{ isset($item->nama_layanan) ? $item->nama_layanan : '-' }}</strong>
                </td>
                <td>
                  <span class="fw-bold text-success">
                    Rp {{ isset($item->harga) ? number_format($item->harga, 0, ',', '.') : '0' }}
                  </span>
                </td>
                <td>
                  <span class="text-muted small">
                    {{ isset($item->deskripsi) && !empty($item->deskripsi) ? Str::limit($item->deskripsi, 50) : '-' }}
                  </span>
                </td>
                <td>
                  @if(isset($item->status) && $item->status === 'aktif')
                    <span class="badge bg-success d-inline-flex align-items-center">
                      <i data-lucide="check-circle" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Aktif
                    </span>
                  @else
                    <span class="badge bg-secondary d-inline-flex align-items-center">
                      <i data-lucide="pause-circle" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Nonaktif
                    </span>
                  @endif
                </td>
                <td>
                  <small class="text-muted">
                    @if(isset($item->tgl_dibuat) && $item->tgl_dibuat)
                      {{ $item->tgl_dibuat instanceof \Carbon\Carbon ? $item->tgl_dibuat->format('d M Y') : date('d M Y', strtotime($item->tgl_dibuat)) }}
                    @else
                      -
                    @endif
                  </small>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.edit', $item->id_layanan) }}" 
                       class="btn btn-action btn-primary"
                       title="Edit">
                      <i data-lucide="edit"></i>Edit
                    </a>
                    <form action="{{ route('admin.services.toggleStatus', $item->id_layanan) }}" 
                          method="POST" 
                          class="d-inline">
                      @csrf
                      @method('PUT')
                      <button type="submit" 
                              class="btn btn-action btn-outline-{{ (isset($item->status) && $item->status === 'aktif') ? 'warning' : 'success' }}"
                              title="{{ (isset($item->status) && $item->status === 'aktif') ? 'Nonaktifkan' : 'Aktifkan' }}">
                        <i data-lucide="{{ (isset($item->status) && $item->status === 'aktif') ? 'pause' : 'play' }}"></i>
                        {{ (isset($item->status) && $item->status === 'aktif') ? 'Nonaktif' : 'Aktif' }}
                      </button>
                    </form>
                    <form action="{{ route('admin.services.destroy', $item->id_layanan) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus layanan ini? Layanan yang sudah digunakan dalam pesanan tidak dapat dihapus.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                              class="btn btn-action btn-outline-danger"
                              title="Hapus">
                        <i data-lucide="trash-2"></i>Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <i data-lucide="inbox" class="text-muted mb-3" style="width: 3rem; height: 3rem;"></i>
                <p class="text-muted">Tidak ada layanan ditemukan</p>
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary mt-2 d-inline-flex align-items-center">
                  <i data-lucide="plus" class="me-2" style="width: 1em; height: 1em;"></i>Tambah Layanan
                </a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if(method_exists($layanan, 'hasPages') && $layanan->hasPages())
    <div class="card-footer bg-white">
      {{ $layanan->links() }}
    </div>
  @endif
</div>
@endsection

