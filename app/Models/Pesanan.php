<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_pengguna',
        'id_layanan',
        'metode_pembayaran',
        'bukti_pembayaran',
        'tgl_pesanan',
        'status',
        'alamat',
        'tgl_acara'
    ];

    protected $casts = [
        'tgl_pesanan' => 'datetime',
        'tgl_acara' => 'date'
    ];

    // 🔥 RELATIONSHIP: Pesanan belongs to User (pengguna)
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    // 🔥 RELATIONSHIP: Pesanan belongs to Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}
