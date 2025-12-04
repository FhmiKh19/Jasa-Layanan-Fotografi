<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id_chat';
    public $timestamps = false;

    protected $fillable = [
        'id_pengirim',
        'id_penerima',
        'pesan',
        'tgl_dikirim',
        'is_read'
    ];

    protected $casts = [
        'tgl_dikirim' => 'datetime',
        'is_read' => 'boolean',
    ];

    /**
     * Relasi ke user pengirim
     */
    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengirim', 'id');
    }

    /**
     * Relasi ke user penerima
     */
    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penerima', 'id');
    }

    /**
     * Scope untuk mendapatkan pesan antara dua user
     */
    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function($q) use ($userId1, $userId2) {
            $q->where('id_pengirim', $userId1)
              ->where('id_penerima', $userId2);
        })->orWhere(function($q) use ($userId1, $userId2) {
            $q->where('id_pengirim', $userId2)
              ->where('id_penerima', $userId1);
        });
    }

    /**
     * Scope untuk mendapatkan pesan terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('tgl_dikirim', 'desc');
    }
}
