<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananFotograferController extends Controller
{
    // Daftar pesanan untuk fotografer login
    public function index()
    {
        $fotografer_id = Auth::id(); // Gunakan Auth::id() untuk mendapatkan ID user yang login

        // Ambil pesanan dengan relasi user dan layanan
        $pesanan = Pesanan::with('user', 'layanan')
                          ->where('fotografer_id', $fotografer_id)
                          ->orderBy('tgl_acara', 'DESC')
                          ->orderBy('created_at', 'DESC')
                          ->get();

        return view('fotografer.pesanan.index', compact('pesanan'));
    }

    public function show($id)
{
    $pesanan = Pesanan::with('user')
                ->where('id_pesanan', $id)
                ->firstOrFail();

    return view('fotografer.pesanan.show', compact('pesanan'));
}

    public function updateStatus(Request $request, $id)
{
    $pesanan = Pesanan::where('id_pesanan', $id)->firstOrFail();
    $pesanan->status = $request->status;
    $pesanan->save();

    return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
}
}
