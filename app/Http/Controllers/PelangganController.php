<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Notification;
use App\Models\Portofolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistik pesanan pelanggan
        $pesananAktif = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->whereIn('status', ['pending', 'diproses'])
            ->count();
        
        $pesananSelesai = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->where('status', 'selesai')
            ->count();
        
        $menungguPembayaran = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->where('status', 'menunggu_pembayaran')
            ->count();
        
        // Total pengeluaran
        $totalPengeluaran = Pesanan::where('pesanan.id_pengguna', $user->id_pengguna)
            ->where('pesanan.status', 'selesai')
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->sum('layanan.harga');
        
        // Pesanan terbaru
        $pesananTerbaru = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->with('layanan')
            ->orderBy('tgl_pesanan', 'desc')
            ->limit(10)
            ->get();
        
        // Layanan populer (hanya beberapa untuk dashboard)
        $layananPopuler = Layanan::where('status', 'aktif')
            ->orderBy('harga', 'asc')
            ->limit(6)
            ->get();
        
        return view('pelanggan.dashboard', compact(
            'pesananAktif',
            'pesananSelesai',
            'menungguPembayaran',
            'totalPengeluaran',
            'pesananTerbaru',
            'layananPopuler'
        ));
    }

    // Booking Methods
    public function bookingCreate()
    {
        $user = Auth::user();
        // Get existing booking if any
        $booking = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->whereIn('status', ['pending', 'diproses'])
            ->latest()
            ->first();
        
        // Get list layanan untuk dropdown
        $layanan = Layanan::where('status', 'aktif')->orderBy('nama_layanan')->get();
        
        // Get list fotografer aktif untuk dropdown
        $fotografer = User::where('role', 'fotografer')
            ->where('status_akun', 'aktif')
            ->orderBy('nama_pengguna')
            ->get();
        
        return view('pelanggan.booking.create', compact('booking', 'layanan', 'fotografer'));
    }

    public function bookingStore(Request $request)
    {
        $request->validate([
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'id_fotografer' => 'nullable|exists:pengguna,id_pengguna',
            'tgl_acara' => 'required|date|after_or_equal:today',
            'alamat' => 'nullable|string|max:500',
            'metode_pembayaran' => 'nullable|string',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        
        $data = [
            'id_pengguna' => $user->id_pengguna,
            'id_layanan' => $request->id_layanan,
            'id_fotografer' => $request->id_fotografer,
            'tgl_acara' => $request->tgl_acara,
            'alamat' => $request->alamat,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'pending', // Status awal pending, akan diubah jadi "diproses" oleh fotografer
            'tgl_pesanan' => now(),
        ];

        // Upload bukti pembayaran jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/payments', $fileName);
            $data['bukti_pembayaran'] = $fileName;
        }

        $pesanan = Pesanan::create($data);
        $pesanan->load('layanan'); // Load relasi layanan

        // Buat notifikasi untuk fotografer yang di-assign (jika ada)
        if ($pesanan->id_fotografer) {
            Notification::create([
                'id_pengguna' => $pesanan->id_fotografer,
                'tipe' => 'pesanan',
                'judul' => 'Pesanan Baru',
                'pesan' => $user->nama_pengguna . ' membuat pesanan baru: ' . ($pesanan->layanan->nama_layanan ?? 'Layanan'),
                'link' => route('fotografer.pesanan.show', $pesanan->id_pesanan),
                'dibaca' => false,
                'tgl_dibuat' => now()
            ]);
        }

        return redirect()->route('pelanggan.booking.create')
            ->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi dari fotografer. Setelah dikonfirmasi, jadwal akan otomatis muncul.');
    }

    public function bookingEdit($id)
    {
        $user = Auth::user();
        $booking = Pesanan::with('layanan')
            ->where('id_pesanan', $id)
            ->where('id_pengguna', $user->id_pengguna)
            ->where('status', 'pending') // Hanya bisa edit jika masih pending
            ->firstOrFail();
        
        // Get list layanan untuk dropdown
        $layanan = Layanan::where('status', 'aktif')->orderBy('nama_layanan')->get();
        
        // Get list fotografer aktif untuk dropdown
        $fotografer = User::where('role', 'fotografer')
            ->where('status_akun', 'aktif')
            ->orderBy('nama_pengguna')
            ->get();
        
        return view('pelanggan.booking.edit', compact('booking', 'layanan', 'fotografer'));
    }

    public function bookingUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $booking = Pesanan::where('id_pesanan', $id)
            ->where('id_pengguna', $user->id_pengguna)
            ->where('status', 'pending') // Hanya bisa edit jika masih pending
            ->firstOrFail();
        
        $request->validate([
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'id_fotografer' => 'nullable|exists:pengguna,id_pengguna',
            'tgl_acara' => 'required|date|after_or_equal:today',
            'alamat' => 'nullable|string|max:500',
            'metode_pembayaran' => 'nullable|string',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'id_layanan' => $request->id_layanan,
            'id_fotografer' => $request->id_fotografer,
            'tgl_acara' => $request->tgl_acara,
            'alamat' => $request->alamat,
            'metode_pembayaran' => $request->metode_pembayaran,
        ];

        // Upload bukti pembayaran baru jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus file lama jika ada
            if ($booking->bukti_pembayaran && Storage::exists('public/payments/' . $booking->bukti_pembayaran)) {
                Storage::delete('public/payments/' . $booking->bukti_pembayaran);
            }
            
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/payments', $fileName);
            $data['bukti_pembayaran'] = $fileName;
        }

        $booking->update($data);

        return redirect()->route('pelanggan.booking.create')
            ->with('success', 'Booking berhasil diupdate!');
    }

    public function bookingDestroy($id)
    {
        $user = Auth::user();
        $booking = Pesanan::where('id_pesanan', $id)
            ->where('id_pengguna', $user->id_pengguna)
            ->where('status', 'pending') // Hanya bisa hapus jika masih pending
            ->firstOrFail();
        
        // Hapus bukti pembayaran jika ada
        if ($booking->bukti_pembayaran && Storage::exists('public/payments/' . $booking->bukti_pembayaran)) {
            Storage::delete('public/payments/' . $booking->bukti_pembayaran);
        }
        
        $booking->delete();

        return redirect()->route('pelanggan.booking.create')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    // Halaman semua layanan
    public function layananIndex(Request $request)
    {
        $query = Layanan::where('status', 'aktif');

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_layanan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'harga_asc');
        switch ($sort) {
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama_asc':
                $query->orderBy('nama_layanan', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama_layanan', 'desc');
                break;
            default:
                $query->orderBy('harga', 'asc');
        }

        $layanan = $query->paginate(9);

        return view('pelanggan.layanan.index', compact('layanan'));
    }

    // Halaman pesanan pelanggan
    public function pesananIndex(Request $request)
    {
        $user = Auth::user();
        
        $query = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->with(['layanan', 'fotografer']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('layanan', function($q) use ($search) {
                $q->where('nama_layanan', 'like', "%{$search}%");
            });
        }

        $pesanan = $query->orderBy('tgl_pesanan', 'desc')->paginate(10);

        // Statistik
        $stats = [
            'total' => Pesanan::where('id_pengguna', $user->id_pengguna)->count(),
            'pending' => Pesanan::where('id_pengguna', $user->id_pengguna)->where('status', 'pending')->count(),
            'diproses' => Pesanan::where('id_pengguna', $user->id_pengguna)->where('status', 'diproses')->count(),
            'selesai' => Pesanan::where('id_pengguna', $user->id_pengguna)->where('status', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('id_pengguna', $user->id_pengguna)->where('status', 'dibatalkan')->count(),
        ];

        return view('pelanggan.pesanan.index', compact('pesanan', 'stats'));
    }

    // Portofolio - Tampilkan portofolio fotografer dengan kategori
    public function portofolioIndex(Request $request)
    {
        $query = Portofolio::query();

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != '' && $request->kategori != 'semua') {
            $query->where('kategori', $request->kategori);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Ambil portofolio dengan pagination (tampilkan semua, tidak ada limit default)
        $portofolios = $query->with('fotografer')->orderBy('tgl_dibuat', 'desc')->paginate(12);

        // Ambil semua kategori unik untuk filter (termasuk yang null)
        $kategoris = Portofolio::select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->pluck('kategori')
            ->filter()
            ->sort()
            ->values();

        // Hitung jumlah per kategori (termasuk yang tanpa kategori)
        $kategoriCounts = [];
        $totalSemua = Portofolio::count();
        $kategoriCounts['semua'] = $totalSemua;
        
        foreach ($kategoris as $kategori) {
            $kategoriCounts[$kategori] = Portofolio::where('kategori', $kategori)->count();
        }

        return view('pelanggan.portofolio.index', compact('portofolios', 'kategoris', 'kategoriCounts'));
    }
}

