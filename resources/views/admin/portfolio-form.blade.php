@extends('layouts.app')

@section('title', isset($portofolio) ? 'Edit Portofolio' : 'Tambah Portofolio')

@php
use Illuminate\Support\Facades\Storage;
@endphp

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
      <i data-lucide="{{ isset($portofolio) ? 'edit' : 'plus' }}" class="me-2 text-primary"></i>
      {{ isset($portofolio) ? 'Edit Portofolio' : 'Tambah Portofolio' }}
    </h3>
    <p class="text-muted mb-0">{{ isset($portofolio) ? 'Ubah informasi portofolio' : 'Tambahkan portofolio baru ke galeri' }}</p>
  </div>
  <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
    <i data-lucide="arrow-left" class="me-2" style="width: 1em; height: 1em;"></i>Kembali
  </a>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <form action="{{ isset($portofolio) ? route('admin.portfolio.update', $portofolio->id_portofolio) : route('admin.portfolio.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
          @csrf
          @if(isset($portofolio))
            @method('PUT')
          @endif

          <!-- Judul -->
          <div class="mb-3">
            <label class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
            <input type="text" 
                   name="judul" 
                   class="form-control @error('judul') is-invalid @enderror" 
                   value="{{ old('judul', $portofolio->judul ?? '') }}" 
                   required>
            @error('judul')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Kategori -->
          <div class="mb-3">
            <label class="form-label fw-bold">Kategori</label>
            <input type="text" 
                   name="kategori" 
                   class="form-control @error('kategori') is-invalid @enderror" 
                   value="{{ old('kategori', $portofolio->kategori ?? '') }}" 
                   placeholder="Contoh: Wedding, Prewedding, Product, dll">
            @error('kategori')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi</label>
            <textarea name="deskripsi" 
                      class="form-control @error('deskripsi') is-invalid @enderror" 
                      rows="5"
                      placeholder="Deskripsi portofolio...">{{ old('deskripsi', $portofolio->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Gambar -->
          <div class="mb-3">
            <label class="form-label fw-bold">Gambar</label>
            
            <!-- Preview gambar saat ini -->
            @if(isset($portofolio) && $portofolio->gambar)
              <div class="mb-3">
                <img src="{{ asset('storage/portfolio/' . $portofolio->gambar) }}" 
                     alt="Preview" 
                     class="image-preview show"
                     id="currentImage"
                     onerror="this.style.display='none';">
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
                Format: JPG, PNG, GIF (Max: 2MB)
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
              {{ isset($portofolio) ? 'Simpan Perubahan' : 'Tambah Portofolio' }}
            </button>
            <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary">
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
</script>
@endpush
@endsection

