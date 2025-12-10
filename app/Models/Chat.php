<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';
    protected $primaryKey = 'id_chat';

    protected $fillable = [
        'id_pesanan',
        'id_pengirim',
        'id_penerima',
        'pesan',
        'dibaca',
        'tgl_kirim'
    ];

    protected $casts = [
        'dibaca' => 'boolean',
        'tgl_kirim' => 'datetime'
    ];

    // 🔥 RELATIONSHIP: Chat belongs to Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // 🔥 RELATIONSHIP: Chat belongs to Pengirim (User)
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_pengirim');
    }

    // 🔥 RELATIONSHIP: Chat belongs to Penerima (User)
    public function penerima()
    {
        return $this->belongsTo(User::class, 'id_penerima');
    }
}
