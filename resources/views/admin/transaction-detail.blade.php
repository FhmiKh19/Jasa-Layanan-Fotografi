@extends('layouts.app')

@section('title', 'Detail Transaksi')

@push('custom-styles')
<style>
  .detail-card {
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }

  .info-row {
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
  }

  .info-row:last-child {
    border-bottom: none;
  }

  .info-label {
    font-weight: 600;
    color: #6c757d;
  }

  .info-value {
    color: #212529;
    font-weight: 500;
  }

  .amount-display {
    font-size: 2rem;
    font-weight: 700;
    color: #28a745;
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="receipt" class="me-2 text-primary"></i>Detail Transaksi
    </h3>
    <p class="text-muted mb-0">Informasi lengkap transaksi #{{ str_pad($transaction->id_pesanan, 6, '0', STR_PAD_LEFT) }}</p>
  </div>
  <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
    <i data-lucide="arrow-left" class="me-2" style="width: 1em; height: 1em;"></i>Kembali
  </a>
</div>

<div class="row">
  <!-- Informasi Transaksi -->
  <div class="col-md-8">
    <div class="card detail-card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="info" class="me-2"></i>Informasi Transaksi
        </h5>
      </div>
      <div class="card-body">
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">ID Transaksi</div>
            <div class="col-md-8 info-value">
              <strong class="text-primary">#{{ str_pad($transaction->id_pesanan, 6, '0', STR_PAD_LEFT) }}</strong>
            </div>
          </div>
        </div>
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Tanggal Pesanan</div>
            <div class="col-md-8 info-value">
              {{ $transaction->tgl_pesanan->format('d M Y H:i') }}
            </div>
          </div>
        </div>
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Tanggal Transaksi Selesai</div>
            <div class="col-md-8 info-value">
              <strong>{{ $transaction->updated_at->format('d M Y') }}</strong> 
              <span class="text-muted">pukul {{ $transaction->updated_at->format('H:i') }}</span>
            </div>
          </div>
        </div>
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Status</div>
            <div class="col-md-8">
              <span class="badge bg-success d-inline-flex align-items-center">
                <i data-lucide="check-circle" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Selesai
              </span>
            </div>
          </div>
        </div>
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Metode Pembayaran</div>
            <div class="col-md-8 info-value">
              @if($transaction->metode_pembayaran)
                <span class="badge bg-info">{{ ucfirst($transaction->metode_pembayaran) }}</span>
              @else
                <span class="text-muted">-</span>
              @endif
            </div>
          </div>
        </div>
        @if($transaction->tgl_acara)
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Tanggal Acara</div>
            <div class="col-md-8 info-value">
              {{ \Carbon\Carbon::parse($transaction->tgl_acara)->format('d M Y') }}
            </div>
          </div>
        </div>
        @endif
        @if($transaction->alamat)
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Alamat</div>
            <div class="col-md-8 info-value">{{ $transaction->alamat }}</div>
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Informasi Customer -->
    <div class="card detail-card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="user" class="me-2"></i>Informasi Customer
        </h5>
      </div>
      <div class="card-body">
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Nama</div>
            <div class="col-md-8 info-value">{{ $transaction->pengguna->nama_pengguna }}</div>
          </div>
        </div>
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Email</div>
            <div class="col-md-8 info-value">{{ $transaction->pengguna->email }}</div>
          </div>
        </div>
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">Username</div>
            <div class="col-md-8 info-value">@{{ $transaction->pengguna->username }}</div>
          </div>
        </div>
        @if($transaction->pengguna->no_hp)
        <div class="info-row">
          <div class="row">
            <div class="col-md-4 info-label">No. HP</div>
            <div class="col-md-8 info-value">{{ $transaction->pengguna->no_hp }}</div>
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Bukti Pembayaran -->
    @if($transaction->bukti_pembayaran)
    <div class="card detail-card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="image" class="me-2"></i>Bukti Pembayaran
        </h5>
      </div>
      <div class="card-body text-center">
        <img src="{{ asset('storage/payments/' . $transaction->bukti_pembayaran) }}" 
             alt="Bukti Pembayaran" 
             class="img-fluid rounded shadow-sm"
             style="max-height: 500px; cursor: pointer;"
             onclick="window.open(this.src, '_blank')">
        <div class="mt-3">
          <a href="{{ asset('storage/payments/' . $transaction->bukti_pembayaran) }}" 
             target="_blank" 
             class="btn btn-outline-primary d-inline-flex align-items-center">
            <i data-lucide="external-link" class="me-2" style="width: 1em; height: 1em;"></i>Buka di Tab Baru
          </a>
        </div>
      </div>
    </div>
    @endif
  </div>

  <!-- Ringkasan Pembayaran -->
  <div class="col-md-4">
    <div class="card detail-card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="shopping-bag" class="me-2"></i>Ringkasan Pembayaran
        </h5>
      </div>
      <div class="card-body">
        <div class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">Layanan</span>
            <strong>{{ $transaction->layanan->nama_layanan }}</strong>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">Harga</span>
            <span>Rp {{ number_format($transaction->layanan->harga, 0, ',', '.') }}</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold">Total Pembayaran</span>
            <span class="amount-display">Rp {{ number_format($transaction->layanan->harga, 0, ',', '.') }}</span>
          </div>
        </div>

        <div class="alert alert-success d-flex align-items-center">
          <i data-lucide="check-circle" class="me-2" style="width: 1.2em; height: 1.2em;"></i>
          <div>
            <strong>Transaksi Selesai</strong><br>
            <small>Pembayaran telah diterima dan diproses</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Informasi Layanan -->
    <div class="card detail-card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="package" class="me-2"></i>Detail Layanan
        </h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <strong>{{ $transaction->layanan->nama_layanan }}</strong>
        </div>
        @if($transaction->layanan->gambar)
        <div class="mb-3">
          <img src="{{ asset('storage/layanan/' . $transaction->layanan->gambar) }}" 
               alt="{{ $transaction->layanan->nama_layanan }}" 
               class="img-fluid rounded">
        </div>
        @endif
        <div class="text-muted small">
          {{ Str::limit($transaction->layanan->deskripsi, 150) }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

