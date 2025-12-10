@extends('layouts.app')

@section('title', 'Manajemen User')

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
  .stat-card.stat-danger { --stat-color-1: #dc3545; --stat-color-2: #c82333; }
  .stat-card.stat-warning { --stat-color-1: #ffc107; --stat-color-2: #ff9800; }
  .stat-card.stat-info { --stat-color-1: #17a2b8; --stat-color-2: #138496; }

  .user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
  }

  .user-avatar:hover {
    border-color: #667eea;
    transform: scale(1.1);
  }

  .filter-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
  }

  .table-responsive {
    border-radius: 20px;
    overflow: hidden;
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
        <i data-lucide="users" class="me-2 text-primary"></i>Manajemen User
      </h3>
      <p class="text-muted mb-0">Kelola akun admin, fotografer dan pelanggan</p>
    </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-inline-flex align-items-center">
      <i data-lucide="user-plus" class="me-2" style="width: 1em; height: 1em;"></i>Tambah User
    </a>
  </div>
</div>

<!-- Success Message -->
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i data-lucide="check-circle" class="me-2" style="width: 1em; height: 1em;"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<!-- Error Message -->
@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i data-lucide="alert-circle" class="me-2" style="width: 1em; height: 1em;"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
  <div class="col-md-3">
    <div class="stat-card stat-primary">
      <div class="stat-icon-wrapper">
        <i data-lucide="users"></i>
      </div>
      <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
      <p class="stat-label mb-0">Total User</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-danger">
      <div class="stat-icon-wrapper">
        <i data-lucide="camera"></i>
      </div>
      <div class="stat-value">{{ $stats['admin'] ?? 0 }}</div>
      <p class="stat-label mb-0">Admin</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-warning">
      <div class="stat-icon-wrapper">
        <i data-lucide="camera"></i>
      </div>
      <div class="stat-value">{{ $stats['fotografer'] ?? 0 }}</div>
      <p class="stat-label mb-0">Fotografer</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="stat-card stat-info">
      <div class="stat-icon-wrapper">
        <i data-lucide="user"></i>
      </div>
      <div class="stat-value">{{ $stats['pelanggan'] ?? 0 }}</div>
      <p class="stat-label mb-0">Pelanggan</p>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
      <div class="col-md-4">
        <label class="form-label fw-bold">Cari User</label>
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="Nama, username, atau email..."
               value="{{ request('search') }}">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-bold">Filter Role</label>
        <select name="role" class="form-select">
          <option value="">Semua Role</option>
          <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="fotografer" {{ request('role') == 'fotografer' ? 'selected' : '' }}>Fotografer</option>
          <option value="pelanggan" {{ request('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
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

<!-- Table User -->
<div class="card">
  <div class="card-header">
    <h5 class="mb-0 d-flex align-items-center">
      <i data-lucide="list" class="me-2"></i>Daftar User
      <span class="badge bg-light text-dark ms-2">{{ $users->total() }} User</span>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 60px;">Foto</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Bergabung</th>
            <th style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr>
              <td>
                @if($user->foto_profil)
                  <img src="{{ asset('storage/profiles/' . $user->foto_profil) }}" 
                       alt="Foto" 
                       class="user-avatar">
                @else
                  <div class="user-avatar bg-light d-flex align-items-center justify-content-center">
                    <i data-lucide="user" class="text-muted"></i>
                  </div>
                @endif
              </td>
              <td>
                <strong>{{ $user->nama_pengguna }}</strong>
              </td>
              <td>
                <span class="text-muted">{{ '@' . $user->username }}</span>
              </td>
              <td>{{ $user->email }}</td>
              <td>
                @if($user->role === 'admin')
                  <span class="badge bg-danger d-inline-flex align-items-center">
                    <i data-lucide="camera" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Admin
                  </span>
                @elseif($user->role === 'fotografer')
                  <span class="badge bg-warning text-dark d-inline-flex align-items-center">
                    <i data-lucide="camera" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Fotografer
                  </span>
                @else
                  <span class="badge bg-info d-inline-flex align-items-center">
                    <i data-lucide="user" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Pelanggan
                  </span>
                @endif
              </td>
              <td>
                @if($user->status_akun === 'aktif')
                  <span class="badge bg-success d-inline-flex align-items-center">
                    <i data-lucide="check-circle" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Aktif
                  </span>
                @elseif($user->status_akun === 'non-aktif')
                  <span class="badge bg-secondary d-inline-flex align-items-center">
                    <i data-lucide="pause-circle" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Non-Aktif
                  </span>
                @else
                  <span class="badge bg-danger d-inline-flex align-items-center">
                    <i data-lucide="ban" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Diblokir
                  </span>
                @endif
              </td>
              <td>
                <small class="text-muted">
                  {{ $user->tgl_dibuat->format('d M Y') }}
                </small>
              </td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('admin.users.edit', $user->id_pengguna) }}" 
                     class="btn btn-action btn-outline-primary"
                     title="Edit">
                    <i data-lucide="edit"></i>Edit
                  </a>
                  <form action="{{ route('admin.users.destroy', $user->id_pengguna) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-action btn-outline-danger"
                            onclick="return confirm('Yakin ingin menghapus akun {{ $user->nama_pengguna }}? Tindakan ini tidak dapat dibatalkan!')"
                            title="Hapus">
                      <i data-lucide="trash-2"></i>Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <i data-lucide="inbox" class="text-muted mb-3" style="width: 3rem; height: 3rem;"></i>
                <p class="text-muted">Tidak ada user ditemukan</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($users->hasPages())
    <div class="card-footer bg-white">
      {{ $users->links() }}
    </div>
  @endif
</div>
@endsection

