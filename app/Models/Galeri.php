<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'gambar', 'created_by'];

    // Relasi ke model LocalUser
    public function user()
    {
        return $this->belongsTo(LocalUser::class, 'created_by');
    }
}
