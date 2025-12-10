<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat - {{ $pesanan->layanan->nama_layanan }}</title>
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

        .chat-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            height: 600px;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.9), rgba(101, 67, 33, 0.9));
            color: white;
            padding: 20px;
            border-bottom: 2px solid rgba(255,255,255,0.1);
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            width: 100%;
        }

        .message.sent {
            justify-content: flex-end;
        }
        
        .message-wrapper {
            display: flex;
            flex-direction: column;
            max-width: 70%;
        }
        
        .message.sent .message-wrapper {
            align-items: flex-end;
        }
        
        .message.received .message-wrapper {
            align-items: flex-start;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 18px;
            word-wrap: break-word;
            white-space: normal;
            word-break: break-word;
            display: block;
            width: 100%;
        }

        .message.sent .message-content {
            background: linear-gradient(135deg, #8d5524, #c08552);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message.received .message-content {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
            text-align: right;
        }

        .message.received .message-time {
            text-align: left;
        }

        .chat-input {
            padding: 20px;
            background: white;
            border-top: 2px solid #e9ecef;
        }

        .chat-input form {
            display: flex;
            gap: 10px;
        }

        .chat-input input {
            flex: 1;
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
        }

        .chat-input button {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            border: none;
            background: linear-gradient(135deg, #8d5524, #c08552);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .chat-input button:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    {{-- ================== NAVBAR ================== --}}
    @include('partials-pelanggan.navbar')
    {{-- ============================================ --}}

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('pelanggan.chat.list') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <h4 class="text-white mb-0">
                <i class="fas fa-comments me-2"></i>Chat
            </h4>
            <div></div>
        </div>

        <div class="chat-container">
            {{-- Chat Header --}}
            <div class="chat-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            @if(Auth::user()->role === 'pelanggan')
                                {{ $lawanBicara->nama_pengguna ?? 'Fotografer' }}
                            @else
                                {{ $lawanBicara->nama_pengguna }}
                            @endif
                        </h5>
                        <small>{{ $pesanan->layanan->nama_layanan }}</small>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark">{{ $pesanan->status }}</span>
                    </div>
                </div>
            </div>

            {{-- Chat Messages --}}
            <div class="chat-messages" id="chatMessages">
                @foreach($chats as $chat)
                <div class="message {{ $chat->id_pengirim === Auth::id() ? 'sent' : 'received' }}">
                    <div class="message-wrapper">
                        <div class="message-content">
                            {{ $chat->pesan }}
                        </div>
                        <div class="message-time">
                            {{ $chat->tgl_kirim->format('H:i') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Chat Input --}}
            <div class="chat-input">
                <form id="chatForm" method="POST" action="{{ route('pelanggan.chat.store', $pesanan->id_pesanan) }}">
                    @csrf
                    <input type="text" 
                           name="pesan" 
                           id="messageInput" 
                           class="form-control" 
                           placeholder="Ketik pesan..." 
                           required 
                           autocomplete="off">
                    <button type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ================== FOOTER ================== --}}
    @include('partials-pelanggan.footer')
    {{-- ============================================ --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const chatMessages = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        let lastMessageId = {{ $chats->max('id_chat') ?? 0 }};

        // Auto scroll ke bawah
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Load pesan baru setiap 3 detik
        setInterval(function() {
            fetch(`{{ route('pelanggan.chat.getMessages', $pesanan->id_pesanan) }}?last_message_id=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        const isSent = msg.id_pengirim === {{ Auth::id() }};
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
                        messageDiv.innerHTML = `
                            <div class="message-wrapper">
                                <div class="message-content">${msg.pesan}</div>
                                <div class="message-time">${new Date(msg.tgl_kirim).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</div>
                            </div>
                        `;
                        chatMessages.appendChild(messageDiv);
                        lastMessageId = Math.max(lastMessageId, msg.id_chat);
                    });
                        scrollToBottom();
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 3000);

        // Submit form
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const message = messageInput.value.trim();
            
            if (!message) return;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json().catch(() => ({ success: true }));
                }
                throw new Error('Network response was not ok');
            })
            .then(data => {
                if (data.success !== false) {
                messageInput.value = '';
                // Tambahkan pesan langsung ke chat
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message sent';
                messageDiv.innerHTML = `
                    <div class="message-wrapper">
                        <div class="message-content">${message}</div>
                        <div class="message-time">${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</div>
                    </div>
                `;
                chatMessages.appendChild(messageDiv);
                scrollToBottom();
                lastMessageId = Math.max(lastMessageId, Date.now());
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Fallback: submit form normal
                this.submit();
            });
        });

        // Scroll ke bawah saat halaman load
        scrollToBottom();
    </script>
</body>
</html>

