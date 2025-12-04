@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

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
  .stat-card.stat-warning { --stat-color-1: #ffc107; --stat-color-2: #ff9800; }
  .stat-card.stat-info { --stat-color-1: #17a2b8; --stat-color-2: #138496; }
  .stat-card.stat-success { --stat-color-1: #28a745; --stat-color-2: #20c997; }

  .filter-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
  }

  .status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="shopping-cart" class="me-2 text-primary"></i>Manajemen Pesanan
    </h3>
    <p class="text-muted mb-0">Kelola semua pesanan dari pelanggan</p>
  </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="stat-card stat-primary">
      <div class="stat-icon-wrapper">
        <i data-lucide="shopping-cart"></i>
      </div>
      <div class="stat-value">{{ $stats['total'] }}</div>
      <p class="stat-label mb-0">Total Pesanan</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-warning">
      <div class="stat-icon-wrapper">
        <i data-lucide="clock"></i>
      </div>
      <div class="stat-value">{{ $stats['pending'] }}</div>
      <p class="stat-label mb-0">Pending</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-info">
      <div class="stat-icon-wrapper">
        <i data-lucide="loader"></i>
      </div>
      <div class="stat-value">{{ $stats['diproses'] }}</div>
      <p class="stat-label mb-0">Diproses</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-success">
      <div class="stat-icon-wrapper">
        <i data-lucide="check-circle"></i>
      </div>
      <div class="stat-value">{{ $stats['selesai'] }}</div>
      <p class="stat-label mb-0">Selesai</p>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-bold">Cari Pesanan</label>
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="Nama pelanggan, email, atau layanan..."
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
        <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center">
          <i data-lucide="search" class="me-2" style="width: 1em; height: 1em;"></i>Filter
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Table Pesanan -->
<div class="card">
  <div class="card-header">
    <h5 class="mb-0 d-flex align-items-center">
      <i data-lucide="list" class="me-2"></i>Daftar Pesanan
      <span class="badge bg-light text-dark ms-2">{{ $pesanan->total() }} Pesanan</span>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Layanan</th>
            <th>Tanggal Pesanan</th>
            <th>Tanggal Acara</th>
            <th>Metode Pembayaran</th>
            <th>Status</th>
            <th style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pesanan as $order)
            <tr>
              <td>
                <strong>#{{ $order->id_pesanan }}</strong>
              </td>
              <td>
                <div>
                  <strong>{{ $order->pengguna->nama_pengguna }}</strong><br>
                  <small class="text-muted">{{ $order->pengguna->email }}</small>
                </div>
              </td>
              <td>
                <div>
                  <strong>{{ $order->layanan->nama_layanan }}</strong><br>
                  <small class="text-muted">Rp {{ number_format($order->layanan->harga, 0, ',', '.') }}</small>
                </div>
              </td>
              <td>
                <small>{{ $order->tgl_pesanan->format('d M Y H:i') }}</small>
              </td>
              <td>
                @if($order->tgl_acara)
                  <small>{{ \Carbon\Carbon::parse($order->tgl_acara)->format('d M Y') }}</small>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                @if($order->metode_pembayaran)
                  <span class="badge bg-secondary">{{ ucfirst($order->metode_pembayaran) }}</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                @if($order->status === 'pending')
                  <span class="status-badge bg-warning text-dark">
                    <i data-lucide="clock" style="width: 0.9em; height: 0.9em;"></i>Pending
                  </span>
                @elseif($order->status === 'diproses')
                  <span class="status-badge bg-info text-white">
                    <i data-lucide="loader" style="width: 0.9em; height: 0.9em;"></i>Diproses
                  </span>
                @elseif($order->status === 'selesai')
                  <span class="status-badge bg-success text-white">
                    <i data-lucide="check-circle" style="width: 0.9em; height: 0.9em;"></i>Selesai
                  </span>
                @else
                  <span class="status-badge bg-danger text-white">
                    <i data-lucide="x-circle" style="width: 0.9em; height: 0.9em;"></i>Dibatalkan
                  </span>
                @endif
              </td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('admin.orders.show', $order->id_pesanan) }}" 
                     class="btn btn-action btn-outline-primary"
                     title="Detail">
                    <i data-lucide="eye"></i>Detail
                  </a>
                  <div class="dropdown">
                    <button class="btn btn-action btn-outline-secondary dropdown-toggle" 
                            type="button" 
                            data-bs-toggle="dropdown"
                            title="Ubah Status">
                      <i data-lucide="edit"></i>Status
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <form action="{{ route('admin.orders.updateStatus', $order->id_pesanan) }}" method="POST" class="d-inline">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="status" value="pending">
                          <button type="submit" class="dropdown-item">
                            <i data-lucide="clock" class="me-2" style="width: 0.9em; height: 0.9em;"></i>Pending
                          </button>
                        </form>
                      </li>
                      <li>
                        <form action="{{ route('admin.orders.updateStatus', $order->id_pesanan) }}" method="POST" class="d-inline">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="status" value="diproses">
                          <button type="submit" class="dropdown-item">
                            <i data-lucide="loader" class="me-2" style="width: 0.9em; height: 0.9em;"></i>Diproses
                          </button>
                        </form>
                      </li>
                      <li>
                        <form action="{{ route('admin.orders.updateStatus', $order->id_pesanan) }}" method="POST" class="d-inline">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="status" value="selesai">
                          <button type="submit" class="dropdown-item">
                            <i data-lucide="check-circle" class="me-2" style="width: 0.9em; height: 0.9em;"></i>Selesai
                          </button>
                        </form>
                      </li>
                      <li><hr class="dropdown-divider"></li>
                      <li>
                        <form action="{{ route('admin.orders.updateStatus', $order->id_pesanan) }}" method="POST" class="d-inline">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="status" value="dibatalkan">
                          <button type="submit" class="dropdown-item text-danger">
                            <i data-lucide="x-circle" class="me-2" style="width: 0.9em; height: 0.9em;"></i>Dibatalkan
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <i data-lucide="inbox" class="text-muted mb-3" style="width: 3rem; height: 3rem;"></i>
                <p class="text-muted">Tidak ada pesanan ditemukan</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($pesanan->hasPages())
    <div class="card-footer bg-white">
      {{ $pesanan->links() }}
    </div>
  @endif
</div>
@endsection

