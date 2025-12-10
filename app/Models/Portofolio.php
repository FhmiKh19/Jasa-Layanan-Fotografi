<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolio';
    protected $primaryKey = 'id_portofolio';

    protected $fillable = [
        'judul',
        'kategori',
        'gambar',
        'deskripsi',
        'tgl_dibuat',
        'id_fotografer'
    ];

    protected $casts = [
        'tgl_dibuat' => 'datetime'
    ];

    public function fotografer()
    {
        return $this->belongsTo(User::class, 'id_fotografer', 'id_pengguna');
    }
}
