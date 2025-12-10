<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';


    protected $fillable = [
        'nama_pengguna',
        'username',
        'email',
        'password',
        'role',
        'status_akun',
        'no_hp',
        'foto_profil',
        'tgl_dibuat'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'tgl_dibuat' => 'datetime', 
        ];
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pengguna');
    }

    public function testimoni()
    {
        return $this->hasMany(Testimoni::class, 'id_pengguna');
    }

    // 🔥 OPTIONAL: HELPER METHODS
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFotografer()
    {
        return $this->role === 'fotografer';
    }

    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }

    public function isAktif()
    {
        return $this->status_akun === 'aktif';
    }

    // Accessor for name (alias for nama_pengguna)
    public function getNameAttribute()
    {
        return $this->nama_pengguna;
    }

    // Accessor for id (alias for id_pengguna)
    public function getIdAttribute()
    {
        return $this->id_pengguna;
    }
}
