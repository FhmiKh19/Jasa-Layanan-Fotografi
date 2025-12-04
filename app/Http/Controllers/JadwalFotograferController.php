<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalFotografer;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class JadwalFotograferController extends Controller
{
    // Tampilkan semua jadwal milik fotografer login
    public function index()
    {
        $userId = Auth::id();
        $jadwals = JadwalFotografer::with('layanan')
                    ->where('id_pengguna', $userId)
                    ->orderBy('id_jadwal', 'asc')
                    ->get();

        return view('fotografer.jadwal.index', compact('jadwals'));
    }

    // Form tambah jadwal
    public function create()
    {
        $layanans = Layanan::all();
        return view('fotografer.jadwal.create', compact('layanans'));
    }

    // Simpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'tgl_acara' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'nama_klien' => 'required',
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'alamat' => 'required',
        ]);

        $data = [
            'id_pengguna' => Auth::id(),
            'tgl_acara' => $request->tgl_acara,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'nama_klien' => $request->nama_klien,
            'id_layanan' => $request->id_layanan,
            'alamat' => $request->alamat,
            'catatan' => $request->catatan ?? null,
            'status' => 'terjadwal',
        ];
        
        // Jika kolom tanggal ada, isi dengan tgl_acara
        if (Schema::hasColumn('jadwal_fotografer', 'tanggal')) {
            $data['tanggal'] = $request->tgl_acara;
        }
        
        // Jika kolom jam_mulai dan jam_selesai ada, isi dengan waktu_mulai dan waktu_selesai
        if (Schema::hasColumn('jadwal_fotografer', 'jam_mulai')) {
            $data['jam_mulai'] = $request->waktu_mulai;
        }
        if (Schema::hasColumn('jadwal_fotografer', 'jam_selesai')) {
            $data['jam_selesai'] = $request->waktu_selesai;
        }
        
        JadwalFotografer::create($data);

        return redirect()->route('fotografer.jadwal.index')
                         ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Form edit jadwal
    public function edit($id)
    {
        $jadwal = JadwalFotografer::findOrFail($id);

        if ($jadwal->id_pengguna !== Auth::id()) {
            abort(403);
        }

        $layanans = Layanan::all();
        return view('fotografer.jadwal.edit', compact('jadwal', 'layanans'));
    }

    // Update jadwal
    public function update(Request $request, $id)
    {
        $jadwal = JadwalFotografer::findOrFail($id);

        if ($jadwal->id_pengguna !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'tgl_acara' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'nama_klien' => 'required',
            'id_layanan' => 'required|exists:layanan,id_layanan',
            'alamat' => 'required',
        ]);

        $data = [
            'tgl_acara' => $request->tgl_acara,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'nama_klien' => $request->nama_klien,
            'id_layanan' => $request->id_layanan,
            'alamat' => $request->alamat,
            'catatan' => $request->catatan ?? null,
        ];
        
        // Jika kolom tanggal ada, isi dengan tgl_acara
        if (Schema::hasColumn('jadwal_fotografer', 'tanggal')) {
            $data['tanggal'] = $request->tgl_acara;
        }
        
        // Jika kolom jam_mulai dan jam_selesai ada, isi dengan waktu_mulai dan waktu_selesai
        if (Schema::hasColumn('jadwal_fotografer', 'jam_mulai')) {
            $data['jam_mulai'] = $request->waktu_mulai;
        }
        if (Schema::hasColumn('jadwal_fotografer', 'jam_selesai')) {
            $data['jam_selesai'] = $request->waktu_selesai;
        }
        
        $jadwal->update($data);

        return redirect()->route('fotografer.jadwal.index')
                         ->with('success', 'Jadwal berhasil diupdate.');
    }

    // Hapus jadwal
    public function destroy($id)
    {
        $jadwal = JadwalFotografer::findOrFail($id);

        if ($jadwal->id_pengguna !== Auth::id()) {
            abort(403);
        }

        $jadwal->delete();

        return redirect()->route('fotografer.jadwal.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }
}
