@extends('layouts.corona')

@section('title', 'Buat Laporan')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Buat Laporan Baru</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.laporan.index') }}">Laporan</a></li>
            <li class="breadcrumb-item active">Buat</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-file-earmark-plus me-2"></i>Form Laporan Kegiatan</span>
                </div>

                <form action="{{ route('fotografer.laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul') }}" placeholder="Masukkan judul laporan" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan Kegiatan <span class="text-danger">*</span></label>
                        <textarea name="ringkasan" class="form-control @error('ringkasan') is-invalid @enderror" 
                                  rows="5" placeholder="Tuliskan ringkasan kegiatan yang dilakukan..." required>{{ old('ringkasan') }}</textarea>
                        @error('ringkasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Foto Kegiatan</label>
                        <input type="file" name="foto_kegiatan" class="form-control @error('foto_kegiatan') is-invalid @enderror" 
                               accept="image/*">
                        <small class="text-secondary">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        @error('foto_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan Laporan
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
                <h6 class="mb-3"><i class="bi bi-lightbulb me-2"></i>Tips Menulis Laporan</h6>
                <ul class="text-secondary" style="font-size: 13px;">
                    <li class="mb-2">Gunakan judul yang jelas dan deskriptif</li>
                    <li class="mb-2">Tuliskan ringkasan kegiatan secara singkat namun informatif</li>
                    <li class="mb-2">Sertakan foto kegiatan sebagai dokumentasi</li>
                    <li>Pastikan tanggal sesuai dengan tanggal kegiatan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
