@extends('layouts.app')

@section('title', 'Tambah User')

@push('custom-styles')
<style>
  .form-card {
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="user-plus" class="me-2 text-primary"></i>Tambah User Baru
    </h3>
    <p class="text-muted mb-0">Buat akun user baru (Admin, Fotografer, atau Pelanggan)</p>
  </div>
  <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
    <i data-lucide="arrow-left" class="me-2" style="width: 1em; height: 1em;"></i>Kembali
  </a>
</div>

<div class="row">
  <div class="col-md-8 mx-auto">
    <div class="card form-card border-0 shadow-sm">
      <div class="card-header bg-white">
        <h5 class="fw-bold mb-0 d-flex align-items-center">
          <i data-lucide="users" class="me-2"></i>Form Tambah User
        </h5>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i data-lucide="check-circle" class="me-2" style="width: 1em; height: 1em;"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i data-lucide="alert-circle" class="me-2" style="width: 1em; height: 1em;"></i>
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf

          <div class="row">
            <!-- Role -->
            <div class="col-md-12 mb-3">
              <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
              <select name="role" 
                      class="form-select @error('role') is-invalid @enderror" 
                      required>
                <option value="">Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="fotografer" {{ old('role') == 'fotografer' ? 'selected' : '' }}>Fotografer</option>
                <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
              </select>
              @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row">
            <!-- Nama Pengguna -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" 
                     name="nama_pengguna" 
                     class="form-control @error('nama_pengguna') is-invalid @enderror" 
                     value="{{ old('nama_pengguna') }}" 
                     required>
              @error('nama_pengguna')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Username -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
              <input type="text" 
                     name="username" 
                     class="form-control @error('username') is-invalid @enderror" 
                     value="{{ old('username') }}" 
                     required>
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row">
            <!-- Email -->
            <div class="col-md-12 mb-3">
              <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
              <input type="email" 
                     name="email" 
                     class="form-control @error('email') is-invalid @enderror" 
                     value="{{ old('email') }}" 
                     required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="row">
            <!-- Password -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
              <input type="password" 
                     name="password" 
                     class="form-control @error('password') is-invalid @enderror" 
                     required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="text-muted">Minimal 8 karakter</small>
            </div>

            <!-- Konfirmasi Password -->
            <div class="col-md-6 mb-3">
              <label class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
              <input type="password" 
                     name="password_confirmation" 
                     class="form-control" 
                     required>
            </div>
          </div>

          <div class="alert alert-info d-flex align-items-center">
            <i data-lucide="info" class="me-2" style="width: 1.2em; height: 1.2em;"></i>
            <div>
              <strong>Catatan:</strong> Akun yang dibuat akan otomatis memiliki status <strong>Aktif</strong>.
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
              <i data-lucide="save" class="me-2" style="width: 1em; height: 1em;"></i>Tambah User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

