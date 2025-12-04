@extends('layouts.corona')

@section('title', 'Chat')

@section('content')
<!-- Page Header -->
<div class="page-header mb-4">
    <div>
        <h3 style="font-size: 30px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px; margin-bottom: 8px;">
            <i class="bi bi-chat-dots me-2" style="color: #6c5ce7;"></i>Pesan
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('fotografer.dashboard') }}" style="color: #6c7293; text-decoration: none;">Home</a></li>
                <li class="breadcrumb-item active" style="color: #6c5ce7;">Chat</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%); border: 1px solid #2c2e33; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2); overflow: hidden;">
            <div class="card-body" style="padding: 0;">
                <div class="card-title" style="padding: 28px 28px 24px; border-bottom: 1px solid #2c2e33; margin: 0; background: linear-gradient(135deg, rgba(108, 92, 231, 0.05) 0%, rgba(108, 92, 231, 0.02) 100%);">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h5 style="font-size: 20px; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-chat-dots" style="color: #ffffff; font-size: 18px;"></i>
                                </div>
                                Daftar Percakapan
                            </h5>
                            <p style="font-size: 13px; color: #6c7293; margin: 8px 0 0;">Pilih percakapan untuk melihat pesan</p>
                        </div>
                    </div>
                </div>
                <div style="padding: 24px; max-height: 600px; overflow-y: auto;">
                    @forelse($conversations as $conversation)
                    <a href="{{ route('fotografer.chat.show', $conversation['user']->id) }}" 
                       class="conversation-item" 
                       style="display: block; padding: 20px; border-bottom: 1px solid #2c2e33; text-decoration: none; transition: all 0.3s ease; border-radius: 12px; margin-bottom: 8px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="position: relative;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation['user']->name) }}&background=6c5ce7&color=fff&size=128&bold=true" 
                                     alt="{{ $conversation['user']->name }}" 
                                     style="width: 56px; height: 56px; border-radius: 50%; border: 2px solid #6c5ce7; object-fit: cover; box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);">
                                @if(isset($conversation['unread_count']) && $conversation['unread_count'] > 0)
                                <span style="position: absolute; top: -4px; right: -4px; background: linear-gradient(135deg, #fc424a 0%, #ff6b6b 100%); color: #ffffff; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; box-shadow: 0 2px 8px rgba(252, 66, 74, 0.4);">
                                    {{ $conversation['unread_count'] > 9 ? '9+' : $conversation['unread_count'] }}
                                </span>
                                @endif
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                    <h6 style="font-size: 16px; font-weight: 700; color: #ffffff; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $conversation['user']->name }}
                                    </h6>
                                    @if($conversation['last_message'])
                                    <span style="font-size: 12px; color: #6c7293; white-space: nowrap; margin-left: 12px;">
                                        {{ \Carbon\Carbon::parse($conversation['last_message']->tgl_dikirim)->diffForHumans() }}
                                    </span>
                                    @endif
                                </div>
                                @if($conversation['last_message'])
                                <p style="font-size: 14px; color: #6c7293; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.4;">
                                    {{ Str::limit($conversation['last_message']->pesan, 60) }}
                                </p>
                                @else
                                <p style="font-size: 14px; color: #6c7293; margin: 0; font-style: italic;">
                                    Belum ada pesan
                                </p>
                                @endif
                            </div>
                        </div>
                    </a>
                    @empty
                    <div style="text-align: center; padding: 80px 20px;">
                        <div style="width: 100px; height: 100px; background: rgba(108, 92, 231, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                            <i class="bi bi-chat-left-text" style="font-size: 48px; color: #6c5ce7;"></i>
                        </div>
                        <h6 style="font-size: 20px; font-weight: 700; color: #ffffff; margin-bottom: 12px;">Belum ada percakapan</h6>
                        <p style="font-size: 15px; color: #6c7293; margin: 0; line-height: 1.6;">
                            Mulai percakapan dengan pelanggan melalui pesanan mereka
                        </p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.conversation-item:hover {
    background: rgba(108, 92, 231, 0.1) !important;
    transform: translateX(6px);
    border-left: 3px solid #6c5ce7 !important;
    padding-left: 17px !important;
}

/* Custom scrollbar */
div[style*="overflow-y: auto"]::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
    background: #191c24;
    border-radius: 10px;
}

div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
    border-radius: 10px;
}

div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5b4bc4 0%, #8f7ef5 100%);
}
</style>
@endpush
@endsection

