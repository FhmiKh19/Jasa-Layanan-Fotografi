@extends('layouts-fotografer.corona')

@section('title', 'Chat')

@section('content')
<div class="page-header mb-4">
    <div>
        <h3 style="font-size: 30px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px; margin-bottom: 8px;">
            <i class="bi bi-chat-dots me-2" style="color: #6c5ce7;"></i>Chat
        </h3>
        <p class="text-white-50">{{ $pesanan->layanan->nama_layanan }}</p>
    </div>
</div>

<div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden; height: 600px; display: flex; flex-direction: column;">
    {{-- Chat Header --}}
    <div style="background: linear-gradient(135deg, rgba(139, 69, 19, 0.9), rgba(101, 67, 33, 0.9)); color: white; padding: 20px; border-bottom: 2px solid rgba(255,255,255,0.1);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">{{ $lawanBicara->nama_pengguna }}</h5>
                <small>{{ $pesanan->layanan->nama_layanan }}</small>
            </div>
            <div>
                <a href="{{ route('fotografer.chat.list') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Chat Messages --}}
    <div id="chatMessages" style="flex: 1; overflow-y: auto; padding: 20px; background: #f8f9fa;">
        @foreach($chats as $chat)
        <div class="d-flex mb-3 {{ $chat->id_pengirim === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
            <div style="max-width: 70%; padding: 12px 16px; border-radius: 18px; {{ $chat->id_pengirim === Auth::id() ? 'background: linear-gradient(135deg, #8d5524, #c08552); color: white; border-bottom-right-radius: 4px;' : 'background: white; color: #333; border-bottom-left-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);' }}; word-wrap: break-word; white-space: normal;">
                <div style="word-break: break-word;">{{ $chat->pesan }}</div>
                <small style="font-size: 0.75rem; opacity: 0.7; display: block; margin-top: 5px; text-align: {{ $chat->id_pengirim === Auth::id() ? 'right' : 'left' }};">
                    {{ $chat->tgl_kirim->format('H:i') }}
                </small>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Chat Input --}}
    <div style="padding: 20px; background: white; border-top: 2px solid #e9ecef;">
        <form id="chatForm" method="POST" action="{{ route('fotografer.chat.store', $pesanan->id_pesanan) }}" class="d-flex gap-2">
            @csrf
            <input type="text" 
                   name="pesan" 
                   id="messageInput" 
                   class="form-control" 
                   placeholder="Ketik pesan..." 
                   required 
                   autocomplete="off"
                   style="border-radius: 25px; border: 2px solid #e9ecef; padding: 12px 20px;">
            <button type="submit" class="btn" style="border-radius: 50%; width: 50px; height: 50px; background: linear-gradient(135deg, #8d5524, #c08552); color: white; border: none; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    let lastMessageId = {{ $chats->max('id_chat') ?? 0 }};

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    setInterval(function() {
        fetch(`{{ route('fotografer.chat.getMessages', $pesanan->id_pesanan) }}?last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        const isSent = msg.id_pengirim === {{ Auth::id() }};
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `d-flex mb-3 ${isSent ? 'justify-content-end' : 'justify-content-start'}`;
                        messageDiv.innerHTML = `
                            <div style="max-width: 70%; padding: 12px 16px; border-radius: 18px; ${isSent ? 'background: linear-gradient(135deg, #8d5524, #c08552); color: white; border-bottom-right-radius: 4px;' : 'background: white; color: #333; border-bottom-left-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);'} word-wrap: break-word; white-space: normal;">
                                <div style="word-break: break-word;">${msg.pesan}</div>
                                <small style="font-size: 0.75rem; opacity: 0.7; display: block; margin-top: 5px; text-align: ${isSent ? 'right' : 'left'};">
                                    ${new Date(msg.tgl_kirim).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}
                                </small>
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
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                const messageDiv = document.createElement('div');
                messageDiv.className = 'd-flex mb-3 justify-content-end';
                messageDiv.innerHTML = `
                    <div style="max-width: 70%; padding: 12px 16px; border-radius: 18px; background: linear-gradient(135deg, #8d5524, #c08552); color: white; border-bottom-right-radius: 4px; word-wrap: break-word; white-space: normal;">
                        <div style="word-break: break-word;">${message}</div>
                        <small style="font-size: 0.75rem; opacity: 0.7; display: block; margin-top: 5px; text-align: right;">
                            ${new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}
                        </small>
                    </div>
                `;
                chatMessages.appendChild(messageDiv);
                scrollToBottom();
                lastMessageId = Math.max(lastMessageId, Date.now());
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.submit();
        });
    });

    scrollToBottom();
</script>
@endpush
@endsection
