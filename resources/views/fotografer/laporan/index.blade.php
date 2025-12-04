@extends('layouts.corona')

@section('title', 'Laporan Kinerja')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Laporan Kinerja</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <span><i class="bi bi-bar-chart me-2"></i>Daftar Laporan Kegiatan</span>
                    <a href="{{ route('fotografer.laporan.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Buat Laporan
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Ringkasan</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporan as $row)
                            <tr>
                                <td>{{ $row->id_laporan }}</td>
                                <td>
                                    <strong>{{ $row->judul }}</strong>
                                </td>
                                <td>
                                    <i class="bi bi-calendar3 me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                                </td>
                                <td>{{ Str::limit($row->ringkasan, 50) }}</td>
                                <td>
                                    @if($row->foto_kegiatan)
                                        <img src="{{ asset('storage/' . $row->foto_kegiatan) }}" 
                                             alt="Foto" class="img-preview" style="max-width: 60px; max-height: 60px;">
                                    @else
                                        <span class="text-secondary"><i class="bi bi-image"></i> Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('fotografer.laporan.edit', $row->id_laporan) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('fotografer.laporan.destroy', $row->id_laporan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-file-earmark-x"></i>
                                        <h5>Belum ada laporan</h5>
                                        <p>Mulai buat laporan kegiatan Anda</p>
                                        <a href="{{ route('fotografer.laporan.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i> Buat Laporan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
