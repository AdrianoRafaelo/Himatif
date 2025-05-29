<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalUser extends Model
{
    use HasFactory; // Untuk factory dan seeding

    protected $table = 'local_users';

    protected $fillable = [
        'username',
        'nama',
        'nim',
        'angkatan',
        'prodi',
        'email',
        'role',
        'password', // tambahkan ini
    ];

    protected $hidden = [
        'password',
    ];

    // Opsional: Jika Anda ingin relasi terbalik dengan news
    public function news()
    {
        return $this->hasMany(News::class, 'created_by');
    }

    // Opsional: Jika Anda ingin autentikasi kustom
    public function getAuthIdentifierName()
    {
        return 'username'; // Gunakan username sebagai identifier
    }
}
