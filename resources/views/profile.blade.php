@extends('layouts.app')

@section('title', 'Profil Saya')

@push('custom-styles')
<style>
  .profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    margin-bottom: 2rem;
  }

  .profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 5px solid white;
    object-fit: cover;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  }

  .profile-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
  }

  .profile-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transform: translateY(-2px);
  }

  .form-label {
    font-weight: 600;
    color: #3E2723;
    margin-bottom: 0.5rem;
  }

  .form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    padding: 12px 16px;
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }

  .btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 10px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
  }

  .btn-secondary {
    border-radius: 10px;
    padding: 12px 30px;
    font-weight: 600;
  }

  .info-badge {
    background: #f8f9fa;
    border-left: 4px solid #667eea;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
  }

  .upload-area {
    border: 2px dashed #667eea;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .upload-area:hover {
    background: #f0f0f0;
    border-color: #764ba2;
  }

  .upload-area.dragover {
    background: #e8eaf6;
    border-color: #667eea;
  }
</style>
@endpush

@section('content')
<!-- Profile Header -->
<div class="profile-header">
  <div class="row align-items-center">
    <div class="col-md-3 text-center">
      <div class="position-relative d-inline-block">
        @if($user->foto_profil)
          <img src="{{ asset('storage/profiles/' . $user->foto_profil) }}" 
               alt="Foto Profil" 
               class="profile-avatar">
        @else
          <div class="profile-avatar bg-white d-flex align-items-center justify-content-center">
            <i class="fas fa-user fa-4x text-muted"></i>
          </div>
        @endif
      </div>
    </div>
    <div class="col-md-9">
      <h2 class="mb-2">{{ $user->nama_pengguna }}</h2>
      <p class="mb-1">
        <i class="fas fa-envelope me-2"></i>{{ $user->email }}
      </p>
      <p class="mb-1">
        <i class="fas fa-user-tag me-2"></i>{{ ucfirst($user->role) }}
      </p>
      <p class="mb-0">
        <i class="fas fa-calendar me-2"></i>
        Bergabung sejak {{ $user->tgl_dibuat->format('d M Y') }}
      </p>
    </div>
  </div>
</div>

<!-- Info Badge -->
<div class="info-badge">
  <i class="fas fa-info-circle me-2 text-primary"></i>
  <strong>Informasi:</strong> Anda dapat mengubah informasi profil Anda di bawah ini. 
  Password hanya perlu diisi jika ingin mengubah password.
</div>

<!-- Profile Form -->
<div class="card profile-card">
  <div class="card-header bg-white">
    <h5 class="fw-bold mb-0">
      <i class="fas fa-user-edit me-2"></i>Edit Profil
    </h5>
  </div>
  <div class="card-body">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
      @csrf
      @method('PUT')

      <div class="row">
        <!-- Foto Profil -->
        <div class="col-md-12 mb-4">
          <label class="form-label">Foto Profil</label>
          <div class="upload-area" onclick="document.getElementById('foto_profil').click()">
            <input type="file" 
                   name="foto_profil" 
                   id="foto_profil" 
                   accept="image/*" 
                   class="d-none"
                   onchange="previewImage(this)">
            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
            <p class="mb-0">
              <strong>Klik untuk upload foto</strong><br>
              <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
            </p>
            <div id="imagePreview" class="mt-3" style="display: none;">
              <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
            </div>
          </div>
          @error('foto_profil')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>

        <!-- Nama Pengguna -->
        <div class="col-md-6 mb-3">
          <label for="nama_pengguna" class="form-label">Nama Lengkap</label>
          <input type="text" 
                 class="form-control @error('nama_pengguna') is-invalid @enderror" 
                 id="nama_pengguna" 
                 name="nama_pengguna" 
                 value="{{ old('nama_pengguna', $user->nama_pengguna) }}" 
                 required>
          @error('nama_pengguna')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Username -->
        <div class="col-md-6 mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" 
                 class="form-control @error('username') is-invalid @enderror" 
                 id="username" 
                 name="username" 
                 value="{{ old('username', $user->username) }}" 
                 required>
          @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Email -->
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" 
                 class="form-control @error('email') is-invalid @enderror" 
                 id="email" 
                 name="email" 
                 value="{{ old('email', $user->email) }}" 
                 required>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- No. HP -->
        <div class="col-md-6 mb-3">
          <label for="no_hp" class="form-label">No. Handphone</label>
          <input type="text" 
                 class="form-control @error('no_hp') is-invalid @enderror" 
                 id="no_hp" 
                 name="no_hp" 
                 value="{{ old('no_hp', $user->no_hp) }}"
                 placeholder="08xxxxxxxxxx">
          @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password Baru -->
        <div class="col-md-6 mb-3">
          <label for="password" class="form-label">Password Baru (Opsional)</label>
          <input type="password" 
                 class="form-control @error('password') is-invalid @enderror" 
                 id="password" 
                 name="password"
                 placeholder="Kosongkan jika tidak ingin mengubah">
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <small class="text-muted">Minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka</small>
        </div>

        <!-- Konfirmasi Password -->
        <div class="col-md-6 mb-3">
          <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
          <input type="password" 
                 class="form-control" 
                 id="password_confirmation" 
                 name="password_confirmation"
                 placeholder="Ulangi password baru">
        </div>
      </div>

      <!-- Informasi Akun -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card bg-light">
            <div class="card-body">
              <h6 class="fw-bold mb-3">
                <i class="fas fa-info-circle me-2"></i>Informasi Akun
              </h6>
              <div class="row">
                <div class="col-md-4 mb-2">
                  <strong>Role:</strong> 
                  <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                </div>
                <div class="col-md-4 mb-2">
                  <strong>Status:</strong> 
                  <span class="badge bg-{{ $user->status_akun === 'aktif' ? 'success' : 'danger' }}">
                    {{ ucfirst($user->status_akun) }}
                  </span>
                </div>
                <div class="col-md-4 mb-2">
                  <strong>Bergabung:</strong> 
                  {{ $user->tgl_dibuat->format('d M Y') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="row mt-4">
        <div class="col-12">
          <button type="submit" class="btn btn-primary me-2">
            <i class="fas fa-save me-2"></i>Simpan Perubahan
          </button>
          <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Batal
          </a>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        previewImg.src = e.target.result;
        preview.style.display = 'block';
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Drag and drop
  const uploadArea = document.querySelector('.upload-area');
  const fileInput = document.getElementById('foto_profil');

  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
  });

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  ['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
      uploadArea.classList.add('dragover');
    }, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
      uploadArea.classList.remove('dragover');
    }, false);
  });

  uploadArea.addEventListener('drop', handleDrop, false);

  function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    previewImage(fileInput);
  }
</script>
@endpush

