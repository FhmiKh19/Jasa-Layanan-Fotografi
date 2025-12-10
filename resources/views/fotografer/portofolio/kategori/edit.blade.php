@extends('layouts-fotografer.corona')

@section('title', 'Edit Kategori')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Edit Kategori</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.portofolio.kategori.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-pencil-square me-2"></i>Edit Kategori</span>
                </div>

                <form action="{{ route('fotografer.portofolio.kategori.update', $kategori->id_kategori) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" 
                               accept="image/*" id="coverInput">
                        <small class="text-secondary">Kosongkan jika tidak ingin mengubah</small>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($kategori->cover_image)
                        <div class="mt-2">
                            <p class="text-secondary mb-2">Cover saat ini:</p>
                            <img src="{{ asset('storage/' . $kategori->cover_image) }}" alt="{{ $kategori->nama_kategori }}" 
                                 style="max-width: 200px; border-radius: 8px;">
                        </div>
                        @endif
                        
                        <div id="coverPreview" class="mt-3" style="display: none;">
                            <p class="text-secondary mb-2">Preview cover baru:</p>
                            <img src="" alt="Preview" style="max-width: 200px; border-radius: 8px;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" 
                                   id="is_active" {{ old('is_active', $kategori->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kategori Aktif
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Kategori
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
                <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Info Kategori</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-secondary">ID</td>
                        <td>{{ $kategori->id_kategori }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Slug</td>
                        <td><code>{{ $kategori->slug }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Jumlah Album</td>
                        <td>{{ $kategori->jumlah_portofolio }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Dibuat</td>
                        <td>{{ $kategori->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-danger">
            <div class="card-body">
                <h6 class="mb-3 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Zona Bahaya</h6>
                <p class="text-secondary" style="font-size: 13px;">Menghapus kategori akan menghapus semua portofolio di dalamnya.</p>
                <form action="{{ route('fotografer.portofolio.kategori.destroy', $kategori->id_kategori) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus kategori ini? Semua portofolio akan ikut terhapus!')">
                        <i class="bi bi-trash me-1"></i> Hapus Kategori
                    </button>
                </form>
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

