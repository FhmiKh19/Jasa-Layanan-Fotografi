<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalFotografer;
use App\Models\Pesanan;
use App\Models\Laporan;
use App\Models\Portofolio;

class AuthFotograferController extends Controller
{
    // ==========================
    // FORM LOGIN
    // ==========================
    public function loginForm()
    {
        return view('fotografer.login');
    }

    // ==========================
    // PROSES LOGIN
    // ==========================
    public function loginProcess(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Login berdasarkan username + role fotografer
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
            'role'     => 'fotografer'
        ])) {
            return redirect()->route('fotografer.dashboard');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    // ==========================
    // DASHBOARD
    // ==========================
    public function dashboard()
    {
        $userId = Auth::id();
        
        // Statistik
        $totalJadwal = JadwalFotografer::where('id_pengguna', $userId)->count();
        $pesananSelesai = Pesanan::where('fotografer_id', $userId)->where('status', 'selesai')->count();
        $pesananPending = Pesanan::where('fotografer_id', $userId)->where('status', 'pending')->count();
        $totalPortofolio = Portofolio::where('fotografer_id', $userId)->count();
        
        // Data terbaru
        $pesananTerbaru = Pesanan::with('user')
            ->where('fotografer_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $jadwalMendatang = JadwalFotografer::with('layanan')
            ->where('id_pengguna', $userId)
            ->where('tgl_acara', '>=', now()->format('Y-m-d'))
            ->orderBy('tgl_acara', 'asc')
            ->limit(5)
            ->get();
            
        $laporanTerbaru = Laporan::where('fotografer_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->limit(3)
            ->get();
        
        return view('fotografer.dashboard', compact(
            'totalJadwal',
            'pesananSelesai', 
            'pesananPending',
            'totalPortofolio',
            'pesananTerbaru',
            'jadwalMendatang',
            'laporanTerbaru'
        ));
    }

    // ==========================
    // LOGOUT
    // ==========================
    public function logout()
    {
        Auth::logout();
        return redirect()->route('fotografer.login');
    }
}
