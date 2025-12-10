@extends('layouts-fotografer.corona')

@section('title', 'Tambah Kategori')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Tambah Kategori</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.portofolio.kategori.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-folder-plus me-2"></i>Form Kategori Baru</span>
                </div>

                <form action="{{ route('fotografer.portofolio.kategori.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                               value="{{ old('nama_kategori') }}" placeholder="Contoh: Wedding, Graduation, Pre-Wedding" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3" placeholder="Deskripsi singkat tentang kategori ini">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" 
                               accept="image/*" id="coverInput">
                        <small class="text-secondary">Opsional. Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div id="coverPreview" class="mt-3" style="display: none;">
                            <p class="text-secondary mb-2">Preview:</p>
                            <img src="" alt="Preview" style="max-width: 200px; border-radius: 8px;">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan Kategori
                        </button>
                        <a href="{{ route('fotografer.portofolio.kategori.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-lightbulb me-2"></i>Contoh Kategori</h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge badge-primary">Wedding</span>
                    <span class="badge badge-primary">Pre-Wedding</span>
                    <span class="badge badge-primary">Graduation</span>
                    <span class="badge badge-primary">Birthday</span>
                    <span class="badge badge-primary">Event</span>
                    <span class="badge badge-primary">Product</span>
                    <span class="badge badge-primary">Fashion</span>
                    <span class="badge badge-primary">Portrait</span>
                    <span class="badge badge-primary">Landscape</span>
                    <span class="badge badge-primary">Maternity</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('coverInput').addEventListener('change', function(e) {
    const preview = document.getElementById('coverPreview');
    const img = preview.querySelector('img');
    
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(e.target.files[0]);
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush
@endsection

