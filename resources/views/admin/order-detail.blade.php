@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="file-text" class="me-2 text-primary"></i>Detail Pesanan #{{ $pesanan->id_pesanan }}
    </h3>
    <p class="text-muted mb-0">Informasi lengkap pesanan</p>
  </div>
  <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
    <i data-lucide="arrow-left" class="me-2" style="width: 1em; height: 1em;"></i>Kembali
  </a>
</div>

<div class="row g-4">
  <!-- Informasi Pesanan -->
  <div class="col-md-8">
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="shopping-cart" class="me-2"></i>Informasi Pesanan
        </h5>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-4"><strong>ID Pesanan:</strong></div>
          <div class="col-md-8">#{{ $pesanan->id_pesanan }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4"><strong>Tanggal Pesanan:</strong></div>
          <div class="col-md-8">{{ $pesanan->tgl_pesanan->format('d M Y H:i') }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4"><strong>Tanggal Acara:</strong></div>
          <div class="col-md-8">
            @if($pesanan->tgl_acara)
              {{ \Carbon\Carbon::parse($pesanan->tgl_acara)->format('d M Y') }}
            @else
              <span class="text-muted">-</span>
            @endif
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4"><strong>Status:</strong></div>
          <div class="col-md-8">
            @if($pesanan->status === 'pending')
              <span class="badge bg-warning text-dark">Pending</span>
            @elseif($pesanan->status === 'diproses')
              <span class="badge bg-info">Diproses</span>
            @elseif($pesanan->status === 'selesai')
              <span class="badge bg-success">Selesai</span>
            @else
              <span class="badge bg-danger">Dibatalkan</span>
            @endif
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4"><strong>Metode Pembayaran:</strong></div>
          <div class="col-md-8">
            @if($pesanan->metode_pembayaran)
              {{ ucfirst($pesanan->metode_pembayaran) }}
            @else
              <span class="text-muted">-</span>
            @endif
          </div>
        </div>
        @if($pesanan->alamat)
        <div class="row mb-3">
          <div class="col-md-4"><strong>Alamat:</strong></div>
          <div class="col-md-8">{{ $pesanan->alamat }}</div>
        </div>
        @endif
      </div>
    </div>

    <!-- Informasi Layanan -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="package" class="me-2"></i>Layanan
        </h5>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-4"><strong>Nama Layanan:</strong></div>
          <div class="col-md-8">{{ $pesanan->layanan->nama_layanan }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4"><strong>Harga:</strong></div>
          <div class="col-md-8">
            <h5 class="text-primary mb-0">Rp {{ number_format($pesanan->layanan->harga, 0, ',', '.') }}</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"><strong>Deskripsi:</strong></div>
          <div class="col-md-8">{{ $pesanan->layanan->deskripsi ?? '-' }}</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Informasi Pelanggan & Aksi -->
  <div class="col-md-4">
    <!-- Informasi Pelanggan -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="user" class="me-2"></i>Pelanggan
        </h5>
      </div>
      <div class="card-body">
        <div class="text-center mb-3">
          @if($pesanan->pengguna->foto_profil)
            <img src="{{ asset('storage/profiles/' . $pesanan->pengguna->foto_profil) }}" 
                 alt="Foto" 
                 class="rounded-circle mb-2"
                 style="width: 80px; height: 80px; object-fit: cover;">
          @else
            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-2"
                 style="width: 80px; height: 80px;">
              <i data-lucide="user" style="width: 2rem; height: 2rem;" class="text-muted"></i>
            </div>
          @endif
          <h6 class="fw-bold mb-1">{{ $pesanan->pengguna->nama_pengguna }}</h6>
          <p class="text-muted small mb-0">{{ $pesanan->pengguna->email }}</p>
        </div>
        <hr>
        <div class="mb-2">
          <strong>Username:</strong><br>
          <span class="text-muted">{{ '@' . $pesanan->pengguna->username }}</span>
        </div>
        <div class="mb-2">
          <strong>No. HP:</strong><br>
          <span class="text-muted">{{ $pesanan->pengguna->no_hp ?? '-' }}</span>
        </div>
      </div>
    </div>

    <!-- Assign Fotografer -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="camera" class="me-2"></i>Fotografer
        </h5>
      </div>
      <div class="card-body">
        @if($pesanan->fotografer)
          <div class="mb-3">
            <strong>Fotografer Ter-assign:</strong><br>
            <div class="mt-2 p-2 bg-light rounded">
              <strong>{{ $pesanan->fotografer->nama_pengguna }}</strong><br>
              <small class="text-muted">{{ $pesanan->fotografer->email }}</small>
            </div>
          </div>
        @else
          <div class="mb-3">
            <span class="text-muted">Belum ada fotografer yang di-assign</span>
          </div>
        @endif
        <form action="{{ route('admin.orders.assignFotografer', $pesanan->id_pesanan) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label fw-bold">Pilih Fotografer</label>
            <select name="id_fotografer" class="form-select">
              <option value="">-- Pilih Fotografer --</option>
              @foreach($fotografer as $foto)
                <option value="{{ $foto->id_pengguna }}" {{ $pesanan->id_fotografer == $foto->id_pengguna ? 'selected' : '' }}>
                  {{ $foto->nama_pengguna }} (@{{ $foto->username }})
                </option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center">
            <i data-lucide="save" class="me-2" style="width: 1em; height: 1em;"></i>{{ $pesanan->fotografer ? 'Ubah Fotografer' : 'Assign Fotografer' }}
          </button>
        </form>
      </div>
    </div>

    <!-- Ubah Status -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="edit" class="me-2"></i>Ubah Status
        </h5>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.orders.updateStatus', $pesanan->id_pesanan) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label fw-bold">Status Pesanan</label>
            <select name="status" class="form-select" required>
              <option value="pending" {{ $pesanan->status === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="diproses" {{ $pesanan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
              <option value="selesai" {{ $pesanan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
              <option value="dibatalkan" {{ $pesanan->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center">
            <i data-lucide="save" class="me-2" style="width: 1em; height: 1em;"></i>Simpan Perubahan
          </button>
        </form>
      </div>
    </div>

    <!-- Bukti Pembayaran -->
    @if($pesanan->bukti_pembayaran)
    <div class="card border-0 shadow-sm mt-4">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="image" class="me-2"></i>Bukti Pembayaran
        </h5>
      </div>
      <div class="card-body text-center">
        <img src="{{ asset('storage/payments/' . $pesanan->bukti_pembayaran) }}" 
             alt="Bukti Pembayaran" 
             class="img-fluid rounded"
             style="max-height: 300px;">
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

