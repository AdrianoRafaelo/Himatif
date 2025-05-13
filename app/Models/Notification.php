<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications'; // Nama tabel sesuai
    protected $fillable = ['nim', 'message', 'is_read', 'created_by']; // Tambahkan created_by

    // Relasi ke model LocalUser
    public function creator()
    {
        return $this->belongsTo(LocalUser::class, 'created_by');
    }
}