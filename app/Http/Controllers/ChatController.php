<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Menampilkan daftar percakapan
     */
    public function index()
    {
        $currentUserId = Auth::id();
        
        // Ambil semua pesan yang melibatkan user saat ini
        $allChats = Chat::where(function($query) use ($currentUserId) {
                $query->where('id_pengirim', $currentUserId)
                      ->orWhere('id_penerima', $currentUserId);
            })
            ->orderBy('tgl_dikirim', 'desc')
            ->get();
        
        // Group by other user ID
        $conversationsMap = [];
        foreach ($allChats as $chat) {
            $otherUserId = $chat->id_pengirim == $currentUserId ? $chat->id_penerima : $chat->id_pengirim;
            
            if (!isset($conversationsMap[$otherUserId])) {
                $conversationsMap[$otherUserId] = [
                    'user_id' => $otherUserId,
                    'last_message_time' => $chat->tgl_dikirim,
                    'last_message' => $chat
                ];
            } else {
                if ($chat->tgl_dikirim > $conversationsMap[$otherUserId]['last_message_time']) {
                    $conversationsMap[$otherUserId]['last_message_time'] = $chat->tgl_dikirim;
                    $conversationsMap[$otherUserId]['last_message'] = $chat;
                }
            }
        }
        
        // Convert to array with user data
        $conversations = collect($conversationsMap)->map(function($item) use ($currentUserId) {
            $otherUser = User::find($item['user_id']);
            
            if (!$otherUser) {
                return null;
            }
            
            return [
                'user' => $otherUser,
                'last_message' => $item['last_message'],
                'unread_count' => Chat::where('id_pengirim', $item['user_id'])
                    ->where('id_penerima', $currentUserId)
                    ->where('is_read', false)
                    ->count()
            ];
        })
        ->filter(function($conversation) {
            return $conversation !== null && $conversation['user'] !== null;
        })
        ->sortByDesc(function($conversation) {
            return $conversation['last_message'] ? $conversation['last_message']->tgl_dikirim : now();
        })
        ->values();

        return view('fotografer.chat.index', compact('conversations'));
    }

    /**
     * Menampilkan halaman chat dengan user tertentu
     */
    public function show($userId)
    {
        $currentUserId = Auth::id();
        $otherUser = User::findOrFail($userId);
        
        // Pastikan user yang diakses bukan user yang sedang login
        if ($otherUser->id == $currentUserId) {
            return redirect()->route('fotografer.chat.index')
                ->with('error', 'Tidak dapat chat dengan diri sendiri');
        }

        // Ambil semua pesan antara dua user
        $messages = Chat::betweenUsers($currentUserId, $userId)
            ->with(['pengirim', 'penerima'])
            ->orderBy('tgl_dikirim', 'asc')
            ->get();

        // Tandai pesan sebagai sudah dibaca
        Chat::where('id_pengirim', $userId)
            ->where('id_penerima', $currentUserId)
            ->update(['is_read' => true]);

        return view('fotografer.chat.show', compact('messages', 'otherUser', 'currentUserId'));
    }

    /**
     * Mengirim pesan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_penerima' => 'required|exists:users,id',
            'pesan' => 'required|string|max:5000',
        ]);

        $currentUserId = Auth::id();

        // Pastikan tidak mengirim pesan ke diri sendiri
        if ($request->id_penerima == $currentUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengirim pesan ke diri sendiri'
            ], 400);
        }

        $chat = Chat::create([
            'id_pengirim' => $currentUserId,
            'id_penerima' => $request->id_penerima,
            'pesan' => $request->pesan,
            'tgl_dikirim' => now(),
            'is_read' => false
        ]);

        $chat->load(['pengirim', 'penerima']);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim',
            'chat' => $chat
        ]);
    }

    /**
     * Mengambil pesan baru (untuk real-time)
     */
    public function getMessages($userId)
    {
        $currentUserId = Auth::id();
        
        $messages = Chat::betweenUsers($currentUserId, $userId)
            ->with(['pengirim', 'penerima'])
            ->orderBy('tgl_dikirim', 'asc')
            ->get();

        // Tandai pesan sebagai sudah dibaca
        Chat::where('id_pengirim', $userId)
            ->where('id_penerima', $currentUserId)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Mengambil pesan baru saja (untuk polling)
     */
    public function getNewMessages($userId, Request $request)
    {
        $currentUserId = Auth::id();
        $lastMessageId = $request->get('last_message_id', 0);
        
        $messages = Chat::betweenUsers($currentUserId, $userId)
            ->where('id_chat', '>', $lastMessageId)
            ->with(['pengirim', 'penerima'])
            ->orderBy('tgl_dikirim', 'asc')
            ->get();

        // Tandai pesan sebagai sudah dibaca
        if ($messages->count() > 0) {
            Chat::where('id_pengirim', $userId)
                ->where('id_penerima', $currentUserId)
                ->where('id_chat', '>', $lastMessageId)
                ->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'last_message_id' => $messages->count() > 0 ? $messages->last()->id_chat : $lastMessageId
        ]);
    }
}
