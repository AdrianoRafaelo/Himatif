<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bph extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'period',
    ];

    public function user()
    {
        return $this->belongsTo(LocalUser::class, 'user_id');
    }
}