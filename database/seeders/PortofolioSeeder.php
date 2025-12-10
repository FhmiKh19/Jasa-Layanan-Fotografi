<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portofolio;
use App\Models\User;

class PortofolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portofolio = [
            // Wedding - 5 portofolio
            [
                'judul' => 'Wedding di Bali',
                'kategori' => 'Wedding',
                'deskripsi' => 'Dokumentasi pernikahan mewah di resort Bali dengan pemandangan pantai yang indah. Konsep foto natural dan romantis.',
                'tgl_dibuat' => now()->subMonths(6),
            ],
            [
                'judul' => 'Wedding Garden Party',
                'kategori' => 'Wedding',
                'deskripsi' => 'Pernikahan dengan konsep garden party di outdoor venue. Dekorasi bunga segar dan suasana yang elegan.',
                'tgl_dibuat' => now()->subMonths(3),
            ],
            [
                'judul' => 'Wedding Intimate',
                'kategori' => 'Wedding',
                'deskripsi' => 'Pernikahan intim dengan 50 tamu undangan. Konsep minimalis dan elegan di indoor venue.',
                'tgl_dibuat' => now()->subWeeks(1),
            ],
            [
                'judul' => 'Wedding Traditional',
                'kategori' => 'Wedding',
                'deskripsi' => 'Pernikahan adat Jawa dengan prosesi lengkap. Dokumentasi tradisional yang penuh makna.',
                'tgl_dibuat' => now()->subDays(10),
            ],
            [
                'judul' => 'Wedding Modern',
                'kategori' => 'Wedding',
                'deskripsi' => 'Pernikahan modern dengan konsep industrial. Venue unik dengan dekorasi minimalis namun elegan.',
                'tgl_dibuat' => now()->subDays(3),
            ],
            // Pre-Wedding - 4 portofolio
            [
                'judul' => 'Pre-Wedding di Yogyakarta',
                'kategori' => 'Pre-Wedding',
                'deskripsi' => 'Sesi foto pre-wedding dengan latar belakang Candi Prambanan dan Malioboro. Konsep tradisional modern.',
                'tgl_dibuat' => now()->subMonths(5),
            ],
            [
                'judul' => 'Pre-Wedding Beach',
                'kategori' => 'Pre-Wedding',
                'deskripsi' => 'Sesi foto pre-wedding di pantai dengan sunset yang indah. Konsep romantis dan natural.',
                'tgl_dibuat' => now()->subDays(5),
            ],
            [
                'judul' => 'Pre-Wedding Urban',
                'kategori' => 'Pre-Wedding',
                'deskripsi' => 'Sesi foto pre-wedding di tengah kota dengan konsep urban dan modern. Lokasi unik dengan arsitektur menarik.',
                'tgl_dibuat' => now()->subWeeks(2),
            ],
            [
                'judul' => 'Pre-Wedding Nature',
                'kategori' => 'Pre-Wedding',
                'deskripsi' => 'Sesi foto pre-wedding di alam terbuka dengan pemandangan hijau. Konsep natural dan fresh.',
                'tgl_dibuat' => now()->subDays(7),
            ],
            // Engagement - 3 portofolio
            [
                'judul' => 'Engagement di Bandung',
                'kategori' => 'Engagement',
                'deskripsi' => 'Momen tunangan yang romantis di Lembang dengan suasana sejuk dan pemandangan gunung.',
                'tgl_dibuat' => now()->subMonths(4),
            ],
            [
                'judul' => 'Engagement Sunset',
                'kategori' => 'Engagement',
                'deskripsi' => 'Momen tunangan di pantai dengan sunset yang memukau. Konsep romantis dan penuh emosi.',
                'tgl_dibuat' => now()->subWeeks(3),
            ],
            [
                'judul' => 'Engagement Indoor',
                'kategori' => 'Engagement',
                'deskripsi' => 'Sesi foto engagement di studio dengan konsep elegan dan klasik. Lighting profesional untuk hasil maksimal.',
                'tgl_dibuat' => now()->subDays(4),
            ],
            // Family - 3 portofolio
            [
                'judul' => 'Family Photo Session',
                'kategori' => 'Family',
                'deskripsi' => 'Sesi foto keluarga 3 generasi dengan latar belakang alam. Momen hangat dan penuh kasih sayang.',
                'tgl_dibuat' => now()->subMonths(2),
            ],
            [
                'judul' => 'Family Outdoor',
                'kategori' => 'Family',
                'deskripsi' => 'Sesi foto keluarga di taman dengan suasana ceria. Dokumentasi momen kebersamaan yang berharga.',
                'tgl_dibuat' => now()->subWeeks(4),
            ],
            [
                'judul' => 'Family Home Session',
                'kategori' => 'Family',
                'deskripsi' => 'Sesi foto keluarga di rumah dengan konsep natural dan candid. Momen sehari-hari yang penuh kehangatan.',
                'tgl_dibuat' => now()->subDays(6),
            ],
            // Corporate - 3 portofolio
            [
                'judul' => 'Corporate Event Jakarta',
                'kategori' => 'Corporate',
                'deskripsi' => 'Dokumentasi acara perusahaan tahunan dengan 500 peserta. Coverage lengkap dari opening hingga closing ceremony.',
                'tgl_dibuat' => now()->subMonths(1),
            ],
            [
                'judul' => 'Corporate Seminar',
                'kategori' => 'Corporate',
                'deskripsi' => 'Dokumentasi seminar perusahaan dengan pembicara profesional. Coverage presentasi dan networking session.',
                'tgl_dibuat' => now()->subWeeks(2),
            ],
            [
                'judul' => 'Corporate Product Launch',
                'kategori' => 'Corporate',
                'deskripsi' => 'Dokumentasi peluncuran produk baru dengan konsep modern. Coverage press conference dan demo produk.',
                'tgl_dibuat' => now()->subDays(2),
            ],
            // Graduation - 2 portofolio
            [
                'judul' => 'Graduation Photo',
                'kategori' => 'Graduation',
                'deskripsi' => 'Sesi foto wisuda dengan latar belakang kampus. Momen kebanggaan dan pencapaian akademik.',
                'tgl_dibuat' => now()->subWeeks(3),
            ],
            [
                'judul' => 'Graduation Ceremony',
                'kategori' => 'Graduation',
                'deskripsi' => 'Dokumentasi upacara wisuda dengan prosesi lengkap. Momen bersejarah yang tak terlupakan.',
                'tgl_dibuat' => now()->subDays(8),
            ],
            // Event - 2 portofolio
            [
                'judul' => 'Birthday Party Kids',
                'kategori' => 'Event',
                'deskripsi' => 'Dokumentasi pesta ulang tahun anak dengan tema superhero. Suasana ceria dan penuh warna.',
                'tgl_dibuat' => now()->subWeeks(2),
            ],
            [
                'judul' => 'Birthday Party Adult',
                'kategori' => 'Event',
                'deskripsi' => 'Dokumentasi pesta ulang tahun dewasa dengan konsep elegan. Dekorasi mewah dan suasana meriah.',
                'tgl_dibuat' => now()->subDays(1),
            ],
        ];

        // Ambil semua fotografer untuk assign random
        $fotografers = User::where('role', 'fotografer')->where('status_akun', 'aktif')->pluck('id_pengguna')->toArray();
        
        foreach ($portofolio as $item) {
            // Assign random fotografer jika ada
            if (!empty($fotografers)) {
                $item['id_fotografer'] = $fotografers[array_rand($fotografers)];
            }
            
            Portofolio::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }
    }
}
