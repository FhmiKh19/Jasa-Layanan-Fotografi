<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 80px;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1920&h=1080&fit=crop') center/cover no-repeat;
            filter: brightness(0.5);
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.7) 0%, rgba(101, 67, 33, 0.7) 50%, rgba(62, 39, 35, 0.7) 100%);
            z-index: 1;
        }
        
        .container {
            position: relative;
            z-index: 2;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }
        
        .page-header h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .profile-header-card {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.9), rgba(101, 67, 33, 0.9));
            border-radius: 20px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
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
            border-color: #8d5524;
            box-shadow: 0 0 0 3px rgba(141, 85, 36, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #8d5524, #c08552);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(141, 85, 36, 0.3);
        }

        .btn-secondary {
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .upload-area {
            border: 2px dashed #8d5524;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-area:hover {
            background: #f0f0f0;
            border-color: #c08552;
        }

        .upload-area.dragover {
            background: #e8eaf6;
            border-color: #8d5524;
        }

        .info-badge {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-left: 4px solid #8d5524;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials-pelanggan.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="page-header">
            <h2><i class="fas fa-user-circle me-2"></i>Profil Saya</h2>
            <p>Kelola informasi profil Anda</p>
        </div>

        {{-- Profile Header --}}
        <div class="profile-header-card">
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

        {{-- Info Badge --}}
        <div class="info-badge">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            <strong>Informasi:</strong> Anda dapat mengubah informasi profil Anda di bawah ini. 
            Password hanya perlu diisi jika ingin mengubah password.
        </div>

        {{-- Profile Form --}}
        <div class="profile-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-user-edit me-2"></i>Edit Profil
            </h5>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    {{-- Foto Profil --}}
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
                                <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px; border-radius: 10px;">
                            </div>
                        </div>
                        @error('foto_profil')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Pengguna --}}
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

                    {{-- Username --}}
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

                    {{-- Email --}}
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

                    {{-- No. HP --}}
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

                    {{-- Password Baru --}}
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

                    {{-- Konfirmasi Password --}}
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation"
                               placeholder="Ulangi password baru">
                    </div>
                </div>

                {{-- Informasi Akun --}}
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

                {{-- Action Buttons --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ================== FOOTER ================== --}}
    @include('partials-pelanggan.footer')
    {{-- ============================================ --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>

