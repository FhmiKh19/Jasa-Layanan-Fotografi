<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portofolio;
use App\Models\PortofolioGambar;
use App\Models\KategoriPortofolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PortofolioController extends Controller
{
    // Daftar portofolio milik fotografer yang login
    public function index(Request $request)
    {
        $fotografer_id = Auth::id();

        $query = Portofolio::with(['kategori', 'gambars'])
                           ->where('fotografer_id', $fotografer_id);

        // Filter by kategori
        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        $portofolios = $query->orderBy('created_at', 'desc')->get();

        // Get kategoris for filter
        $kategoris = KategoriPortofolio::where('fotografer_id', $fotografer_id)
                                       ->orderBy('urutan')
                                       ->get();

        // Hitung statistik
        $totalPortofolio = Portofolio::where('fotografer_id', $fotografer_id)->count();
        $totalGambar = PortofolioGambar::whereIn('portofolio_id', 
            Portofolio::where('fotografer_id', $fotografer_id)->pluck('id_portofolio')
        )->count();
        $totalFeatured = Portofolio::where('fotografer_id', $fotografer_id)->where('is_featured', true)->count();

        return view('fotografer.portofolio.index', compact(
            'portofolios', 
            'kategoris', 
            'totalPortofolio', 
            'totalGambar',
            'totalFeatured'
        ));
    }

    // Form tambah portofolio
    public function create()
    {
        // Ambil semua kategori aktif milik fotografer yang login
        $kategoris = KategoriPortofolio::where('fotografer_id', Auth::id())
                                       ->where('is_active', 1)
                                       ->orderBy('urutan')
                                       ->orderBy('nama_kategori')
                                       ->get();

        return view('fotografer.portofolio.create', compact('kategoris'));
    }

    // Simpan portofolio baru dengan multiple gambar
    public function store(Request $request)
    {
        // Validasi kategori_id dengan custom rule
        $kategoriRule = [
            'required',
            function ($attribute, $value, $fail) {
                if (empty($value)) {
                    $fail('Pilih kategori terlebih dahulu.');
                    return;
                }
                $kategori = KategoriPortofolio::where('id_kategori', $value)
                                              ->where('fotografer_id', Auth::id())
                                              ->where('is_active', true)
                                              ->first();
                if (!$kategori) {
                    $fail('Kategori yang dipilih tidak valid atau tidak aktif.');
                }
            },
        ];

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => $kategoriRule,
            'deskripsi' => 'nullable|string',
            'gambars' => 'required|array|min:1',
            'gambars.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'tanggal_foto' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
        ], [
            'kategori_id.required' => 'Pilih kategori terlebih dahulu.',
            'gambars.required' => 'Pilih minimal 1 foto untuk diupload.',
            'gambars.min' => 'Pilih minimal 1 foto untuk diupload.',
            'tanggal_foto.date' => 'Format tanggal tidak valid.',
        ]);

        DB::beginTransaction();
        try {
            // Buat portofolio
            $portofolio = Portofolio::create([
                'fotografer_id' => Auth::id(),
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi ?? null,
                'tanggal_foto' => $request->tanggal_foto ?: null,
                'lokasi' => $request->lokasi ?? null,
                'is_featured' => $request->has('is_featured'),
            ]);

            // Upload gambar-gambar
            if ($request->hasFile('gambars')) {
                $urutan = 1;
                foreach ($request->file('gambars') as $index => $gambar) {
                    $path = $gambar->store('portofolio/' . $portofolio->id_portofolio, 'public');
                    
                    PortofolioGambar::create([
                        'portofolio_id' => $portofolio->id_portofolio,
                        'file_gambar' => $path,
                        'urutan' => $urutan,
                        'is_cover' => ($urutan === 1), // Gambar pertama jadi cover
                    ]);
                    $urutan++;
                }
            }

            DB::commit();
            return redirect()->route('fotografer.portofolio.index')
                             ->with('success', 'Portofolio dengan ' . ($urutan - 1) . ' gambar berhasil diupload!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupload portofolio: ' . $e->getMessage());
        }
    }

    // Detail portofolio
    public function show($id)
    {
        $portofolio = Portofolio::with(['kategori', 'gambars'])
                                ->where('id_portofolio', $id)
                                ->where('fotografer_id', Auth::id())
                                ->firstOrFail();

        return view('fotografer.portofolio.show', compact('portofolio'));
    }

    // Form edit portofolio
    public function edit($id)
    {
        $portofolio = Portofolio::with('gambars')
                                ->where('id_portofolio', $id)
                                ->where('fotografer_id', Auth::id())
                                ->firstOrFail();

        $kategoris = KategoriPortofolio::where('fotografer_id', Auth::id())
                                       ->orderBy('urutan')
                                       ->get();

        return view('fotografer.portofolio.edit', compact('portofolio', 'kategoris'));
    }

    // Update portofolio
    public function update(Request $request, $id)
    {
        $portofolio = Portofolio::where('id_portofolio', $id)
                                ->where('fotografer_id', Auth::id())
                                ->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_portofolios,id_kategori',
            'deskripsi' => 'nullable|string',
            'gambars' => 'nullable|array',
            'gambars.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'tanggal_foto' => 'nullable|date',
            'lokasi' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $portofolio->update([
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tanggal_foto' => $request->tanggal_foto,
                'lokasi' => $request->lokasi,
                'is_featured' => $request->has('is_featured'),
            ]);

            // Upload gambar baru jika ada
            if ($request->hasFile('gambars')) {
                $maxUrutan = $portofolio->gambars()->max('urutan') ?? 0;
                $urutan = $maxUrutan + 1;
                
                foreach ($request->file('gambars') as $gambar) {
                    $path = $gambar->store('portofolio/' . $portofolio->id_portofolio, 'public');
                    
                    PortofolioGambar::create([
                        'portofolio_id' => $portofolio->id_portofolio,
                        'file_gambar' => $path,
                        'urutan' => $urutan,
                        'is_cover' => false,
                    ]);
                    $urutan++;
                }
            }

            DB::commit();
            return redirect()->route('fotografer.portofolio.index')
                             ->with('success', 'Portofolio berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui portofolio: ' . $e->getMessage());
        }
    }

    // Hapus portofolio
    public function destroy($id)
    {
        $portofolio = Portofolio::with('gambars')
                                ->where('id_portofolio', $id)
                                ->where('fotografer_id', Auth::id())
                                ->firstOrFail();

        // Hapus semua gambar
        foreach ($portofolio->gambars as $gambar) {
            if (Storage::disk('public')->exists($gambar->file_gambar)) {
                Storage::disk('public')->delete($gambar->file_gambar);
            }
        }

        // Hapus folder portofolio
        Storage::disk('public')->deleteDirectory('portofolio/' . $portofolio->id_portofolio);

        $portofolio->delete();

        return redirect()->route('fotografer.portofolio.index')
                         ->with('success', 'Portofolio berhasil dihapus!');
    }

    // Hapus gambar individual
    public function destroyGambar($id)
    {
        $gambar = PortofolioGambar::where('id_gambar', $id)->firstOrFail();
        
        // Cek kepemilikan
        $portofolio = Portofolio::where('id_portofolio', $gambar->portofolio_id)
                                ->where('fotografer_id', Auth::id())
                                ->firstOrFail();

        // Hapus file
        if (Storage::disk('public')->exists($gambar->file_gambar)) {
            Storage::disk('public')->delete($gambar->file_gambar);
        }

        // Jika gambar ini adalah cover, set gambar lain sebagai cover
        if ($gambar->is_cover) {
            $nextGambar = PortofolioGambar::where('portofolio_id', $gambar->portofolio_id)
                                          ->where('id_gambar', '!=', $id)
                                          ->orderBy('urutan')
                                          ->first();
            if ($nextGambar) {
                $nextGambar->update(['is_cover' => true]);
            }
        }

        $gambar->delete();

        return back()->with('success', 'Gambar berhasil dihapus!');
    }

    // Set gambar sebagai cover
    public function setCover($id)
    {
        $gambar = PortofolioGambar::where('id_gambar', $id)->firstOrFail();
        
        // Cek kepemilikan
        $portofolio = Portofolio::where('id_portofolio', $gambar->portofolio_id)
                                ->where('fotografer_id', Auth::id())
                                ->firstOrFail();

        // Reset semua cover
        PortofolioGambar::where('portofolio_id', $gambar->portofolio_id)
                        ->update(['is_cover' => false]);

        // Set gambar ini sebagai cover
        $gambar->update(['is_cover' => true]);

        return back()->with('success', 'Gambar berhasil dijadikan cover!');
    }

    // Toggle featured
    public function toggleFeatured($id)
    {
        $portofolio = Portofolio::where('id_portofolio', $id)
                                ->where('fotografer_id', Auth::id())
                                ->firstOrFail();

        $portofolio->update([
            'is_featured' => !$portofolio->is_featured
        ]);

        $message = $portofolio->is_featured 
            ? 'Portofolio ditandai sebagai featured!' 
            : 'Portofolio dihapus dari featured!';

        return redirect()->back()->with('success', $message);
    }
}
