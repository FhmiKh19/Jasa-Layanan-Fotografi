@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@push('custom-styles')
<style>
  .stat-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .stat-card .icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }

  .table-responsive {
    border-radius: 12px;
    overflow: hidden;
  }

  .table thead {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
  }

  .table tbody tr {
    transition: all 0.2s ease;
  }

  .table tbody tr:hover {
    background-color: #f8f9fa;
  }

  .amount-badge {
    font-weight: 700;
    font-size: 1rem;
    color: #28a745;
  }

  .payment-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
  }

  .chart-container {
    position: relative;
    height: 300px;
  }

  /* Header Styling untuk Kontras Lebih Baik */
  .page-header-wrapper {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 25px 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  .page-header-wrapper h3 {
    color: #2c3e50 !important;
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    margin-bottom: 8px !important;
    text-shadow: none !important;
  }

  .page-header-wrapper h3 i {
    color: #8d5524 !important;
  }

  .page-header-wrapper p {
    color: #555 !important;
    font-size: 1rem !important;
    font-weight: 500 !important;
    margin: 0 !important;
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="page-header-wrapper">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h3 class="fw-bold mb-1 d-flex align-items-center">
        <i data-lucide="receipt" class="me-2 text-primary"></i>Manajemen Transaksi
      </h3>
      <p class="text-muted mb-0">Daftar transaksi pesanan yang telah selesai</p>
    </div>
  </div>
</div>

<!-- Statistik Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card stat-card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-white-50 mb-2">Total Transaksi</h6>
            <h3 class="fw-bold mb-0">{{ number_format($stats['total_transaksi'] ?? 0, 0, ',', '.') }}</h3>
          </div>
          <div class="icon-wrapper bg-white bg-opacity-20">
            <i data-lucide="shopping-cart" style="width: 1.5rem; height: 1.5rem; color: white;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-white-50 mb-2">Total Pendapatan</h6>
            <h3 class="fw-bold mb-0">Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}</h3>
          </div>
          <div class="icon-wrapper bg-white bg-opacity-20">
            <i data-lucide="dollar-sign" style="width: 1.5rem; height: 1.5rem; color: white;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-white-50 mb-2">Pendapatan Hari Ini</h6>
            <h3 class="fw-bold mb-0">Rp {{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0, ',', '.') }}</h3>
          </div>
          <div class="icon-wrapper bg-white bg-opacity-20">
            <i data-lucide="trending-up" style="width: 1.5rem; height: 1.5rem; color: white;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-white" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-white-50 mb-2">Pendapatan Bulan Ini</h6>
            <h3 class="fw-bold mb-0">Rp {{ number_format($stats['pendapatan_bulan_ini'] ?? 0, 0, ',', '.') }}</h3>
          </div>
          <div class="icon-wrapper bg-white bg-opacity-20">
            <i data-lucide="calendar" style="width: 1.5rem; height: 1.5rem; color: white;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart Pendapatan -->
@if($stats['pendapatan_per_bulan'] && count($stats['pendapatan_per_bulan']) > 0)
<div class="row mb-4">
  <div class="col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="bar-chart-3" class="me-2"></i>Grafik Pendapatan 6 Bulan Terakhir
        </h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="pendapatanChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-3">
      <div class="col-md-3">
        <label class="form-label fw-bold">Cari Transaksi</label>
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="ID, nama customer, email, atau layanan..."
               value="{{ request('search') }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-bold">Metode Pembayaran</label>
        <select name="metode_pembayaran" class="form-select">
          <option value="">Semua Metode</option>
          @foreach($metodePembayaran as $metode)
            <option value="{{ $metode }}" {{ request('metode_pembayaran') == $metode ? 'selected' : '' }}>
              {{ ucfirst($metode) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label fw-bold">Periode</label>
        <select name="periode" class="form-select">
          <option value="">Semua Periode</option>
          <option value="hari_ini" {{ request('periode') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
          <option value="minggu_ini" {{ request('periode') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
          <option value="bulan_ini" {{ request('periode') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
          <option value="tahun_ini" {{ request('periode') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label fw-bold">Dari Tanggal</label>
        <input type="date" 
               name="tanggal_dari" 
               class="form-control" 
               value="{{ request('tanggal_dari') }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-bold">Sampai Tanggal</label>
        <input type="date" 
               name="tanggal_sampai" 
               class="form-control" 
               value="{{ request('tanggal_sampai') }}">
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center">
          <i data-lucide="search" class="me-1" style="width: 1em; height: 1em;"></i>Filter
        </button>
      </div>
    </form>
    @if(request()->hasAny(['search', 'metode_pembayaran', 'periode', 'tanggal_dari', 'tanggal_sampai']))
      <div class="mt-3">
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
          <i data-lucide="x" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Reset Filter
        </a>
      </div>
    @endif
  </div>
</div>

<!-- Table Transaksi -->
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white">
    <h5 class="fw-bold mb-0 d-flex align-items-center">
      <i data-lucide="list" class="me-2"></i>Daftar Transaksi
      <span class="badge bg-primary ms-2">{{ $transactions->total() }} Transaksi</span>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 100px;">ID Transaksi</th>
            <th>Customer</th>
            <th>Layanan</th>
            <th>Total</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal Selesai</th>
            <th>Bukti</th>
            <th style="width: 100px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transactions as $transaction)
            <tr>
              <td>
                <strong class="text-primary">#{{ str_pad($transaction->id_pesanan, 6, '0', STR_PAD_LEFT) }}</strong>
              </td>
              <td>
                <div>
                  <strong>{{ $transaction->pengguna->nama_pengguna }}</strong><br>
                  <small class="text-muted">{{ $transaction->pengguna->email }}</small>
                </div>
              </td>
              <td>
                <div>
                  <strong>{{ $transaction->layanan->nama_layanan }}</strong><br>
                  <small class="text-muted">Rp {{ number_format($transaction->layanan->harga, 0, ',', '.') }}</small>
                </div>
              </td>
              <td>
                <span class="amount-badge">Rp {{ number_format($transaction->layanan->harga, 0, ',', '.') }}</span>
              </td>
              <td>
                @if($transaction->metode_pembayaran)
                  <span class="payment-badge bg-info text-white">
                    {{ ucfirst($transaction->metode_pembayaran) }}
                  </span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                <div>
                  <strong>{{ $transaction->updated_at->format('d M Y') }}</strong><br>
                  <small class="text-muted">{{ $transaction->updated_at->format('H:i') }}</small>
                </div>
              </td>
              <td>
                @if($transaction->bukti_pembayaran)
                  <a href="{{ asset('storage/payments/' . $transaction->bukti_pembayaran) }}" 
                     target="_blank" 
                     class="btn btn-action btn-outline-primary"
                     title="Lihat Bukti Pembayaran">
                    <i data-lucide="image"></i>Bukti
                  </a>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                <a href="{{ route('admin.transactions.show', $transaction->id_pesanan) }}" 
                   class="btn btn-action btn-primary"
                   title="Detail Transaksi">
                  <i data-lucide="eye"></i>Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <i data-lucide="inbox" class="text-muted mb-3" style="width: 3rem; height: 3rem;"></i>
                <p class="text-muted">Tidak ada transaksi ditemukan</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($transactions->hasPages())
    <div class="card-footer bg-white">
      {{ $transactions->links() }}
    </div>
  @endif
</div>

<!-- Statistik Metode Pembayaran -->
@if($stats['statistik_metode'] && count($stats['statistik_metode']) > 0)
<div class="row mt-4">
  <div class="col-md-6">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="credit-card" class="me-2"></i>Statistik Metode Pembayaran
        </h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Metode</th>
                <th class="text-end">Jumlah</th>
                <th class="text-end">Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($stats['statistik_metode'] as $stat)
                <tr>
                  <td><strong>{{ ucfirst($stat->metode_pembayaran) }}</strong></td>
                  <td class="text-end">{{ $stat->jumlah }}x</td>
                  <td class="text-end">
                    <strong class="text-success">Rp {{ number_format($stat->total, 0, ',', '.') }}</strong>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="pie-chart" class="me-2"></i>Distribusi Metode Pembayaran
        </h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="metodeChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Chart Pendapatan Per Bulan
  @if($stats['pendapatan_per_bulan'] && count($stats['pendapatan_per_bulan']) > 0)
  const pendapatanCtx = document.getElementById('pendapatanChart');
  if (pendapatanCtx) {
    const pendapatanData = @json($stats['pendapatan_per_bulan']);
    const labels = pendapatanData.map(item => {
      const [year, month] = item.bulan.split('-');
      const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
      return monthNames[parseInt(month) - 1] + ' ' + year;
    });
    const data = pendapatanData.map(item => parseFloat(item.total));

    new Chart(pendapatanCtx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Pendapatan (Rp)',
          data: data,
          borderColor: 'rgb(102, 126, 234)',
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
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
              }
            }
          }
        }
      }
    });
  }
  @endif

  // Chart Distribusi Metode Pembayaran
  @if($stats['statistik_metode'] && count($stats['statistik_metode']) > 0)
  const metodeCtx = document.getElementById('metodeChart');
  if (metodeCtx) {
    const metodeData = @json($stats['statistik_metode']);
    const labels = metodeData.map(item => ucfirst(item.metode_pembayaran));
    const data = metodeData.map(item => parseInt(item.jumlah));
    const colors = ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#43e97b'];

    new Chart(metodeCtx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: colors.slice(0, labels.length),
          borderWidth: 2,
          borderColor: '#fff'
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
  }

  function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }
  @endif
</script>
@endpush

