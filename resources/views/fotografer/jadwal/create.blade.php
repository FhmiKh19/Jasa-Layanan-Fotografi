@extends('layouts.corona')

@section('title', 'Tambah Jadwal')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Tambah Jadwal Baru</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.jadwal.index') }}">Jadwal</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-calendar-plus me-2"></i>Form Jadwal Pemotretan</span>
                </div>

                <form action="{{ route('fotografer.jadwal.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Acara <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_acara" class="form-control @error('tgl_acara') is-invalid @enderror" 
                                   value="{{ old('tgl_acara') }}" required>
                            @error('tgl_acara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   value="{{ old('waktu_mulai') }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   value="{{ old('waktu_selesai') }}" required>
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Klien <span class="text-danger">*</span></label>
                            <input type="text" name="nama_klien" class="form-control @error('nama_klien') is-invalid @enderror" 
                                   value="{{ old('nama_klien') }}" placeholder="Masukkan nama klien" required>
                            @error('nama_klien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Layanan <span class="text-danger">*</span></label>
                            <select name="id_layanan" class="form-select @error('id_layanan') is-invalid @enderror" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id_layanan }}" {{ old('id_layanan') == $layanan->id_layanan ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Acara <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                  rows="3" placeholder="Masukkan alamat lengkap lokasi acara" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" 
                                  placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Simpan Jadwal
                        </button>
                        <a href="{{ route('fotografer.jadwal.index') }}" class="btn btn-outline-secondary">
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
                <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Panduan</h6>
                <ul class="text-secondary" style="font-size: 13px;">
                    <li class="mb-2">Pastikan tanggal dan waktu yang dipilih tidak bentrok dengan jadwal lain</li>
                    <li class="mb-2">Pilih layanan sesuai dengan paket yang dipesan klien</li>
                    <li class="mb-2">Masukkan alamat lengkap untuk memudahkan navigasi</li>
                    <li>Gunakan catatan untuk informasi tambahan seperti tema acara</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
