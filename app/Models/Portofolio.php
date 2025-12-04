<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'tgl_dibuat'
    ];

    protected $casts = [
        'tgl_dibuat' => 'datetime'
    ];
}
