@extends('layouts.corona')

@section('title', 'Edit Portofolio')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Edit Album</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.portofolio.index') }}">Portofolio</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-pencil-square me-2"></i>Edit Album</span>
                </div>

                <form action="{{ route('fotografer.portofolio.update', $portofolio->id_portofolio) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Judul Album <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul', $portofolio->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" 
                                            {{ old('kategori_id', $portofolio->kategori_id) == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3">{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Images -->
                    <div class="mb-3">
                        <label class="form-label">Foto Saat Ini ({{ $portofolio->gambars->count() }} foto)</label>
                        <div class="row g-3">
                            @foreach($portofolio->gambars as $gambar)
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="position-relative" style="border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%); min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('storage/' . $gambar->file_gambar) }}" 
                                         class="w-100 h-100" 
                                         style="object-fit: contain; object-position: center; max-height: 150px; width: auto; height: auto; padding: 8px;">
                                    
                                    @if($gambar->is_cover)
                                    <span class="position-absolute top-0 start-0 m-2 badge" style="background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); color: #fff; font-size: 10px; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                                        <i class="bi bi-star-fill me-1"></i> Cover
                                    </span>
                                    @endif
                                    
                                    <div class="position-absolute bottom-0 start-0 end-0 p-2 d-flex gap-1" style="background: rgba(0,0,0,0.8); backdrop-filter: blur(10px);">
                                        @if(!$gambar->is_cover)
                                        <form action="{{ route('fotografer.portofolio.gambar.setCover', $gambar->id_gambar) }}" method="POST" class="flex-fill">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success w-100" style="font-size: 11px; padding: 6px;" title="Jadikan Cover">
                                                <i class="bi bi-star me-1"></i> Cover
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('fotografer.portofolio.gambar.destroy', $gambar->id_gambar) }}" method="POST" class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100" style="font-size: 11px; padding: 6px;" 
                                                    onclick="return confirm('Hapus foto ini?')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add More Images -->
                    <div class="mb-3">
                        <label class="form-label">Tambah Foto Baru</label>
                        <input type="file" name="gambars[]" class="form-control @error('gambars.*') is-invalid @enderror" 
                               multiple accept="image/*">
                        <small class="text-secondary">Opsional. Pilih beberapa foto sekaligus untuk menambahkan ke album ini.</small>
                        @error('gambars.*')
                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Foto</label>
                            <input type="date" name="tanggal_foto" class="form-control @error('tanggal_foto') is-invalid @enderror" 
                                   value="{{ old('tanggal_foto', $portofolio->tanggal_foto ? $portofolio->tanggal_foto->format('Y-m-d') : '') }}">
                            @error('tanggal_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                                   value="{{ old('lokasi', $portofolio->lokasi) }}">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" 
                                   id="is_featured" {{ old('is_featured', $portofolio->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="bi bi-star-fill text-warning me-1"></i>
                                Tandai sebagai Featured
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Album
                        </button>
                        <a href="{{ route('fotografer.portofolio.index') }}" class="btn btn-outline-secondary">
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
                <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Info Album</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-secondary">ID</td>
                        <td>{{ $portofolio->id_portofolio }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Jumlah Foto</td>
                        <td>{{ $portofolio->gambars->count() }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Status</td>
                        <td>
                            @if($portofolio->is_featured)
                                <span class="badge badge-warning"><i class="bi bi-star-fill me-1"></i> Featured</span>
                            @else
                                <span class="badge badge-secondary">Normal</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Dibuat</td>
                        <td>{{ $portofolio->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-danger">
            <div class="card-body">
                <h6 class="mb-3 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Zona Bahaya</h6>
                <p class="text-secondary" style="font-size: 13px;">Menghapus album akan menghapus semua foto di dalamnya.</p>
                <form action="{{ route('fotografer.portofolio.destroy', $portofolio->id_portofolio) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus album ini beserta semua fotonya?')">
                        <i class="bi bi-trash me-1"></i> Hapus Album
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
