<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioGambar extends Model
{
    use HasFactory;

    protected $table = 'portofolio_gambars';
    protected $primaryKey = 'id_gambar';

    protected $fillable = [
        'portofolio_id',
        'file_gambar',
        'caption',
        'urutan',
        'is_cover',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    // Relasi ke portofolio
    public function portofolio()
    {
        return $this->belongsTo(Portofolio::class, 'portofolio_id', 'id_portofolio');
    }

    // Get full URL gambar
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_gambar);
    }
}
