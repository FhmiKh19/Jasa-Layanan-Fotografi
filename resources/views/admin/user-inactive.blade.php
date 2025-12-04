@extends('layouts.app')

@section('title', 'Akun Non-Aktif')

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

  .user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e0e0e0;
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
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
  }

  .table tbody tr {
    transition: all 0.2s ease;
  }

  .table tbody tr:hover {
    background-color: #f8f9fa;
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="user-x" class="me-2 text-secondary"></i>Akun Non-Aktif
    </h3>
    <p class="text-muted mb-0">Daftar akun yang telah dinonaktifkan</p>
  </div>
  <a href="{{ route('admin.users.index') }}" class="btn btn-primary d-inline-flex align-items-center">
    <i data-lucide="users" class="me-2" style="width: 1em; height: 1em;"></i>
    Akun Aktif ({{ $stats['aktif'] ?? 0 }})
  </a>
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
<div class="row g-3 mb-4">
  <div class="col-md-2">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Total Non-Aktif</h6>
      <h3 class="fw-bold text-secondary mb-0">{{ $stats['total'] ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Admin</h6>
      <h3 class="fw-bold text-danger mb-0">{{ $stats['admin'] ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Fotografer</h6>
      <h3 class="fw-bold text-warning mb-0">{{ $stats['fotografer'] ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Pelanggan</h6>
      <h3 class="fw-bold text-info mb-0">{{ $stats['pelanggan'] ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Akun Aktif</h6>
      <h3 class="fw-bold text-success mb-0">{{ $stats['aktif'] ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card stat-card text-center p-3">
      <h6 class="text-muted mb-2">Non-Aktif</h6>
      <h3 class="fw-bold text-secondary mb-0">{{ $stats['total'] ?? 0 }}</h3>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('admin.users.inactive') }}" class="row g-3">
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
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white">
    <h5 class="fw-bold mb-0 d-flex align-items-center">
      <i data-lucide="list" class="me-2"></i>Daftar Akun Non-Aktif
      <span class="badge bg-secondary ms-2">{{ $users->total() }} User</span>
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
                <span class="badge bg-secondary d-inline-flex align-items-center">
                  <i data-lucide="pause-circle" class="me-1" style="width: 0.9em; height: 0.9em;"></i>Non-Aktif
                </span>
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
                <p class="text-muted">Tidak ada akun non-aktif ditemukan</p>
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


