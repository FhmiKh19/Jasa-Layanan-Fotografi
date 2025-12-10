<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Get notifikasi untuk user yang login
    public function index()
    {
        $user = Auth::user();
        
        $notifikasi = Notification::where('id_pengguna', $user->id_pengguna)
            ->orderBy('tgl_dibuat', 'desc')
            ->limit(10)
            ->get();
        
        $unreadCount = Notification::where('id_pengguna', $user->id_pengguna)
            ->where('dibaca', false)
            ->count();
        
        return response()->json([
            'notifikasi' => $notifikasi,
            'unread_count' => $unreadCount
        ]);
    }

    // Tandai notifikasi sebagai dibaca
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        $notifikasi = Notification::where('id_notifikasi', $id)
            ->where('id_pengguna', $user->id_pengguna)
            ->firstOrFail();
        
        $notifikasi->dibaca = true;
        $notifikasi->save();
        
        return response()->json(['success' => true]);
    }

    // Tandai semua notifikasi sebagai dibaca
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        Notification::where('id_pengguna', $user->id_pengguna)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);
        
        return response()->json(['success' => true]);
    }

    // Get unread count
    public function getUnreadCount()
    {
        $user = Auth::user();
        
        $unreadCount = Notification::where('id_pengguna', $user->id_pengguna)
            ->where('dibaca', false)
            ->count();
        
        return response()->json(['unread_count' => $unreadCount]);
    }
}
