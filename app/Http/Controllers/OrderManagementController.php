<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Notification;

class OrderManagementController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan
     * Support filter status dan search
     */
    public function index(Request $request)
    {
        $query = Pesanan::with(['pengguna', 'layanan', 'fotografer']);

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

    /**
     * Tampilkan detail pesanan lengkap
     * Menampilkan data pelanggan, layanan, dan fotografer
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'layanan', 'fotografer'])->findOrFail($id);
        $fotografer = User::where('role', 'fotografer')
            ->where('status_akun', 'aktif')
            ->orderBy('nama_pengguna')
            ->get();
        return view('admin.order-detail', compact('pesanan', 'fotografer'));
    }

    /**
     * Update status pesanan
     * Status: pending, diproses, selesai, dibatalkan
     */
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

    /**
     * Assign atau ubah fotografer untuk pesanan
     * Jika fotografer baru berbeda, buat notifikasi untuk fotografer
     */
    public function assignFotografer(Request $request, $id)
    {
        $request->validate([
            'id_fotografer' => 'nullable|exists:pengguna,id_pengguna'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        
        // Validasi bahwa user yang dipilih adalah fotografer
        if ($request->id_fotografer) {
            $fotografer = User::findOrFail($request->id_fotografer);
            if ($fotografer->role !== 'fotografer') {
                return back()->with('error', 'User yang dipilih bukan fotografer!');
            }
        }
        
        $oldFotograferId = $pesanan->id_fotografer;
        $pesanan->id_fotografer = $request->id_fotografer;
        $pesanan->save();
        $pesanan->load(['layanan', 'pengguna']); // Load relasi

        // Buat notifikasi untuk fotografer yang baru di-assign
        if ($request->id_fotografer && $oldFotograferId != $request->id_fotografer) {
            Notification::create([
                'id_pengguna' => $request->id_fotografer,
                'tipe' => 'pesanan',
                'judul' => 'Pesanan Baru',
                'pesan' => 'Anda di-assign ke pesanan baru: ' . ($pesanan->layanan->nama_layanan ?? 'Layanan') . ' dari ' . ($pesanan->pengguna->nama_pengguna ?? 'Pelanggan'),
                'link' => route('fotografer.pesanan.show', $pesanan->id_pesanan),
                'dibaca' => false,
                'tgl_dibuat' => now()
            ]);
        }

        if ($request->id_fotografer) {
            return back()->with('success', 'Fotografer berhasil di-assign ke pesanan ini.');
        } else {
            return back()->with('success', 'Fotografer berhasil dihapus dari pesanan ini.');
        }
    }
}
