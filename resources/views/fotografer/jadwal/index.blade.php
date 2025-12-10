@extends('layouts-fotografer.corona')

@section('title', 'Kelola Jadwal')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h3>Kelola Jadwal</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Jadwal</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <span><i class="bi bi-calendar-event me-2"></i>Daftar Jadwal Pemotretan</span>
                    <small class="text-muted">Jadwal otomatis dibuat dari pesanan yang dikonfirmasi</small>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Acara</th>
                                <th>Waktu</th>
                                <th>Nama Klien</th>
                                <th>Layanan</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $jadwal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <i class="bi bi-calendar3 me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($jadwal->tgl_acara)->format('d M Y') }}
                                </td>
                                <td>
                                    <i class="bi bi-clock me-1 text-info"></i>
                                    {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}
                                </td>
                                <td>{{ $jadwal->nama_klien }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $jadwal->layanan->nama_layanan ?? '-' }}</span>
                                </td>
                                <td>{{ Str::limit($jadwal->alamat, 30) }}</td>
                                <td>
                                    @if($jadwal->status == 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($jadwal->status == 'terjadwal')
                                        <span class="badge badge-info">Terjadwal</span>
                                    @else
                                        <span class="badge badge-warning">{{ ucfirst($jadwal->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('fotografer.pesanan.show', $jadwal->id_pesanan) }}" class="btn btn-sm btn-primary" title="Lihat Detail Pesanan">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-calendar-x"></i>
                                        <h5>Belum ada jadwal</h5>
                                        <p>Jadwal akan otomatis muncul ketika Anda mengkonfirmasi pesanan dari pelanggan</p>
                                        <a href="{{ route('fotografer.pesanan.index') }}" class="btn btn-primary">
                                            <i class="bi bi-inbox me-1"></i> Lihat Pesanan
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
