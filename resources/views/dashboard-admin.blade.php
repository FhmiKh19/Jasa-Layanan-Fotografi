@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('custom-styles')
<style>
  .stat-card {
    border-radius: 16px;
    border: none;
    background: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    padding: 1.75rem;
    border-top: 4px solid transparent;
  }

  .stat-card.stat-warning { border-top-color: #ffc107; }
  .stat-card.stat-info { border-top-color: #17a2b8; }
  .stat-card.stat-primary { border-top-color: #667eea; }
  .stat-card.stat-success { border-top-color: #28a745; }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
  }

  .stat-card .stat-icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
    transition: all 0.3s ease;
  }

  .stat-card.stat-warning .stat-icon-wrapper {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: white;
  }

  .stat-card.stat-info .stat-icon-wrapper {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
  }

  .stat-card.stat-primary .stat-icon-wrapper {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .stat-card.stat-success .stat-icon-wrapper {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
  }

  .stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1) rotate(5deg);
  }

  .stat-card .stat-icon-wrapper i {
    width: 28px;
    height: 28px;
  }

  .stat-card .stat-value {
    font-size: 2.5rem !important;
    font-weight: 800 !important;
    color: #2c3e50 !important;
    margin-bottom: 0.5rem;
    line-height: 1.2;
    min-height: 3rem;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #2c3e50 !important;
    background: none !important;
    -webkit-background-clip: unset !important;
    background-clip: unset !important;
  }

  .stat-card .stat-label {
    color: #7f8c8d;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
  }

  .chart-container {
    position: relative;
    height: 300px;
  }

  .chart-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    background: #fff;
  }

  .chart-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1.5rem;
  }

  .chart-card .card-header h5 {
    color: white;
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<!-- Statistik Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="stat-card stat-warning">
      <div class="stat-icon-wrapper">
        <i data-lucide="camera"></i>
      </div>
      <div class="stat-value">{{ isset($totalFotografer) ? (int)$totalFotografer : 0 }}</div>
      <p class="stat-label mb-0">Total Fotografer</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-info">
      <div class="stat-icon-wrapper">
        <i data-lucide="users"></i>
      </div>
      <div class="stat-value">{{ isset($totalPelanggan) ? (int)$totalPelanggan : 0 }}</div>
      <p class="stat-label mb-0">Total Pelanggan</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-primary">
      <div class="stat-icon-wrapper">
        <i data-lucide="shopping-cart"></i>
      </div>
      <div class="stat-value">{{ isset($pesananBulanIni) ? (int)$pesananBulanIni : 0 }}</div>
      <p class="stat-label mb-0">Pemesanan Bulan Ini</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-success">
      <div class="stat-icon-wrapper">
        <i data-lucide="dollar-sign"></i>
      </div>
      <div class="stat-value" style="font-size: 1.75rem;">Rp {{ isset($pendapatanBulanIni) ? number_format((float)$pendapatanBulanIni, 0, ',', '.') : '0' }}</div>
      <p class="stat-label mb-0">Pendapatan Bulan Ini</p>
    </div>
  </div>
</div>

<!-- Grafik Pesanan -->
<div class="row g-4 mb-4">
  <div class="col-md-8">
    <div class="card chart-card">
      <div class="card-header">
        <h5 class="mb-0 d-flex align-items-center">
          <i data-lucide="trending-up" class="me-2"></i>Grafik Pesanan (6 Bulan Terakhir)
        </h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="chartPesanan"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card chart-card">
      <div class="card-header">
        <h5 class="mb-0 d-flex align-items-center">
          <i data-lucide="pie-chart" class="me-2"></i>Pesanan per Status
        </h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="chartStatus"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Grafik Layanan -->
<div class="row g-4 mb-4">
  <div class="col-md-12">
    <div class="card chart-card">
      <div class="card-header">
        <h5 class="mb-0 d-flex align-items-center">
          <i data-lucide="bar-chart-3" class="me-2"></i>Top 5 Layanan Paling Diminati
        </h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="chartLayanan"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tabel Order Terbaru -->
<div class="card">
  <div class="card-header">
    <h5 class="mb-0 d-flex align-items-center">
      <i data-lucide="list" class="me-2"></i>Pemesanan Terbaru
    </h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Layanan</th>
            <th>Tanggal Pesanan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pesananTerbaru as $pesanan)
            <tr>
              <td><strong>#{{ $pesanan->id_pesanan }}</strong></td>
              <td>{{ $pesanan->pengguna->nama_pengguna }}</td>
              <td>{{ $pesanan->layanan->nama_layanan }}</td>
              <td>{{ $pesanan->tgl_pesanan->format('d M Y') }}</td>
              <td>
                @if($pesanan->status === 'pending')
                  <span class="badge bg-warning text-dark">Pending</span>
                @elseif($pesanan->status === 'diproses')
                  <span class="badge bg-info">Diproses</span>
                @elseif($pesanan->status === 'selesai')
                  <span class="badge bg-success">Selesai</span>
                @else
                  <span class="badge bg-danger">Dibatalkan</span>
                @endif
              </td>
              <td>
                <a href="{{ route('admin.orders.show', $pesanan->id_pesanan) }}" 
                   class="btn btn-action btn-outline-primary"
                   title="Detail Pesanan">
                  <i data-lucide="eye"></i>Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4">
                <i data-lucide="inbox" class="text-muted mb-3" style="width: 3rem; height: 3rem;"></i>
                <p class="text-muted">Tidak ada pesanan</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Grafik Pesanan per Bulan
  const ctxPesanan = document.getElementById('chartPesanan').getContext('2d');
  new Chart(ctxPesanan, {
    type: 'line',
    data: {
      labels: {!! json_encode(array_column($grafikPesanan, 'bulan')) !!},
      datasets: [{
        label: 'Jumlah Pesanan',
        data: {!! json_encode(array_column($grafikPesanan, 'jumlah')) !!},
        borderColor: '#667eea',
        backgroundColor: 'rgba(102, 126, 234, 0.1)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });

  // Grafik Pesanan per Status
  const ctxStatus = document.getElementById('chartStatus').getContext('2d');
  new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
      labels: {!! json_encode(array_column($grafikStatus->toArray(), 'status')) !!},
      datasets: [{
        data: {!! json_encode(array_column($grafikStatus->toArray(), 'jumlah')) !!},
        backgroundColor: [
          '#ffc107',
          '#17a2b8',
          '#28a745',
          '#dc3545'
        ]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });

  // Grafik Top Layanan
  const ctxLayanan = document.getElementById('chartLayanan').getContext('2d');
  new Chart(ctxLayanan, {
    type: 'bar',
    data: {
      labels: {!! json_encode(array_column($grafikLayanan->toArray(), 'nama_layanan')) !!},
      datasets: [{
        label: 'Jumlah Pesanan',
        data: {!! json_encode(array_column($grafikLayanan->toArray(), 'jumlah')) !!},
        backgroundColor: '#764ba2',
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });

  // Initialize Lucide icons after page load
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
      lucide.createIcons();
    }
  });
</script>
@endpush
@endsection
