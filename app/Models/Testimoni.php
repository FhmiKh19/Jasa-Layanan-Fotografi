<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimoni';
    protected $primaryKey = 'id_testimoni';

    protected $fillable = [
        'id_pengguna',
        'komentar',
        'rating',
        'tgl_dibuat'
    ];

    protected $casts = [
        'rating' => 'integer',
        'tgl_dibuat' => 'datetime'
    ];

    // 🔥 RELATIONSHIP: Testimoni belongs to User
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}
