@extends('layouts.app')

@section('title', isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan')

@push('custom-styles')
<style>
  .image-preview {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 12px;
    display: none;
  }

  .image-preview.show {
    display: block;
  }

  .upload-area {
    border: 2px dashed #ddd;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .upload-area:hover {
    border-color: #667eea;
    background-color: #f8f9ff;
  }

  .upload-area.dragover {
    border-color: #667eea;
    background-color: #f0f4ff;
  }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1 d-flex align-items-center">
      <i data-lucide="{{ isset($layanan) ? 'edit' : 'plus' }}" class="me-2 text-primary"></i>
      {{ isset($layanan) ? 'Edit Layanan' : 'Tambah Layanan' }}
    </h3>
    <p class="text-muted mb-0">{{ isset($layanan) ? 'Ubah informasi layanan' : 'Tambahkan layanan fotografi baru' }}</p>
  </div>
  <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
    <i data-lucide="arrow-left" class="me-2" style="width: 1em; height: 1em;"></i>Kembali
  </a>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
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

        <form action="{{ isset($layanan) && isset($layanan->id_layanan) ? route('admin.services.update', $layanan->id_layanan) : route('admin.services.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
          @csrf
          @if(isset($layanan))
            @method('PUT')
          @endif

          <!-- Nama Layanan -->
          <div class="mb-3">
            <label class="form-label fw-bold">Nama Layanan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama_layanan" 
                   class="form-control @error('nama_layanan') is-invalid @enderror" 
                   value="{{ old('nama_layanan', isset($layanan) ? $layanan->nama_layanan : '') }}" 
                   placeholder="Contoh: Paket Wedding, Paket Prewedding, Paket Tour, dll"
                   required>
            @error('nama_layanan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Harga -->
          <div class="mb-3">
            <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
            <input type="number" 
                   name="harga" 
                   class="form-control @error('harga') is-invalid @enderror" 
                   value="{{ old('harga', isset($layanan) ? $layanan->harga : '') }}" 
                   placeholder="0"
                   min="0"
                   step="1000"
                   required>
            @error('harga')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Masukkan harga dalam rupiah (tanpa titik atau koma)</small>
          </div>

          <!-- Status -->
          <div class="mb-3">
            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
            <select name="status" 
                    class="form-select @error('status') is-invalid @enderror" 
                    required>
              <option value="aktif" {{ old('status', (isset($layanan) && isset($layanan->status)) ? $layanan->status : 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="nonaktif" {{ old('status', (isset($layanan) && isset($layanan->status)) ? $layanan->status : '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Layanan aktif akan ditampilkan untuk dipilih pelanggan</small>
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi</label>
            <textarea name="deskripsi" 
                      class="form-control @error('deskripsi') is-invalid @enderror" 
                      rows="5"
                      placeholder="Deskripsi layanan, termasuk apa saja yang termasuk dalam paket...">{{ old('deskripsi', isset($layanan) ? $layanan->deskripsi : '') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Gambar -->
          <div class="mb-3">
            <label class="form-label fw-bold">Gambar Layanan</label>
            
            <!-- Preview gambar saat ini -->
            @if(isset($layanan) && isset($layanan->gambar) && !empty($layanan->gambar))
              <div class="mb-3">
                @php
                  $gambarPath = 'storage/layanan/' . $layanan->gambar;
                  $gambarUrl = asset($gambarPath);
                @endphp
                <img src="{{ $gambarUrl }}" 
                     alt="Preview" 
                     class="image-preview show"
                     id="currentImage"
                     onerror="console.error('Gambar tidak ditemukan: {{ $gambarPath }}'); this.style.display='none';">
              </div>
            @endif

            <!-- Preview gambar baru -->
            <img src="" alt="Preview" class="image-preview mb-3" id="imagePreview">

            <!-- Upload Area -->
            <div class="upload-area" id="uploadArea">
              <i data-lucide="upload" style="width: 3rem; height: 3rem;" class="text-muted mb-3"></i>
              <p class="mb-2">
                <strong>Klik untuk upload</strong> atau drag & drop
              </p>
              <p class="text-muted small mb-0">
                Format: JPG, PNG, GIF, WEBP (Max: 2MB)
              </p>
              <input type="file" 
                     name="gambar" 
                     id="gambarInput" 
                     class="d-none" 
                     accept="image/*"
                     onchange="previewImage(this)">
            </div>

            @error('gambar')
              <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
          </div>

          <!-- Submit Button -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
              <i data-lucide="save" class="me-2" style="width: 1em; height: 1em;"></i>
              {{ isset($layanan) ? 'Simpan Perubahan' : 'Tambah Layanan' }}
            </button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
              Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Upload area click
  document.getElementById('uploadArea').addEventListener('click', function() {
    document.getElementById('gambarInput').click();
  });

  // Drag and drop
  const uploadArea = document.getElementById('uploadArea');
  
  uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    uploadArea.classList.add('dragover');
  });

  uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
  });

  uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      document.getElementById('gambarInput').files = files;
      previewImage(document.getElementById('gambarInput'));
    }
  });

  // Preview image
  function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const currentImage = document.getElementById('currentImage');
    
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.add('show');
        if (currentImage) {
          currentImage.classList.remove('show');
        }
      };
      
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Format harga saat input
  document.querySelector('input[name="harga"]').addEventListener('input', function(e) {
    // Hapus format sebelumnya
    let value = e.target.value.replace(/[^\d]/g, '');
    e.target.value = value;
  });
</script>
@endpush
@endsection

