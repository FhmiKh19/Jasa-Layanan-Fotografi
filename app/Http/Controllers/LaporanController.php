<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Menampilkan semua laporan milik fotografer yang login
    public function index()
    {
        $fotografer_id = Auth::id(); // Gunakan Auth::id() untuk mendapatkan ID user yang login

        $laporan = Laporan::where('fotografer_id', $fotografer_id)
                          ->orderBy('tanggal', 'DESC')
                          ->get();

        return view('fotografer.laporan.index', compact('laporan'));
    }

    // Form tambah laporan
    public function create()
    {
        return view('fotografer.laporan.create');
    }

    // Simpan laporan baru
    public function store(Request $request)
    {
        $fotografer_id = Auth::id(); // Gunakan Auth::id() untuk mendapatkan ID user yang login

        $request->validate([
            'tanggal'       => 'required|date',
            'judul'         => 'required|string|max:255',
            'ringkasan'     => 'required|string',
            'foto_kegiatan' => 'nullable|image|max:2048',
        ]);

        // Upload foto
        $foto = null;
        if ($request->hasFile('foto_kegiatan')) {
            $foto = $request->file('foto_kegiatan')->store('laporan_foto', 'public');
        }

        // Simpan ke DB
        Laporan::create([
            'fotografer_id' => $fotografer_id,
            'tanggal'       => $request->tanggal,
            'judul'         => $request->judul,
            'ringkasan'     => $request->ringkasan,
            'foto_kegiatan' => $foto,
        ]);

        return redirect()->route('fotografer.laporan.index')
                         ->with('success', 'Laporan berhasil disimpan!');
    }

    // Form edit
    public function edit($id_laporan)
    {
        $laporan = Laporan::findOrFail($id_laporan);
        return view('fotografer.laporan.edit', compact('laporan'));
    }

    // Update laporan
    public function update(Request $request, $id_laporan)
    {
        $request->validate([
            'tanggal'       => 'required|date',
            'judul'         => 'required|string|max:255',
            'ringkasan'     => 'required|string',
            'foto_kegiatan' => 'nullable|image|max:2048',
        ]);

        $laporan = Laporan::findOrFail($id_laporan);

        // Jika upload foto baru
        if ($request->hasFile('foto_kegiatan')) {
            $foto = $request->file('foto_kegiatan')->store('laporan_foto', 'public');
        } else {
            $foto = $laporan->foto_kegiatan;
        }

        $laporan->update([
            'tanggal'       => $request->tanggal,
            'judul'         => $request->judul,
            'ringkasan'     => $request->ringkasan,
            'foto_kegiatan' => $foto,
        ]);

        return redirect()->route('fotografer.laporan.index')
                         ->with('success', 'Laporan berhasil diperbarui!');
    }

    // Hapus laporan
    public function destroy($id_laporan)
    {
        $laporan = Laporan::findOrFail($id_laporan);
        $laporan->delete();

        return redirect()->route('fotografer.laporan.index')
                         ->with('success', 'Laporan berhasil dihapus!');
    }
}
