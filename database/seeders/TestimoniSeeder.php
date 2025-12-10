<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimoni;
use App\Models\User;
use App\Models\Pesanan;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil pesanan yang sudah selesai
        $pesananSelesai = Pesanan::where('status', 'selesai')
            ->with('pengguna')
            ->get()
            ->unique('id_pengguna');

        if ($pesananSelesai->isEmpty()) {
            $this->command->warn('Tidak ada pesanan selesai. Jalankan PesananSeeder terlebih dahulu.');
            return;
        }

        $testimoni = [
            [
                'komentar' => 'Pelayanan sangat memuaskan! Foto-foto hasilnya sangat bagus dan sesuai ekspektasi. Fotografernya profesional dan ramah. Highly recommended!',
                'rating' => 5,
            ],
            [
                'komentar' => 'Hasil foto wedding kami sangat indah. Tim fotografer sangat detail dan sabar. Proses editing juga cepat. Terima kasih banyak!',
                'rating' => 5,
            ],
            [
                'komentar' => 'Paket pre-wedding yang kami pilih sangat worth it. Lokasi foto bagus, hasil editing profesional. Puas dengan pelayanannya.',
                'rating' => 5,
            ],
            [
                'komentar' => 'Foto engagement kami sangat bagus! Konsepnya sesuai dengan yang kami inginkan. Terima kasih untuk momen indah yang terabadikan.',
                'rating' => 5,
            ],
            [
                'komentar' => 'Pelayanan baik, hasil foto bagus. Hanya saja proses editing agak lama. Tapi overall sangat memuaskan.',
                'rating' => 4,
            ],
            [
                'komentar' => 'Foto family session kami sangat natural dan hangat. Fotografer bisa membuat suasana jadi santai sehingga hasilnya tidak kaku.',
                'rating' => 5,
            ],
            [
                'komentar' => 'Dokumentasi corporate event kami sangat lengkap. Semua momen penting tercover dengan baik. Profesional dan tepat waktu.',
                'rating' => 5,
            ],
            [
                'komentar' => 'Foto wisuda saya bagus sekali! Editing-nya natural dan tidak berlebihan. Harga juga reasonable untuk kualitas seperti ini.',
                'rating' => 5,
            ],
        ];

        $index = 0;
        foreach ($pesananSelesai->take(count($testimoni)) as $pesanan) {
            if ($index < count($testimoni)) {
                Testimoni::create([
                    'id_pengguna' => $pesanan->id_pengguna,
                    'komentar' => $testimoni[$index]['komentar'],
                    'rating' => $testimoni[$index]['rating'],
                    'tgl_dibuat' => $pesanan->tgl_pesanan->addDays(rand(1, 7)),
                ]);
                $index++;
            }
        }
    }
}
