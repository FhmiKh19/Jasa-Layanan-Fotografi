<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'fotografer_id',
        'tanggal',
        'judul',
        'ringkasan',
        'foto_kegiatan',
    ];

    // Relasi ke tabel pengguna
    public function fotografer()
    {
        return $this->belongsTo(Pengguna::class, 'fotografer_id', 'id_pengguna');
    }
}
