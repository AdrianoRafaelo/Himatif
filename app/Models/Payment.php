<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'nama', 'angkatan', 'prodi', 'bulan', 'tahun', 'tanggal_bayar',
    ];
}