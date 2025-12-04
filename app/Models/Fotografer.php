<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Fotografer extends Authenticatable
{
    protected $fillable = ['nama', 'email', 'password'];
}
