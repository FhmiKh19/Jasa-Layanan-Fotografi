<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Portofolio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FotografiController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        $user = Auth::user();
        
        // Untuk fotografer, ambil semua pesanan (karena id_pengguna di pesanan adalah pelanggan)
        // Jika ada kolom id_fotografer di pesanan, gunakan itu. Untuk sementara, ambil semua pesanan
        // atau bisa disesuaikan dengan relasi layanan yang dimiliki fotografer
        
        // Total Jadwal (dari pesanan yang memiliki tanggal acara)
        $totalJadwal = Pesanan::whereNotNull('tgl_acara')
            ->count();
        
        // Pesanan Selesai bulan ini
        $pesananSelesai = Pesanan::where('status', 'selesai')
            ->whereMonth('tgl_pesanan', now()->month)
            ->whereYear('tgl_pesanan', now()->year)
            ->count();
        
        // Pesanan Pending
        $pesananPending = Pesanan::whereIn('status', ['pending', 'menunggu_pembayaran'])
            ->count();
        
        // Total Portofolio
        $totalPortofolio = Portofolio::count();
        
        // Pesanan Terbaru
        $pesananTerbaru = Pesanan::with(['pengguna', 'layanan'])
            ->orderBy('tgl_pesanan', 'desc')
            ->limit(10)
            ->get();
        
        // Jadwal Mendatang (10 jadwal terdekat)
        $jadwalMendatang = Pesanan::whereNotNull('tgl_acara')
            ->where('tgl_acara', '>=', now())
            ->with('layanan')
            ->orderBy('tgl_acara', 'asc')
            ->limit(10)
            ->get();
        
        return view('fotografer.dashboard', compact(
            'totalJadwal',
            'pesananSelesai',
            'pesananPending',
            'totalPortofolio',
            'pesananTerbaru',
            'jadwalMendatang'
        ));
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

    // Jadwal Methods
    public function jadwalIndex()
    {
        // Ambil jadwal dari pesanan yang memiliki tgl_acara dan status "diproses" atau "selesai"
        // Jadwal otomatis muncul ketika fotografer approve booking (ubah status ke "diproses")
        $jadwals = Pesanan::whereNotNull('tgl_acara')
            ->whereIn('status', ['diproses', 'selesai'])
            ->with(['layanan', 'pengguna'])
            ->orderBy('tgl_acara', 'asc')
            ->orderBy('tgl_pesanan', 'asc')
            ->get()
            ->map(function($pesanan) {
                // Map pesanan ke format jadwal yang diharapkan view
                return (object) [
                    'id_jadwal' => $pesanan->id_pesanan,
                    'id_pesanan' => $pesanan->id_pesanan,
                    'tgl_acara' => $pesanan->tgl_acara,
                    'waktu_mulai' => '09:00', // Default, bisa disesuaikan jika ada kolom waktu
                    'waktu_selesai' => '17:00', // Default
                    'nama_klien' => $pesanan->pengguna->nama_pengguna ?? 'Unknown',
                    'alamat' => $pesanan->alamat ?? '-',
                    'status' => $pesanan->status === 'selesai' ? 'selesai' : 'terjadwal',
                    'status_pesanan' => $pesanan->status,
                    'layanan' => $pesanan->layanan,
                    'pesanan' => $pesanan // Tambahkan object pesanan untuk akses data lengkap
                ];
            });
        
        return view('fotografer.jadwal.index', compact('jadwals'));
    }

    // NOTE: Method create, edit, dan destroy jadwal tidak diperlukan
    // karena jadwal otomatis dibuat dari pesanan yang dikonfirmasi.
    // Untuk mengubah jadwal, fotografer dapat mengubah status pesanan atau tanggal acara di detail pesanan.
    
    // Method di bawah ini tidak digunakan lagi (dapat dihapus jika tidak diperlukan)
    /*
    public function jadwalCreate()
    {
        return view('fotografer.jadwal.create');
    }

    public function jadwalStore(Request $request)
    {
        // TODO: Implement store logic
        return redirect()->route('fotografer.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function jadwalEdit($id)
    {
        return view('fotografer.jadwal.edit', compact('id'));
    }

    public function jadwalUpdate(Request $request, $id)
    {
        // TODO: Implement update logic
        return redirect()->route('fotografer.jadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }

    public function jadwalDestroy($id)
    {
        // TODO: Implement destroy logic
        return redirect()->route('fotografer.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
    */

    // Pesanan Methods
    public function pesananIndex()
    {
        $pesanan = Pesanan::with(['pengguna', 'layanan'])
            ->orderBy('tgl_pesanan', 'desc')
            ->paginate(10);
        return view('fotografer.pesanan.index', compact('pesanan'));
    }

    public function pesananShow($id)
    {
        $pesanan = Pesanan::with(['pengguna', 'layanan'])->findOrFail($id);
        return view('fotografer.pesanan.show', compact('pesanan'));
    }

    public function pesananUpdateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $oldStatus = $pesanan->status;
        $newStatus = $request->status;
        
        // Validasi: hanya bisa terima/tolak jika status masih pending
        if ($oldStatus !== 'pending' && in_array($newStatus, ['diproses', 'dibatalkan'])) {
            return redirect()->route('fotografer.pesanan.show', $id)
                ->with('error', 'Pesanan ini sudah diproses sebelumnya.');
        }
        
        // Validasi: hanya boleh aksi terima (diproses) atau tolak (dibatalkan)
        if (!in_array($newStatus, ['diproses', 'dibatalkan'])) {
            return redirect()->route('fotografer.pesanan.show', $id)
                ->with('error', 'Aksi tidak valid.');
        }
        
        // Jika status diubah ke "diproses", pastikan ada tanggal acara
        if ($newStatus === 'diproses' && !$pesanan->tgl_acara) {
            return redirect()->route('fotografer.pesanan.show', $id)
                ->with('error', 'Tidak dapat menerima pesanan. Tanggal acara belum diisi oleh pelanggan.');
        }
        
        $pesanan->status = $newStatus;
        $pesanan->save();
        
        // Pesan sukses berdasarkan aksi
        if ($newStatus === 'diproses') {
            $message = 'Pesanan berhasil diterima! Jadwal telah ditambahkan secara otomatis.';
        } else {
            $message = 'Pesanan berhasil ditolak.';
        }
        
        return redirect()->route('fotografer.pesanan.show', $id)->with('success', $message);
    }

    // Portofolio Methods
    public function portofolioIndex(Request $request)
    {
        $user = Auth::user();
        
        // Query portofolio
        $query = Portofolio::query();
        
        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }
        
        // Ambil portofolio dengan pagination
        $portofolios = $query->orderBy('tgl_dibuat', 'desc')->paginate(10);
        
        // Statistik
        $totalPortofolio = Portofolio::count();
        $totalGambar = Portofolio::whereNotNull('gambar')->count();
        $totalFeatured = Portofolio::where('kategori', 'featured')->count(); // Asumsi kategori 'featured' untuk featured
        
        // Kategori unik untuk filter
        $kategoris = Portofolio::whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->map(function($kat) {
                return (object) ['id_kategori' => $kat, 'nama_kategori' => $kat];
            })
            ->values();
        
        return view('fotografer.portofolio.index', compact(
            'portofolios',
            'totalPortofolio',
            'totalGambar',
            'totalFeatured',
            'kategoris'
        ));
    }

    public function portofolioCreate()
    {
        // Ambil kategori yang sudah dibuat oleh admin (dari portofolio yang sudah ada)
        $kategoris = Portofolio::whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->map(function($kat) {
                return (object) ['id_kategori' => $kat, 'nama_kategori' => $kat];
            })
            ->values();
        
        return view('fotografer.portofolio.create', compact('kategoris'));
    }

    public function portofolioStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tgl_dibuat' => now(),
            'id_fotografer' => $user->id_pengguna,
        ];

        // Upload gambar
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
                    \Log::info('Fotografer Portfolio image saved', [
                        'filename' => $gambarName, 
                        'path' => $path,
                        'full_path' => storage_path('app/public/portfolio/' . $gambarName)
                    ]);
                } else {
                    \Log::error('Fotografer Portfolio image failed to save', [
                        'filename' => $gambarName,
                        'path' => $path
                    ]);
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal menyimpan gambar. Silakan coba lagi.');
                }
            } catch (\Exception $e) {
                \Log::error('Fotografer Portfolio upload error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat upload gambar: ' . $e->getMessage());
            }
        }

        Portofolio::create($data);

        return redirect()->route('fotografer.portofolio.index')
            ->with('success', 'Gambar portofolio berhasil diupload.');
    }

    public function portofolioShow($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        return view('fotografer.portofolio.show', compact('portofolio'));
    }

    public function portofolioEdit($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        
        // Ambil kategori yang sudah dibuat oleh admin (dari portofolio yang sudah ada)
        $kategoris = Portofolio::whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->map(function($kat) {
                return (object) ['id_kategori' => $kat, 'nama_kategori' => $kat];
            })
            ->values();
        
        return view('fotografer.portofolio.edit', compact('portofolio', 'kategoris'));
    }

    public function portofolioUpdate(Request $request, $id)
    {
        $portofolio = Portofolio::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

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

                Storage::makeDirectory('public/portfolio');
                
                $gambar = $request->file('gambar');
                $gambarName = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                
                $path = $gambar->storeAs('portfolio', $gambarName, 'public');
                
                if (Storage::disk('public')->exists('portfolio/' . $gambarName)) {
                    $data['gambar'] = $gambarName;
                    \Log::info('Fotografer Portfolio image updated', [
                        'filename' => $gambarName, 
                        'path' => $path
                    ]);
                } else {
                    \Log::error('Fotografer Portfolio image update failed', [
                        'filename' => $gambarName
                    ]);
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal menyimpan gambar. Silakan coba lagi.');
                }
            } catch (\Exception $e) {
                \Log::error('Fotografer Portfolio update upload error', [
                    'error' => $e->getMessage()
                ]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat upload gambar: ' . $e->getMessage());
            }
        }

        $portofolio->update($data);

        return redirect()->route('fotografer.portofolio.index')
            ->with('success', 'Portofolio berhasil diupdate.');
    }

    public function portofolioToggleFeatured($id)
    {
        // TODO: Implement toggle featured logic
        return redirect()->back()->with('success', 'Status featured berhasil diubah');
    }

    public function portofolioDestroy($id)
    {
        Portofolio::findOrFail($id)->delete();
        return redirect()->route('fotografer.portofolio.index')->with('success', 'Portofolio berhasil dihapus');
    }

    // NOTE: Portofolio Kategori Methods sudah tidak digunakan
    // Kategori hanya bisa dibuat oleh admin, fotografer hanya bisa pilih kategori yang sudah ada
    // Method di bawah ini di-comment karena route sudah dihapus
    /*
    public function portofolioKategoriIndex()
    {
        // Kategori unik untuk ditampilkan
        $kategoris = Portofolio::whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->map(function($kat) {
                return (object) ['id_kategori' => $kat, 'nama_kategori' => $kat];
            })
            ->values();
        
        return view('fotografer.portofolio.kategori.index', compact('kategoris'));
    }

    public function portofolioKategoriCreate()
    {
        return view('fotografer.portofolio.kategori.create');
    }

    public function portofolioKategoriStore(Request $request)
    {
        // TODO: Implement store logic
        return redirect()->route('fotografer.portofolio.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function portofolioKategoriEdit($id)
    {
        return view('fotografer.portofolio.kategori.edit', compact('id'));
    }

    public function portofolioKategoriUpdate(Request $request, $id)
    {
        // TODO: Implement update logic
        return redirect()->route('fotografer.portofolio.kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function portofolioKategoriDestroy($id)
    {
        // TODO: Implement destroy logic
        return redirect()->route('fotografer.portofolio.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
    */

    // Portofolio Gambar Methods
    public function portofolioGambarSetCover($id)
    {
        // TODO: Implement set cover logic
        return redirect()->back()->with('success', 'Cover berhasil diubah');
    }

    public function portofolioGambarDestroy($id)
    {
        // TODO: Implement destroy logic
        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }

    // Chat Methods
    public function chatIndex()
    {
        $user = Auth::user();
        
        // Get unique customers from pesanan (orders)
        // For now, we'll get customers who have placed orders
        $customers = Pesanan::with('pengguna')
            ->select('id_pengguna')
            ->distinct()
            ->get()
            ->pluck('pengguna')
            ->filter()
            ->unique('id_pengguna')
            ->values();
        
        // Build conversations array
        $conversations = $customers->map(function($customer) {
            // For now, we don't have a Chat model, so we'll return empty last_message
            // In a real implementation, you would query the chat/messages table here
            return [
                'user' => $customer,
                'last_message' => null, // TODO: Get last message from chat table when implemented
                'unread_count' => 0, // TODO: Count unread messages when implemented
            ];
        });
        
        return view('fotografer.chat.index', compact('conversations'));
    }

    public function chatShow($id)
    {
        $user = Auth::user();
        $currentUserId = $user->id_pengguna;
        
        // Get the other user
        $otherUser = \App\Models\User::findOrFail($id);
        
        // For now, return empty messages since there's no Chat model
        // TODO: Implement when Chat model is created
        $messages = collect([]);
        
        return view('fotografer.chat.show', compact('otherUser', 'messages', 'currentUserId'));
    }
}
