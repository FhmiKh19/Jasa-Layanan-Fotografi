<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;

    protected $fillable = [
        'nama_pengguna',
        'username',
        'password',
        'role',
        'status_akun',
        'no_hp'
    ];
}
