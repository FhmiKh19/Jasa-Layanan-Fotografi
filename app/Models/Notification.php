<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'id_pengguna',
        'tipe',
        'judul',
        'pesan',
        'link',
        'dibaca',
        'tgl_dibuat'
    ];

    protected $casts = [
        'dibaca' => 'boolean',
        'tgl_dibuat' => 'datetime'
    ];

    // 🔥 RELATIONSHIP: Notification belongs to User
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}
