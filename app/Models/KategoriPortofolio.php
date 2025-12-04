<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriPortofolio extends Model
{
    use HasFactory;

    protected $table = 'kategori_portofolios';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'fotografer_id',
        'nama_kategori',
        'slug',
        'deskripsi',
        'cover_image',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama_kategori);
            }
        });
        
        static::updating(function ($kategori) {
            if ($kategori->isDirty('nama_kategori')) {
                $kategori->slug = Str::slug($kategori->nama_kategori);
            }
        });
    }

    // Relasi ke user (fotografer)
    public function fotografer()
    {
        return $this->belongsTo(User::class, 'fotografer_id');
    }

    // Relasi ke portofolio
    public function portofolios()
    {
        return $this->hasMany(Portofolio::class, 'kategori_id', 'id_kategori');
    }

    // Scope aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Hitung jumlah portofolio
    public function getJumlahPortofolioAttribute()
    {
        return $this->portofolios()->count();
    }

    // Hitung jumlah gambar
    public function getJumlahGambarAttribute()
    {
        return PortofolioGambar::whereIn('portofolio_id', $this->portofolios()->pluck('id_portofolio'))->count();
    }
}
