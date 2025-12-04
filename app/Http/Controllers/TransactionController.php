<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // Tampilkan semua transaksi selesai
    public function index(Request $request)
    {
        // Query hanya transaksi dengan status 'selesai'
        $query = Pesanan::with(['pengguna', 'layanan'])
            ->where('status', 'selesai');

        // Filter berdasarkan metode pembayaran
        if ($request->has('metode_pembayaran') && $request->metode_pembayaran != '') {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // Filter berdasarkan tanggal (range)
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('updated_at', '>=', $request->tanggal_dari);
        }
        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('updated_at', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan periode (hari ini, minggu ini, bulan ini, tahun ini)
        if ($request->has('periode') && $request->periode != '') {
            switch ($request->periode) {
                case 'hari_ini':
                    $query->whereDate('updated_at', Carbon::today());
                    break;
                case 'minggu_ini':
                    $query->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('updated_at', Carbon::now()->month)
                          ->whereYear('updated_at', Carbon::now()->year);
                    break;
                case 'tahun_ini':
                    $query->whereYear('updated_at', Carbon::now()->year);
                    break;
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('pengguna', function($q2) use ($search) {
                      $q2->where('nama_pengguna', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  })
                  ->orWhereHas('layanan', function($q3) use ($search) {
                      $q3->where('nama_layanan', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->orderBy('updated_at', 'desc')->paginate(15);

        // Statistik transaksi
        $totalTransaksi = Pesanan::where('status', 'selesai')->count();
        $totalPendapatan = Pesanan::where('pesanan.status', 'selesai')
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->sum('layanan.harga');
        $rataRataTransaksi = $totalTransaksi > 0 ? ($totalPendapatan / $totalTransaksi) : 0;

        // Pendapatan hari ini
        $pendapatanHariIni = Pesanan::where('pesanan.status', 'selesai')
            ->whereDate('pesanan.updated_at', Carbon::today())
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->sum('layanan.harga');

        // Pendapatan bulan ini
        $pendapatanBulanIni = Pesanan::where('pesanan.status', 'selesai')
            ->whereMonth('pesanan.updated_at', Carbon::now()->month)
            ->whereYear('pesanan.updated_at', Carbon::now()->year)
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->sum('layanan.harga');

        // Statistik per metode pembayaran
        $statistikMetode = Pesanan::where('pesanan.status', 'selesai')
            ->whereNotNull('pesanan.metode_pembayaran')
            ->select('pesanan.metode_pembayaran', DB::raw('count(*) as jumlah'), DB::raw('sum(layanan.harga) as total'))
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->groupBy('pesanan.metode_pembayaran')
            ->get();

        // Pendapatan per bulan (untuk chart - 6 bulan terakhir)
        $pendapatanPerBulan = Pesanan::where('pesanan.status', 'selesai')
            ->where('pesanan.updated_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw('DATE_FORMAT(pesanan.updated_at, "%Y-%m") as bulan'),
                DB::raw('sum(layanan.harga) as total')
            )
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $stats = [
            'total_transaksi' => $totalTransaksi,
            'total_pendapatan' => $totalPendapatan,
            'rata_rata' => $rataRataTransaksi,
            'pendapatan_hari_ini' => $pendapatanHariIni,
            'pendapatan_bulan_ini' => $pendapatanBulanIni,
            'statistik_metode' => $statistikMetode,
            'pendapatan_per_bulan' => $pendapatanPerBulan,
        ];

        // Daftar metode pembayaran unik untuk filter
        $metodePembayaran = Pesanan::where('status', 'selesai')
            ->whereNotNull('metode_pembayaran')
            ->distinct()
            ->pluck('metode_pembayaran')
            ->filter()
            ->values();

        return view('admin.transactions', compact('transactions', 'stats', 'metodePembayaran'));
    }

    // Detail transaksi
    public function show($id)
    {
        $transaction = Pesanan::with(['pengguna', 'layanan'])
            ->where('status', 'selesai')
            ->findOrFail($id);
        
        return view('admin.transaction-detail', compact('transaction'));
    }
}

