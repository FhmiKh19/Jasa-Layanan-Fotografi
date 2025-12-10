@extends('layouts-fotografer.corona')

@section('title', 'Upload Portofolio')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Upload Album Baru</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.portofolio.index') }}">Portofolio</a></li>
            <li class="breadcrumb-item active">Upload</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-cloud-upload me-2"></i>Upload Album Portofolio</span>
                </div>

                @if($kategoris->count() == 0)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Belum ada kategori. Silakan hubungi admin untuk membuat kategori terlebih dahulu.
                </div>
                @else
                <form action="{{ route('fotografer.portofolio.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    
                    <!-- Debug: Pastikan form mengirim data -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Judul Foto/Gambar <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul') }}" placeholder="Contoh: Wedding John & Jane" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            @if($kategoris->count() > 0)
                            <select name="kategori" id="kategoriSelect" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ is_object($kategori) ? $kategori->nama_kategori : $kategori }}" 
                                            {{ old('kategori', request('kategori')) == (is_object($kategori) ? $kategori->nama_kategori : $kategori) ? 'selected' : '' }}>
                                        {{ is_object($kategori) ? $kategori->nama_kategori : $kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Kategori dibuat oleh admin</small>
                            @else
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum ada kategori. Silakan hubungi admin untuk membuat kategori terlebih dahulu.
                            </div>
                            @endif
                            @error('kategori')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3" placeholder="Ceritakan tentang sesi foto ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label class="form-label">Upload Gambar <span class="text-danger">*</span></label>
                        <div class="upload-zone" id="uploadZone" style="border: 2px dashed var(--border-color); border-radius: 10px; padding: 40px; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                            <i class="bi bi-cloud-upload" style="font-size: 48px; color: var(--text-secondary);"></i>
                            <p class="text-secondary mt-2 mb-0">Klik atau drag & drop gambar ke sini</p>
                            <p class="text-secondary" style="font-size: 12px;">Format: JPG, PNG, GIF, WebP. Maksimal 2MB</p>
                            <input type="file" name="gambar" id="gambarInput" accept="image/*" 
                                   class="d-none @error('gambar') is-invalid @enderror" required>
                        </div>
                        @error('gambar')
                            <div class="text-danger mt-2" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview Container -->
                        <div id="previewContainer" class="mt-3" style="display: none;">
                            <img id="previewImage" src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px; border: 1px solid var(--border-color);">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Foto</label>
                            <input type="date" name="tanggal_foto" id="tanggalFotoInput" class="form-control @error('tanggal_foto') is-invalid @enderror" 
                                   value="{{ old('tanggal_foto') }}">
                            @error('tanggal_foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-secondary d-block mt-1">Opsional. Tanggal kapan foto diambil</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                                   value="{{ old('lokasi') }}" placeholder="Contoh: Bali, Indonesia">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" 
                                   id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="bi bi-star-fill text-warning me-1"></i>
                                Tandai sebagai Featured
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-cloud-upload me-1"></i> Upload Album
                        </button>
                        <a href="{{ route('fotografer.portofolio.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-lightbulb me-2"></i>Tips Upload</h6>
                <ul class="text-secondary" style="font-size: 13px;">
                    <li class="mb-2">Anda bisa upload <strong>banyak foto sekaligus</strong></li>
                    <li class="mb-2">Foto pertama akan menjadi cover album</li>
                    <li class="mb-2">Gunakan foto berkualitas tinggi</li>
                    <li class="mb-2">Pilih kategori yang sesuai</li>
                    <li>Tandai sebagai featured untuk highlight</li>
                </ul>
            </div>
        </div>

        @if($kategoris->count() > 0)
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-folder me-2"></i>Kategori Tersedia</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($kategoris as $kategori)
                    <span class="badge badge-primary">{{ $kategori }}</span>
                    @endforeach
                </div>
                <small class="text-muted d-block mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Kategori dibuat oleh admin
                </small>
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.upload-zone:hover {
    border-color: var(--primary-color) !important;
    background: rgba(108, 92, 231, 0.05);
}
.upload-zone.dragover {
    border-color: var(--primary-color) !important;
    background: rgba(108, 92, 231, 0.1);
}
.preview-item {
    position: relative;
}
.preview-item .remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(252, 66, 74, 0.9);
    border: none;
    color: white;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Fix form select dan date untuk theme dark */
select.form-select {
    background-color: #191c24 !important;
    color: #ffffff !important;
    border: 1px solid #2c2e33 !important;
    padding: 12px 35px 12px 15px !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236c7293' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px 12px !important;
}

select.form-select:focus {
    border-color: #6c5ce7 !important;
    box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2) !important;
    outline: none !important;
}

select.form-select option {
    background-color: #191c24 !important;
    color: #ffffff !important;
    padding: 10px !important;
}

input[type="date"].form-control {
    background-color: #191c24 !important;
    color: #ffffff !important;
    border: 1px solid #2c2e33 !important;
    padding: 12px 15px !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    color-scheme: dark !important;
}

input[type="date"].form-control:focus {
    border-color: #6c5ce7 !important;
    box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2) !important;
    outline: none !important;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(0.5) !important;
    cursor: pointer !important;
}
</style>
@endpush

@push('scripts')
<script>
const uploadZone = document.getElementById('uploadZone');
const gambarInput = document.getElementById('gambarInput');
const previewContainer = document.getElementById('previewContainer');
const previewImage = document.getElementById('previewImage');

// Click to upload
uploadZone.addEventListener('click', () => gambarInput.click());

// Drag & drop
uploadZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadZone.style.borderColor = '#6c5ce7';
    uploadZone.style.backgroundColor = 'rgba(108, 92, 231, 0.1)';
});

uploadZone.addEventListener('dragleave', () => {
    uploadZone.style.borderColor = 'var(--border-color)';
    uploadZone.style.backgroundColor = 'transparent';
});

uploadZone.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadZone.style.borderColor = 'var(--border-color)';
    uploadZone.style.backgroundColor = 'transparent';
    handleFile(e.dataTransfer.files[0]);
});

// File input change
gambarInput.addEventListener('change', (e) => {
    if (e.target.files && e.target.files[0]) {
        handleFile(e.target.files[0]);
    }
});

function handleFile(file) {
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Pastikan select kategori bisa diklik
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategoriSelect');
    if (kategoriSelect) {
        // Pastikan select bisa diklik
        kategoriSelect.style.pointerEvents = 'auto';
        kategoriSelect.style.zIndex = '10';
        kategoriSelect.style.position = 'relative';
        
        // Debug: Log kategori yang tersedia
        console.log('Kategori Select:', {
            element: kategoriSelect,
            options: kategoriSelect.options.length,
            selected: kategoriSelect.value
        });
        
        // Event listener untuk perubahan kategori
        kategoriSelect.addEventListener('change', function() {
            console.log('Kategori dipilih:', this.value);
        });
    }
});

// Validasi form sebelum submit
const uploadForm = document.getElementById('uploadForm');
if (uploadForm) {
    uploadForm.addEventListener('submit', function(e) {
        const kategoriSelect = document.getElementById('kategoriSelect');
        const gambarInput = document.getElementById('gambarInput');
        
        // Validasi kategori
        if (!kategoriSelect || !kategoriSelect.value || kategoriSelect.value === '') {
            e.preventDefault();
            alert('Pilih kategori terlebih dahulu!');
            if (kategoriSelect) kategoriSelect.focus();
            return false;
        }
        
        // Validasi gambar
        if (!gambarInput || !gambarInput.files || gambarInput.files.length === 0) {
            e.preventDefault();
            alert('Pilih minimal 1 foto untuk diupload!');
            return false;
        }
        
        // Debug: Log form data
        console.log('Form Data:', {
            kategori_id: kategoriSelect.value,
            tanggal_foto: document.getElementById('tanggalFotoInput')?.value,
            judul: document.querySelector('input[name="judul"]')?.value,
            gambar_count: gambarInput.files.length
        });
        
        // Disable submit button untuk prevent double submit
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Mengupload...';
        }
        
        return true;
    });
}
</script>
@endpush
@endsection
