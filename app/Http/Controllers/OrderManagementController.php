<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Layanan;

class OrderManagementController extends Controller
{
    // Tampilkan semua pesanan
    public function index(Request $request)
    {
        $query = Pesanan::with(['pengguna', 'layanan']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pengguna', function($q) use ($search) {
                $q->where('nama_pengguna', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('layanan', function($q) use ($search) {
                $q->where('nama_layanan', 'like', "%{$search}%");
            });
        }

        $pesanan = $query->orderBy('tgl_pesanan', 'desc')->paginate(10);

        // Statistik
        $stats = [
            'total' => Pesanan::count(),
            'pending' => Pesanan::where('status', 'pending')->count(),
            'diproses' => Pesanan::where('status', 'diproses')->count(),
            'selesai' => Pesanan::where('status', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.order-management', compact('pesanan', 'stats'));
    }

    // Detail pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'layanan'])->findOrFail($id);
        return view('admin.order-detail', compact('pesanan'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        $statusLabels = [
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];

        return back()->with('success', 'Status pesanan berhasil diubah menjadi ' . $statusLabels[$request->status] . '.');
    }
}
