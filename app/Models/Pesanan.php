<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Layanan;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_pengguna',
        'id_layanan',
        'metode_pembayaran',
        'bukti_pembayaran',
        'tgl_pesanan',
        'status',
        'alamat',
        'tgl_acara',
        'jam',
        'fotografer_id'
    ];

    // Relasi ke user (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

    // Relasi ke fotografer
    public function fotografer()
    {
        return $this->belongsTo(User::class, 'fotografer_id', 'id');
    }

    // Relasi ke layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }
}
