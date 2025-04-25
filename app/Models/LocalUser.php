<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalUser extends Model
{
    protected $table = 'local_users';

    protected $fillable = [
        'username',
        'nama',
        'nim',
        'angkatan',
        'prodi',
        'role',
        'password',      
    ];

    protected $hidden = [
        'password',
    ];
}
