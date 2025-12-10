@extends('layouts-fotografer.corona')

@section('title', 'Chat')

@section('content')
<div class="page-header mb-4">
    <div>
        <h3 style="font-size: 30px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px; margin-bottom: 8px;">
            <i class="bi bi-chat-dots me-2" style="color: #6c5ce7;"></i>Chat
        </h3>
        <p class="text-white-50">Pilih pesanan untuk memulai chat</p>
    </div>
</div>

@if($pesanan->count() > 0)
<div class="row g-3">
    @foreach($pesanan as $p)
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('fotografer.chat.index', $p->id_pesanan) }}" class="text-decoration-none">
            <div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 16px; box-shadow: 0 8px 25px rgba(0,0,0,0.2); transition: all 0.3s; cursor: pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $p->pengguna->nama_pengguna }}</h6>
                            <small class="text-muted">{{ $p->layanan->nama_layanan }}</small>
                        </div>
                        @if($p->unread_count > 0)
                            <span class="badge bg-danger rounded-pill">{{ $p->unread_count }}</span>
                        @endif
                    </div>
                    @if($p->last_message)
                        <p class="mb-1 text-muted small">
                            <strong>{{ $p->last_message->pengirim->id_pengguna === Auth::id() ? 'Anda' : ($p->last_message->pengirim->nama_pengguna) }}:</strong>
                            {{ \Illuminate\Support\Str::limit($p->last_message->pesan, 50) }}
                        </p>
                        <small class="text-muted">{{ $p->last_message->tgl_kirim->diffForHumans() }}</small>
                    @else
                        <p class="mb-0 text-muted small">Belum ada pesan</p>
                    @endif
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@else
<div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 16px;">
    <div class="card-body text-center py-5">
        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Belum ada chat</h5>
        <p class="text-muted">Mulai chat dengan pelanggan setelah pesanan di-assign ke Anda</p>
    </div>
</div>
@endif
@endsection

