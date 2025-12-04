@extends('layouts.corona')

@section('title', 'Chat dengan ' . $otherUser->name)

@section('content')
<!-- Page Header -->
<div class="page-header mb-4">
    <div>
        <h3 style="font-size: 30px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px; margin-bottom: 8px;">
            <i class="bi bi-chat-dots me-2" style="color: #6c5ce7;"></i>Chat
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}" style="color: #6c7293; text-decoration: none;">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fotografer.chat.index') }}" style="color: #6c7293; text-decoration: none;">Chat</a></li>
                <li class="breadcrumb-item active" style="color: #6c5ce7;">{{ $otherUser->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%); border: 1px solid #2c2e33; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2); overflow: hidden; height: 700px; display: flex; flex-direction: column;">
            <!-- Chat Header -->
            <div class="card-header" style="padding: 24px 28px; border-bottom: 1px solid #2c2e33; background: linear-gradient(135deg, rgba(108, 92, 231, 0.05) 0%, rgba(108, 92, 231, 0.02) 100%); display: flex; align-items: center; gap: 16px;">
                <a href="{{ route('fotografer.chat.index') }}" style="text-decoration: none; color: #6c7293; margin-right: 8px;">
                    <i class="bi bi-arrow-left" style="font-size: 20px;"></i>
                </a>
                <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=6c5ce7&color=fff&size=128&bold=true" 
                     alt="{{ $otherUser->name }}" 
                     style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid #6c5ce7; object-fit: cover; box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);">
                <div style="flex: 1;">
                    <h5 style="font-size: 18px; font-weight: 700; color: #ffffff; margin: 0;">{{ $otherUser->name }}</h5>
                    <p style="font-size: 13px; color: #6c7293; margin: 4px 0 0;">
                        <span style="display: inline-block; width: 8px; height: 8px; background: #00d25b; border-radius: 50%; margin-right: 6px;"></span>
                        Online
                    </p>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messages-container" style="flex: 1; padding: 24px; overflow-y: auto; background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%);">
                <div id="messages-list">
                    @forelse($messages as $message)
                    <div class="message-wrapper {{ $message->id_pengirim == $currentUserId ? 'message-sent' : 'message-received' }}" 
                         data-message-id="{{ $message->id_chat }}"
                         style="margin-bottom: 20px; display: flex; {{ $message->id_pengirim == $currentUserId ? 'justify-content: flex-end;' : 'justify-content: flex-start;' }}">
                        <div style="max-width: 70%; display: flex; align-items: flex-end; gap: 10px; {{ $message->id_pengirim == $currentUserId ? 'flex-direction: row-reverse;' : '' }}">
                            @if($message->id_pengirim != $currentUserId)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($message->pengirim->name) }}&background=6c5ce7&color=fff&size=64&bold=true" 
                                 alt="{{ $message->pengirim->name }}" 
                                 style="width: 36px; height: 36px; border-radius: 50%; border: 2px solid #6c5ce7; object-fit: cover; flex-shrink: 0;">
                            @endif
                            <div style="background: {{ $message->id_pengirim == $currentUserId ? 'linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%)' : 'linear-gradient(135deg, #2c2e33 0%, #1f2332 100%)' }}; padding: 14px 18px; border-radius: {{ $message->id_pengirim == $currentUserId ? '18px 18px 4px 18px' : '18px 18px 18px 4px' }}; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); position: relative;">
                                <p style="font-size: 15px; color: #ffffff; margin: 0; line-height: 1.5; word-wrap: break-word;">
                                    {{ $message->pesan }}
                                </p>
                                <div style="display: flex; align-items: center; justify-content: {{ $message->id_pengirim == $currentUserId ? 'flex-end' : 'flex-start' }}; margin-top: 8px; gap: 6px;">
                                    <span style="font-size: 11px; color: {{ $message->id_pengirim == $currentUserId ? 'rgba(255, 255, 255, 0.8)' : '#6c7293' }};">
                                        {{ \Carbon\Carbon::parse($message->tgl_dikirim)->format('H:i') }}
                                    </span>
                                    @if($message->id_pengirim == $currentUserId)
                                    <i class="bi bi-check2-all" style="font-size: 12px; color: rgba(255, 255, 255, 0.8);"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 60px 20px;">
                        <div style="width: 80px; height: 80px; background: rgba(108, 92, 231, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="bi bi-chat-left-text" style="font-size: 40px; color: #6c5ce7;"></i>
                        </div>
                        <h6 style="font-size: 18px; font-weight: 700; color: #ffffff; margin-bottom: 10px;">Belum ada pesan</h6>
                        <p style="font-size: 14px; color: #6c7293; margin: 0;">Mulai percakapan dengan {{ $otherUser->name }}</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Message Input -->
            <div class="card-footer" style="padding: 20px 28px; border-top: 1px solid #2c2e33; background: linear-gradient(135deg, #1a1e26 0%, #191c24 100%);">
                <form id="chat-form" style="display: flex; gap: 12px; align-items: flex-end;">
                    <input type="hidden" name="id_penerima" value="{{ $otherUser->id }}">
                    <div style="flex: 1; position: relative;">
                        <textarea name="pesan" 
                                  id="message-input" 
                                  rows="1" 
                                  placeholder="Ketik pesan..." 
                                  style="width: 100%; background: linear-gradient(135deg, #2c2e33 0%, #1f2332 100%); border: 2px solid #2c2e33; border-radius: 16px; padding: 14px 18px; color: #ffffff; font-size: 15px; resize: none; min-height: 50px; max-height: 120px; transition: all 0.3s ease;"
                                  oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"></textarea>
                    </div>
                    <button type="submit" 
                            id="send-button"
                            style="width: 50px; height: 50px; background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); border: none; border-radius: 12px; color: #ffffff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(108, 92, 231, 0.4);">
                        <i class="bi bi-send-fill" style="font-size: 18px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
#messages-container {
    scroll-behavior: smooth;
}

#messages-container::-webkit-scrollbar {
    width: 6px;
}

#messages-container::-webkit-scrollbar-track {
    background: #191c24;
    border-radius: 10px;
}

#messages-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
    border-radius: 10px;
}

#messages-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5b4bc4 0%, #8f7ef5 100%);
}

#message-input:focus {
    outline: none;
    border-color: #6c5ce7 !important;
    box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.1);
}

#send-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(108, 92, 231, 0.5) !important;
}

#send-button:active {
    transform: translateY(0);
}

.message-wrapper {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@push('scripts')
<script>
let lastMessageId = {{ $messages->count() > 0 ? $messages->last()->id_chat : 0 }};
let pollingInterval;

// Auto scroll to bottom on load
window.addEventListener('load', function() {
    scrollToBottom();
});

function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
}

// Send message
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    
    if (!message) return;
    
    const sendButton = document.getElementById('send-button');
    sendButton.disabled = true;
    sendButton.innerHTML = '<i class="bi bi-hourglass-split" style="font-size: 18px;"></i>';
    
    fetch('{{ route("fotografer.chat.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id_penerima: '{{ $otherUser->id }}',
            pesan: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            messageInput.style.height = 'auto';
            addMessageToUI(data.chat, true);
            lastMessageId = data.chat.id_chat;
            scrollToBottom();
        } else {
            alert(data.message || 'Gagal mengirim pesan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim pesan');
    })
    .finally(() => {
        sendButton.disabled = false;
        sendButton.innerHTML = '<i class="bi bi-send-fill" style="font-size: 18px;"></i>';
    });
});

// Add message to UI
function addMessageToUI(chat, isSent) {
    const messagesList = document.getElementById('messages-list');
    
    // Remove empty state if exists
    const emptyState = messagesList.querySelector('div[style*="text-align: center"]');
    if (emptyState) {
        emptyState.remove();
    }
    
    const messageWrapper = document.createElement('div');
    messageWrapper.className = `message-wrapper ${isSent ? 'message-sent' : 'message-received'}`;
    messageWrapper.setAttribute('data-message-id', chat.id_chat);
    messageWrapper.style.cssText = `margin-bottom: 20px; display: flex; ${isSent ? 'justify-content: flex-end;' : 'justify-content: flex-start;'}`;
    
    const messageDiv = document.createElement('div');
    messageDiv.style.cssText = `max-width: 70%; display: flex; align-items: flex-end; gap: 10px; ${isSent ? 'flex-direction: row-reverse;' : ''}`;
    
    if (!isSent) {
        const avatar = document.createElement('img');
        avatar.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(chat.pengirim.name)}&background=6c5ce7&color=fff&size=64&bold=true`;
        avatar.alt = chat.pengirim.name;
        avatar.style.cssText = 'width: 36px; height: 36px; border-radius: 50%; border: 2px solid #6c5ce7; object-fit: cover; flex-shrink: 0;';
        messageDiv.appendChild(avatar);
    }
    
    const messageBubble = document.createElement('div');
    messageBubble.style.cssText = `background: ${isSent ? 'linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%)' : 'linear-gradient(135deg, #2c2e33 0%, #1f2332 100%)'}; padding: 14px 18px; border-radius: ${isSent ? '18px 18px 4px 18px' : '18px 18px 18px 4px'}; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); position: relative;`;
    
    const messageText = document.createElement('p');
    messageText.style.cssText = 'font-size: 15px; color: #ffffff; margin: 0; line-height: 1.5; word-wrap: break-word;';
    messageText.textContent = chat.pesan;
    messageBubble.appendChild(messageText);
    
    const timeDiv = document.createElement('div');
    timeDiv.style.cssText = `display: flex; align-items: center; justify-content: ${isSent ? 'flex-end' : 'flex-start'}; margin-top: 8px; gap: 6px;`;
    
    const timeSpan = document.createElement('span');
    timeSpan.style.cssText = `font-size: 11px; color: ${isSent ? 'rgba(255, 255, 255, 0.8)' : '#6c7293'};`;
    const messageDate = new Date(chat.tgl_dikirim);
    timeSpan.textContent = messageDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    timeDiv.appendChild(timeSpan);
    
    if (isSent) {
        const checkIcon = document.createElement('i');
        checkIcon.className = 'bi bi-check2-all';
        checkIcon.style.cssText = 'font-size: 12px; color: rgba(255, 255, 255, 0.8);';
        timeDiv.appendChild(checkIcon);
    }
    
    messageBubble.appendChild(timeDiv);
    messageDiv.appendChild(messageBubble);
    messageWrapper.appendChild(messageDiv);
    messagesList.appendChild(messageWrapper);
    
    scrollToBottom();
}

// Poll for new messages
function pollNewMessages() {
    fetch(`{{ route('fotografer.chat.getNewMessages', $otherUser->id) }}?last_message_id=${lastMessageId}`, {
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.messages.length > 0) {
            data.messages.forEach(message => {
                // Check if message already exists
                const existingMessage = document.querySelector(`[data-message-id="${message.id_chat}"]`);
                if (!existingMessage) {
                    addMessageToUI(message, message.id_pengirim == {{ $currentUserId }});
                    lastMessageId = message.id_chat;
                }
            });
            scrollToBottom();
        }
    })
    .catch(error => {
        console.error('Error polling messages:', error);
    });
}

// Start polling when page is visible
if (document.visibilityState === 'visible') {
    pollingInterval = setInterval(pollNewMessages, 3000); // Poll every 3 seconds
}

// Stop polling when page is hidden
document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible') {
        pollingInterval = setInterval(pollNewMessages, 3000);
    } else {
        clearInterval(pollingInterval);
    }
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    clearInterval(pollingInterval);
});
</script>
@endpush
@endsection

