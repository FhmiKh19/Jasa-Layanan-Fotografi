<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPortofolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KategoriPortofolioController extends Controller
{
    // Daftar kategori
    public function index()
    {
        $kategoris = KategoriPortofolio::where('fotografer_id', Auth::id())
                                       ->withCount('portofolios')
                                       ->orderBy('urutan')
                                       ->get();

        return view('fotografer.portofolio.kategori.index', compact('kategoris'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('fotografer.portofolio.kategori.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('kategori_portofolio', 'public');
        }

        // Get max urutan
        $maxUrutan = KategoriPortofolio::where('fotografer_id', Auth::id())->max('urutan') ?? 0;

        KategoriPortofolio::create([
            'fotografer_id' => Auth::id(),
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'cover_image' => $coverPath,
            'urutan' => $maxUrutan + 1,
            'is_active' => true,
        ]);

        return redirect()->route('fotografer.portofolio.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Form edit kategori
    public function edit($id)
    {
        $kategori = KategoriPortofolio::where('id_kategori', $id)
                                      ->where('fotografer_id', Auth::id())
                                      ->firstOrFail();

        return view('fotografer.portofolio.kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $kategori = KategoriPortofolio::where('id_kategori', $id)
                                      ->where('fotografer_id', Auth::id())
                                      ->firstOrFail();

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            if ($kategori->cover_image && Storage::disk('public')->exists($kategori->cover_image)) {
                Storage::disk('public')->delete($kategori->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('kategori_portofolio', 'public');
        } else {
            $coverPath = $kategori->cover_image;
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'cover_image' => $coverPath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('fotografer.portofolio.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = KategoriPortofolio::where('id_kategori', $id)
                                      ->where('fotografer_id', Auth::id())
                                      ->firstOrFail();

        // Hapus cover image
        if ($kategori->cover_image && Storage::disk('public')->exists($kategori->cover_image)) {
            Storage::disk('public')->delete($kategori->cover_image);
        }

        $kategori->delete();

        return redirect()->route('fotografer.portofolio.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus!');
    }
}

