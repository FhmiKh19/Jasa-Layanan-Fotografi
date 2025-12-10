<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Tampilkan halaman chat berdasarkan pesanan
    public function index($id_pesanan)
    {
        $user = Auth::user();
        $pesanan = Pesanan::with(['pengguna', 'layanan', 'fotografer'])
            ->findOrFail($id_pesanan);

        // Pastikan user yang akses adalah pelanggan atau fotografer dari pesanan ini
        if ($user->role === 'pelanggan' && $pesanan->id_pengguna !== $user->id_pengguna) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }
        
        if ($user->role === 'fotografer' && $pesanan->id_fotografer !== $user->id_pengguna) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }

        // Tentukan lawan bicara
        if ($user->role === 'pelanggan') {
            $lawanBicara = $pesanan->fotografer;
        } else {
            $lawanBicara = $pesanan->pengguna;
        }

        // Ambil semua pesan chat untuk pesanan ini
        $chats = Chat::where('id_pesanan', $id_pesanan)
            ->with(['pengirim', 'penerima'])
            ->orderBy('tgl_kirim', 'asc')
            ->get();

        // Tandai pesan sebagai dibaca
        Chat::where('id_pesanan', $id_pesanan)
            ->where('id_penerima', $user->id_pengguna)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        // Tentukan view berdasarkan role
        if ($user->role === 'pelanggan') {
            return view('pelanggan.chat.index', compact('pesanan', 'chats', 'lawanBicara'));
        } else if ($user->role === 'fotografer') {
            return view('fotografer.chat.index', compact('pesanan', 'chats', 'lawanBicara'));
        }
        
        abort(403);
    }

    // Kirim pesan
    public function store(Request $request, $id_pesanan)
    {
        $user = Auth::user();
        $pesanan = Pesanan::findOrFail($id_pesanan);

        // Validasi
        $request->validate([
            'pesan' => 'required|string|max:1000'
        ]);

        // Tentukan penerima
        $id_penerima = null;
        if ($user->role === 'pelanggan') {
            // Pelanggan kirim ke fotografer
            if (!$pesanan->id_fotografer) {
                return back()->with('error', 'Fotografer belum di-assign ke pesanan ini.');
            }
            $id_penerima = $pesanan->id_fotografer;
        } else if ($user->role === 'fotografer') {
            // Fotografer kirim ke pelanggan
            $id_penerima = $pesanan->id_pengguna;
        } else {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Pastikan user yang kirim adalah pelanggan atau fotografer dari pesanan
        if ($user->role === 'pelanggan' && $pesanan->id_pengguna !== $user->id_pengguna) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        
        if ($user->role === 'fotografer' && $pesanan->id_fotografer !== $user->id_pengguna) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Simpan pesan
        $chat = Chat::create([
            'id_pesanan' => $id_pesanan,
            'id_pengirim' => $user->id_pengguna,
            'id_penerima' => $id_penerima,
            'pesan' => $request->pesan,
            'dibaca' => false,
            'tgl_kirim' => now()
        ]);

        // Buat notifikasi untuk penerima
        $penerima = User::find($id_penerima);
        if ($penerima) {
            Notification::create([
                'id_pengguna' => $id_penerima,
                'tipe' => 'chat',
                'judul' => 'Pesan Baru',
                'pesan' => $user->nama_pengguna . ' mengirim pesan: ' . \Illuminate\Support\Str::limit($request->pesan, 50),
                'link' => route($user->role === 'pelanggan' ? 'fotografer.chat.index' : 'pelanggan.chat.index', $id_pesanan),
                'dibaca' => false,
                'tgl_dibuat' => now()
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim.']);
        }

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    // Get pesan baru (untuk real-time update via AJAX)
    public function getMessages($id_pesanan)
    {
        $user = Auth::user();
        $pesanan = Pesanan::findOrFail($id_pesanan);

        // Pastikan user memiliki akses
        if ($user->role === 'pelanggan' && $pesanan->id_pengguna !== $user->id_pengguna) {
            abort(403);
        }
        
        if ($user->role === 'fotografer' && $pesanan->id_fotografer !== $user->id_pengguna) {
            abort(403);
        }

        $lastMessageId = request('last_message_id', 0);

        $chats = Chat::where('id_pesanan', $id_pesanan)
            ->where('id_chat', '>', $lastMessageId)
            ->with(['pengirim', 'penerima'])
            ->orderBy('tgl_kirim', 'asc')
            ->get();

        // Tandai sebagai dibaca
        Chat::where('id_pesanan', $id_pesanan)
            ->where('id_penerima', $user->id_pengguna)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return response()->json([
            'messages' => $chats,
            'last_message_id' => $chats->max('id_chat') ?? $lastMessageId
        ]);
    }

    // List chat untuk pelanggan (berdasarkan pesanan)
    public function listChat()
    {
        $user = Auth::user();
        
        if ($user->role === 'pelanggan') {
            // Ambil semua pesanan yang punya fotografer
            $pesanan = Pesanan::where('id_pengguna', $user->id_pengguna)
                ->whereNotNull('id_fotografer')
                ->with(['layanan', 'fotografer'])
                ->orderBy('tgl_pesanan', 'desc')
                ->get();
            
            $viewName = 'pelanggan.chat.list';
        } else if ($user->role === 'fotografer') {
            // Ambil semua pesanan yang di-assign ke fotografer ini
            $pesanan = Pesanan::where('id_fotografer', $user->id_pengguna)
                ->with(['layanan', 'pengguna'])
                ->orderBy('tgl_pesanan', 'desc')
                ->get();
            
            $viewName = 'fotografer.chat.list';
        } else {
            abort(403);
        }

        // Hitung unread messages untuk setiap pesanan
        foreach ($pesanan as $p) {
            $p->unread_count = Chat::where('id_pesanan', $p->id_pesanan)
                ->where('id_penerima', $user->id_pengguna)
                ->where('dibaca', false)
                ->count();
            
            // Ambil pesan terakhir
            $p->last_message = Chat::where('id_pesanan', $p->id_pesanan)
                ->with('pengirim')
                ->orderBy('tgl_kirim', 'desc')
                ->first();
        }

        return view($viewName, compact('pesanan'));
    }
}
