<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalFotografer extends Model
{
    protected $table = 'jadwal_fotografer';
    protected $primaryKey = 'id_jadwal';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pengguna',
        'status',
        'waktu_mulai',
        'waktu_selesai',
        'nama_klien',
        'id_layanan',
        'alamat',
        'tgl_acara',
        'catatan'
    ];

    // Relasi ke Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }
}
