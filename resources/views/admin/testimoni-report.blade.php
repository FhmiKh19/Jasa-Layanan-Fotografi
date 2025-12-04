@extends('layouts.app')

@section('title', 'Laporan Testimoni')

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

  .filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }

  .chart-container {
    position: relative;
    height: 300px;
  }

  .rating-stars {
    color: #ffc107;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="star" class="me-2 text-primary"></i>Laporan Testimoni
    </h3>
    <p class="text-muted mb-0">Analisis dan laporan testimoni pelanggan</p>
  </div>
</div>

<!-- Statistik Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Total Testimoni</h6>
      <h3 class="fw-bold text-primary mb-0">{{ $stats['total'] }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Rata-rata Rating</h6>
      <h3 class="fw-bold text-warning mb-0">{{ number_format($stats['rata_rata'], 1) }} ⭐</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Rating 5 Bintang</h6>
      <h3 class="fw-bold text-success mb-0">{{ $stats['rating_5'] }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Rating 1-2 Bintang</h6>
      <h3 class="fw-bold text-danger mb-0">{{ $stats['rating_1'] + $stats['rating_2'] }}</h3>
    </div>
  </div>
</div>

<!-- Grafik Testimoni -->
<div class="row g-4 mb-4">
  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="trending-up" class="me-2"></i>Grafik Testimoni (6 Bulan Terakhir)
        </h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="chartTestimoni"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="pie-chart" class="me-2"></i>Distribusi Rating
        </h5>
      </div>
      <div class="card-body">
        <div class="chart-container">
          <canvas id="chartRating"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.testimoni.index') }}" class="row g-3">
      <div class="col-md-4">
        <label class="form-label fw-bold">Cari Testimoni</label>
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="Nama pelanggan, email, atau komentar..."
               value="{{ request('search') }}">
      </div>
      <div class="col-md-2">
        <label class="form-label fw-bold">Rating</label>
        <select name="rating" class="form-select">
          <option value="">Semua Rating</option>
          <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Bintang</option>
          <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Bintang</option>
          <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Bintang</option>
          <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Bintang</option>
          <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Bintang</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-bold">Dari Tanggal</label>
        <input type="date" 
               name="tanggal_dari" 
               class="form-control" 
               value="{{ request('tanggal_dari') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-bold">Sampai Tanggal</label>
        <input type="date" 
               name="tanggal_sampai" 
               class="form-control" 
               value="{{ request('tanggal_sampai') }}">
      </div>
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
          <i data-lucide="search" class="me-2" style="width: 1em; height: 1em;"></i>Filter
        </button>
        <a href="{{ route('admin.testimoni.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
      </div>
    </form>
  </div>
</div>

<!-- Table Testimoni -->
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white">
    <h5 class="fw-bold mb-0 d-flex align-items-center">
      <i data-lucide="list" class="me-2"></i>Daftar Testimoni
      <span class="badge bg-primary ms-2">{{ $testimoni->total() }} Testimoni</span>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>Pelanggan</th>
            <th>Komentar</th>
            <th>Rating</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($testimoni as $item)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  @if($item->pengguna->foto_profil)
                    <img src="{{ asset('storage/profiles/' . $item->pengguna->foto_profil) }}" 
                         alt="Foto" 
                         class="rounded-circle me-2"
                         style="width: 40px; height: 40px; object-fit: cover;">
                  @else
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center me-2"
                         style="width: 40px; height: 40px;">
                      <i data-lucide="user" style="width: 1.2rem; height: 1.2rem;" class="text-muted"></i>
                    </div>
                  @endif
                  <div>
                    <strong>{{ $item->pengguna->nama_pengguna }}</strong><br>
                    <small class="text-muted">{{ $item->pengguna->email }}</small>
                  </div>
                </div>
              </td>
              <td>
                <p class="mb-0">{{ Str::limit($item->komentar, 100) }}</p>
              </td>
              <td>
                <div class="rating-stars">
                  @for($i = 1; $i <= 5; $i++)
                    @if($i <= $item->rating)
                      <i data-lucide="star" style="width: 1rem; height: 1rem; fill: #ffc107;"></i>
                    @else
                      <i data-lucide="star" style="width: 1rem; height: 1rem;"></i>
                    @endif
                  @endfor
                  <span class="ms-2 fw-bold">{{ $item->rating }}/5</span>
                </div>
              </td>
              <td>
                <small>{{ $item->tgl_dibuat->format('d M Y') }}</small>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-4">
                <i data-lucide="inbox" class="text-muted mb-3" style="width: 3rem; height: 3rem;"></i>
                <p class="text-muted">Tidak ada testimoni ditemukan</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($testimoni->hasPages())
    <div class="card-footer bg-white">
      {{ $testimoni->links() }}
    </div>
  @endif
</div>

@push('scripts')
<script>
  // Grafik Testimoni per Bulan
  const ctxTestimoni = document.getElementById('chartTestimoni').getContext('2d');
  new Chart(ctxTestimoni, {
    type: 'line',
    data: {
      labels: {!! json_encode(array_column($grafikTestimoni, 'bulan')) !!},
      datasets: [{
        label: 'Jumlah Testimoni',
        data: {!! json_encode(array_column($grafikTestimoni, 'jumlah')) !!},
        borderColor: '#ffc107',
        backgroundColor: 'rgba(255, 193, 7, 0.1)',
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

  // Grafik Distribusi Rating
  const ctxRating = document.getElementById('chartRating').getContext('2d');
  new Chart(ctxRating, {
    type: 'doughnut',
    data: {
      labels: {!! json_encode(array_column($grafikRating->toArray(), 'rating')) !!},
      datasets: [{
        data: {!! json_encode(array_column($grafikRating->toArray(), 'jumlah')) !!},
        backgroundColor: [
          '#ffc107',
          '#28a745',
          '#17a2b8',
          '#ff9800',
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
</script>
@endpush
@endsection

