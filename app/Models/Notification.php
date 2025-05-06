<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications'; // Pastikan nama tabel sesuai
    protected $fillable = ['nim', 'message', 'date', 'is_read']; // Sesuaikan dengan kolom yang ada
}