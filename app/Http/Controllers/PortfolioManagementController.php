<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

class PortfolioManagementController extends Controller
{
    /**
     * Tampilkan daftar semua portofolio
     * Support filter kategori dan search
     */
    public function index(Request $request)
    {
        $query = Portofolio::query();

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
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

        $portofolio = $query->orderBy('tgl_dibuat', 'desc')->paginate(10);

        // Statistik
        $stats = [
            'total' => Portofolio::count(),
            'dengan_gambar' => Portofolio::whereNotNull('gambar')->count(),
        ];

        // Kategori unik untuk filter - gabungkan dari portofolio dan layanan
        $kategorisPortofolio = Portofolio::whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->values();
        
        $kategorisLayanan = Layanan::where('status', 'aktif')
            ->distinct()
            ->pluck('nama_layanan')
            ->filter()
            ->values();
        
        // Gabungkan dan hapus duplikat
        $kategoris = $kategorisPortofolio->merge($kategorisLayanan)->unique()->values();

        return view('admin.portfolio-management', compact('portofolio', 'stats', 'kategoris'));
    }

    /**
     * Tampilkan form tambah portofolio baru
     */
    public function create()
    {
        return view('admin.portfolio-form');
    }

    /**
     * Simpan portofolio baru ke database
     * Upload gambar jika ada
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tgl_dibuat' => now(),
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            try {
            // Pastikan directory ada
            Storage::makeDirectory('public/portfolio');
            
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            
            // Simpan menggunakan disk public
            $path = $gambar->storeAs('portfolio', $gambarName, 'public');
            
            // Pastikan file tersimpan
            if (Storage::disk('public')->exists('portfolio/' . $gambarName)) {
                $data['gambar'] = $gambarName;
                    \Log::info('Admin Portfolio image saved', [
                        'filename' => $gambarName, 
                        'path' => $path,
                        'full_path' => storage_path('app/public/portfolio/' . $gambarName)
                    ]);
            } else {
                    \Log::error('Admin Portfolio image failed to save', [
                        'filename' => $gambarName,
                        'path' => $path
                    ]);
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal menyimpan gambar. Silakan coba lagi.');
                }
            } catch (\Exception $e) {
                \Log::error('Admin Portfolio upload error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat upload gambar: ' . $e->getMessage());
            }
        }

        Portofolio::create($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portofolio berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit portofolio
     */
    public function edit($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        return view('admin.portfolio-form', compact('portofolio'));
    }

    /**
     * Update data portofolio
     * Jika upload gambar baru, gambar lama akan dihapus
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $portofolio = Portofolio::findOrFail($id);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ];

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            try {
            // Hapus gambar lama jika ada
            if ($portofolio->gambar && Storage::disk('public')->exists('portfolio/' . $portofolio->gambar)) {
                Storage::disk('public')->delete('portfolio/' . $portofolio->gambar);
            }

            // Pastikan directory ada
            Storage::makeDirectory('public/portfolio');
            
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            
            // Simpan menggunakan disk public
            $path = $gambar->storeAs('portfolio', $gambarName, 'public');
            
            // Pastikan file tersimpan
            if (Storage::disk('public')->exists('portfolio/' . $gambarName)) {
                $data['gambar'] = $gambarName;
                    \Log::info('Admin Portfolio image updated', [
                        'filename' => $gambarName, 
                        'path' => $path
                    ]);
                } else {
                    \Log::error('Admin Portfolio image update failed', [
                        'filename' => $gambarName
                    ]);
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal menyimpan gambar. Silakan coba lagi.');
                }
            } catch (\Exception $e) {
                \Log::error('Admin Portfolio update upload error', [
                    'error' => $e->getMessage()
                ]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat upload gambar: ' . $e->getMessage());
            }
        }

        $portofolio->update($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portofolio berhasil diperbarui.');
    }

    /**
     * Hapus portofolio dari database
     * Hapus gambar dari storage juga
     */
    public function destroy($id)
    {
        $portofolio = Portofolio::findOrFail($id);

        // Hapus gambar jika ada
        if ($portofolio->gambar && Storage::disk('public')->exists('portfolio/' . $portofolio->gambar)) {
            Storage::disk('public')->delete('portfolio/' . $portofolio->gambar);
        }

        $portofolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portofolio berhasil dihapus.');
    }
}
