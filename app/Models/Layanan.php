<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'gambar',
        'status',
        'tgl_dibuat'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'tgl_dibuat' => 'datetime'
    ];

    // 🔥 RELATIONSHIP: Satu layanan punya banyak pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_layanan');
    }
}
