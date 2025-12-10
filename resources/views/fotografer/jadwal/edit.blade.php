@extends('layouts-fotografer.corona')

@section('title', 'Edit Jadwal')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Edit Jadwal</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fotografer.jadwal.index') }}">Jadwal</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <span><i class="bi bi-pencil-square me-2"></i>Edit Jadwal Pemotretan</span>
                </div>

                <form action="{{ route('fotografer.jadwal.update', $jadwal->id_jadwal) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Acara <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_acara" class="form-control @error('tgl_acara') is-invalid @enderror" 
                                   value="{{ old('tgl_acara', $jadwal->tgl_acara) }}" required>
                            @error('tgl_acara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   value="{{ old('waktu_mulai', $jadwal->waktu_mulai) }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   value="{{ old('waktu_selesai', $jadwal->waktu_selesai) }}" required>
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Klien <span class="text-danger">*</span></label>
                            <input type="text" name="nama_klien" class="form-control @error('nama_klien') is-invalid @enderror" 
                                   value="{{ old('nama_klien', $jadwal->nama_klien) }}" placeholder="Masukkan nama klien" required>
                            @error('nama_klien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Layanan <span class="text-danger">*</span></label>
                            <select name="id_layanan" class="form-select @error('id_layanan') is-invalid @enderror" required>
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id_layanan }}" 
                                            {{ old('id_layanan', $jadwal->id_layanan) == $layanan->id_layanan ? 'selected' : '' }}>
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
                                  rows="3" placeholder="Masukkan alamat lengkap lokasi acara" required>{{ old('alamat', $jadwal->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" 
                                  placeholder="Catatan tambahan (opsional)">{{ old('catatan', $jadwal->catatan) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Jadwal
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
                <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Info Jadwal</h6>
                <table class="table table-sm">
                    <tr>
                        <td class="text-secondary">ID Jadwal</td>
                        <td>{{ $jadwal->id_jadwal }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Status</td>
                        <td><span class="badge badge-info">{{ ucfirst($jadwal->status) }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Dibuat</td>
                        <td>{{ $jadwal->created_at ? $jadwal->created_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
