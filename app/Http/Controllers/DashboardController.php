<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik User - hitung semua user berdasarkan role
        $totalFotografer = (int) User::where('role', 'fotografer')->count();
        $totalPelanggan = (int) User::where('role', 'pelanggan')->count();
        
        // Debug: Pastikan data ada
        \Log::info('Dashboard Stats', [
            'fotografer' => $totalFotografer,
            'pelanggan' => $totalPelanggan
        ]);
        
        // Force set jika null
        if (is_null($totalFotografer)) {
            $totalFotografer = 0;
        }
        if (is_null($totalPelanggan)) {
            $totalPelanggan = 0;
        }
        
        // Statistik Pesanan
        $pesananBulanIni = Pesanan::whereMonth('tgl_pesanan', now()->month)
            ->whereYear('tgl_pesanan', now()->year)
            ->count();
        
        // Pendapatan bulan ini (hanya pesanan selesai)
        $pendapatanBulanIni = Pesanan::whereMonth('pesanan.tgl_pesanan', now()->month)
            ->whereYear('pesanan.tgl_pesanan', now()->year)
            ->where('pesanan.status', 'selesai')
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->sum('layanan.harga');

        // Pesanan terbaru
        $pesananTerbaru = Pesanan::with(['pengguna', 'layanan'])
            ->orderBy('tgl_pesanan', 'desc')
            ->limit(5)
            ->get();

        // Grafik pesanan per bulan (6 bulan terakhir)
        $grafikPesanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $count = Pesanan::whereMonth('tgl_pesanan', $bulan->month)
                ->whereYear('tgl_pesanan', $bulan->year)
                ->count();
            $grafikPesanan[] = [
                'bulan' => $bulan->format('M Y'),
                'jumlah' => $count
            ];
        }

        // Grafik pesanan per status
        $grafikStatus = Pesanan::select('status', DB::raw('count(*) as jumlah'))
            ->groupBy('status')
            ->get()
            ->map(function($item) {
                return [
                    'status' => ucfirst($item->status),
                    'jumlah' => $item->jumlah
                ];
            });

        // Grafik pesanan per layanan (top 5)
        $grafikLayanan = Pesanan::select('layanan.nama_layanan', DB::raw('count(*) as jumlah'))
            ->join('layanan', 'pesanan.id_layanan', '=', 'layanan.id_layanan')
            ->groupBy('layanan.nama_layanan')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get();

        // Debug: Pastikan semua variabel ada
        $data = [
            'totalFotografer' => (int) $totalFotografer,
            'totalPelanggan' => (int) $totalPelanggan,
            'pesananBulanIni' => (int) $pesananBulanIni,
            'pendapatanBulanIni' => (float) ($pendapatanBulanIni ?? 0),
            'pesananTerbaru' => $pesananTerbaru,
            'grafikPesanan' => $grafikPesanan,
            'grafikStatus' => $grafikStatus,
            'grafikLayanan' => $grafikLayanan
        ];
        
        // Log untuk debug
        \Log::info('Dashboard Data Sent', $data);
        
        return view('dashboard-admin', $data);
    }
}
