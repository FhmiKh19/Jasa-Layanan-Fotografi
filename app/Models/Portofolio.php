<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolios';
    protected $primaryKey = 'id_portofolio';

    protected $fillable = [
        'fotografer_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'tanggal_foto',
        'lokasi',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'tanggal_foto' => 'date',
    ];

    // Relasi ke user (fotografer)
    public function fotografer()
    {
        return $this->belongsTo(User::class, 'fotografer_id');
    }

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriPortofolio::class, 'kategori_id', 'id_kategori');
    }

    // Relasi ke gambar (multiple)
    public function gambars()
    {
        return $this->hasMany(PortofolioGambar::class, 'portofolio_id', 'id_portofolio')->orderBy('urutan');
    }

    // Get cover image
    public function getCoverAttribute()
    {
        $cover = $this->gambars()->where('is_cover', true)->first();
        if (!$cover) {
            $cover = $this->gambars()->first();
        }
        return $cover;
    }

    // Get jumlah gambar
    public function getJumlahGambarAttribute()
    {
        return $this->gambars()->count();
    }

    // Scope untuk portofolio featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
