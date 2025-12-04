<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestimoniReportController extends Controller
{
    // Tampilkan laporan testimoni
    public function index(Request $request)
    {
        $query = Testimoni::with('pengguna');

        // Filter berdasarkan rating
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tgl_dibuat', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tgl_dibuat', '<=', $request->tanggal_sampai);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pengguna', function($q) use ($search) {
                $q->where('nama_pengguna', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('komentar', 'like', "%{$search}%");
        }

        $testimoni = $query->orderBy('tgl_dibuat', 'desc')->paginate(10);

        // Statistik
        $stats = [
            'total' => Testimoni::count(),
            'rating_5' => Testimoni::where('rating', 5)->count(),
            'rating_4' => Testimoni::where('rating', 4)->count(),
            'rating_3' => Testimoni::where('rating', 3)->count(),
            'rating_2' => Testimoni::where('rating', 2)->count(),
            'rating_1' => Testimoni::where('rating', 1)->count(),
            'rata_rata' => Testimoni::avg('rating') ?? 0,
        ];

        // Grafik testimoni per bulan (6 bulan terakhir)
        $grafikTestimoni = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $count = Testimoni::whereMonth('tgl_dibuat', $bulan->month)
                ->whereYear('tgl_dibuat', $bulan->year)
                ->count();
            $grafikTestimoni[] = [
                'bulan' => $bulan->format('M Y'),
                'jumlah' => $count
            ];
        }

        // Grafik distribusi rating
        $grafikRating = Testimoni::select('rating', DB::raw('count(*) as jumlah'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'rating' => $item->rating . ' Bintang',
                    'jumlah' => $item->jumlah
                ];
            });

        return view('admin.testimoni-report', compact('testimoni', 'stats', 'grafikTestimoni', 'grafikRating'));
    }
}
