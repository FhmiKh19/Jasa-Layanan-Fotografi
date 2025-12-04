@extends('layouts.corona')

@section('title', 'Edit Laporan')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Edit Laporan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.laporan.index') }}">Laporan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-pencil-square me-2"></i>Edit Laporan Kegiatan</span>
                </div>

                <form action="{{ route('fotografer.laporan.update', $laporan->id_laporan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul', $laporan->judul) }}" placeholder="Masukkan judul laporan" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal', $laporan->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan Kegiatan <span class="text-danger">*</span></label>
                        <textarea name="ringkasan" class="form-control @error('ringkasan') is-invalid @enderror" 
                                  rows="5" placeholder="Tuliskan ringkasan kegiatan yang dilakukan..." required>{{ old('ringkasan', $laporan->ringkasan) }}</textarea>
                        @error('ringkasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto Kegiatan</label>
                        <input type="file" name="foto_kegiatan" class="form-control @error('foto_kegiatan') is-invalid @enderror" 
                               accept="image/*">
                        <small class="text-secondary">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</small>
                        @error('foto_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($laporan->foto_kegiatan)
                        <div class="mt-2">
                            <p class="text-secondary mb-2">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $laporan->foto_kegiatan) }}" alt="Foto" class="img-preview">
                        </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Laporan
                        </button>
                        <a href="{{ route('fotografer.laporan.index') }}" class="btn btn-outline-secondary">
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
                <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Info Laporan</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-secondary">ID Laporan</td>
                        <td>{{ $laporan->id_laporan }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Dibuat</td>
                        <td>{{ $laporan->created_at ? $laporan->created_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Diupdate</td>
                        <td>{{ $laporan->updated_at ? $laporan->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
