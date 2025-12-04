@extends('layouts.fotografer')

@section('content')
<div class="container py-4">
    <a href="{{ route('fotografer.laporan.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <div class="card">
        <div class="card-body">
            <h3>{{ $laporan->judul ?? 'Laporan' }}</h3>
            <p><strong>Tanggal:</strong> {{ $laporan->tanggal }}</p>
            <p>{{ $laporan->ringkasan }}</p>

            @if($laporan->foto_kegiatan)
                <div class="mt-3">
                    <img src="{{ asset('storage/'.$laporan->foto_kegiatan) }}" alt="foto" style="max-width:400px">
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
