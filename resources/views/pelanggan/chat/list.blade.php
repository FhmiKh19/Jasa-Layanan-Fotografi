<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 80px;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1920&h=1080&fit=crop') center/cover no-repeat;
            filter: brightness(0.5);
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.7) 0%, rgba(101, 67, 33, 0.7) 50%, rgba(62, 39, 35, 0.7) 100%);
            z-index: 1;
        }
        
        .container {
            position: relative;
            z-index: 2;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }
        
        .page-header h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .chat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .chat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
        }

        .unread-badge {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials-pelanggan.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="page-header">
            <h2><i class="fas fa-comments me-2"></i>Chat</h2>
            <p>Pilih pesanan untuk memulai chat</p>
        </div>

        @if($pesanan->count() > 0)
        <div class="row">
            @foreach($pesanan as $p)
            <div class="col-md-6 col-lg-4 mb-3">
                <a href="{{ route('pelanggan.chat.index', $p->id_pesanan) }}" class="text-decoration-none">
                    <div class="chat-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-1">
                                    @if(Auth::user()->role === 'pelanggan')
                                        {{ $p->fotografer->nama_pengguna ?? 'Belum di-assign' }}
                                    @else
                                        {{ $p->pengguna->nama_pengguna }}
                                    @endif
                                </h6>
                                <small class="text-muted">{{ $p->layanan->nama_layanan }}</small>
                            </div>
                            @if($p->unread_count > 0)
                                <span class="unread-badge">{{ $p->unread_count }}</span>
                            @endif
                        </div>
                        @if($p->last_message)
                            <p class="mb-0 text-muted small">
                                <strong>{{ $p->last_message->pengirim->id_pengguna === Auth::id() ? 'Anda' : ($p->last_message->pengirim->nama_pengguna) }}:</strong>
                                {{ \Illuminate\Support\Str::limit($p->last_message->pesan, 50) }}
                            </p>
                            <small class="text-muted">{{ $p->last_message->tgl_kirim->diffForHumans() }}</small>
                        @else
                            <p class="mb-0 text-muted small">Belum ada pesan</p>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-white" style="padding: 60px 20px;">
            <i class="fas fa-comments fa-3x mb-3" style="opacity: 0.5;"></i>
            <h4>Belum ada chat</h4>
            <p>Mulai chat dengan fotografer setelah membuat pesanan</p>
        </div>
        @endif
    </div>

    {{-- ================== FOOTER ================== --}}
    @include('partials-pelanggan.footer')
    {{-- ============================================ --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

