<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Storage;

class ServiceManagementController extends Controller
{
    // Tampilkan semua layanan
    public function index(Request $request)
    {
        // Reset filter jika ada parameter clear
        if ($request->has('clear')) {
            return redirect()->route('admin.services.index');
        }

        $query = Layanan::query();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'aktif') {
                $query->where('status', 'aktif');
            } elseif ($request->status === 'nonaktif') {
                $query->where('status', 'nonaktif');
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_layanan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Pastikan semua data ditampilkan, urutkan dari yang terbaru
        $layanan = $query->orderBy('tgl_dibuat', 'desc')
                        ->orderBy('id_layanan', 'desc')
                        ->paginate(12);

        // Statistik
        $totalLayanan = Layanan::count();
        $layananAktif = Layanan::where('status', 'aktif')->count();
        $layananNonaktif = Layanan::where('status', 'nonaktif')->count();
        
        // Statistik penggunaan layanan (berapa kali dipesan)
        $layananDenganPesanan = Layanan::withCount('pesanan')
            ->orderBy('pesanan_count', 'desc')
            ->limit(5)
            ->get();

        $stats = [
            'total' => $totalLayanan,
            'aktif' => $layananAktif,
            'nonaktif' => $layananNonaktif,
            'layanan_populer' => $layananDenganPesanan,
        ];

        return view('admin.service-management', compact('layanan', 'stats'));
    }

    // Form create layanan
    public function create()
    {
        return view('admin.service-form');
    }

    // Store layanan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'status' => $request->status,
            'tgl_dibuat' => now(),
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            // Pastikan directory ada
            Storage::makeDirectory('public/layanan');
            $path = $gambar->storeAs('public/layanan', $gambarName);
            
            // Debug: pastikan file tersimpan
            if (Storage::exists('public/layanan/' . $gambarName)) {
                $data['gambar'] = $gambarName;
            } else {
                \Log::error('Gambar gagal disimpan: ' . $gambarName);
            }
        }

        $layanan = Layanan::create($data);

        // Redirect ke halaman pertama tanpa filter untuk memastikan data baru terlihat
        return redirect()->route('admin.services.index', ['page' => 1])
            ->with('success', 'Layanan "' . $layanan->nama_layanan . '" berhasil ditambahkan.');
    }

    // Form edit layanan
    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.service-form', compact('layanan'));
    }

    // Update layanan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $layanan = Layanan::findOrFail($id);

        $data = [
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'status' => $request->status,
        ];

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($layanan->gambar && Storage::exists('public/layanan/' . $layanan->gambar)) {
                Storage::delete('public/layanan/' . $layanan->gambar);
            }

            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            // Pastikan directory ada
            Storage::makeDirectory('public/layanan');
            $gambar->storeAs('public/layanan', $gambarName);
            $data['gambar'] = $gambarName;
        }

        $layanan->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    // Toggle status layanan
    public function toggleStatus($id)
    {
        $layanan = Layanan::findOrFail($id);
        
        $layanan->status = $layanan->status === 'aktif' ? 'nonaktif' : 'aktif';
        $layanan->save();

        $statusLabel = $layanan->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()->with('success', "Layanan '{$layanan->nama_layanan}' berhasil {$statusLabel}.");
    }

    // Hapus layanan
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        // Cek apakah layanan sedang digunakan dalam pesanan
        $pesananCount = Pesanan::where('id_layanan', $id)->count();
        if ($pesananCount > 0) {
            return back()->with('error', "Layanan tidak dapat dihapus karena sedang digunakan dalam {$pesananCount} pesanan.");
        }

        // Hapus gambar jika ada
        if ($layanan->gambar && Storage::exists('public/layanan/' . $layanan->gambar)) {
            Storage::delete('public/layanan/' . $layanan->gambar);
        }

        $layanan->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}

