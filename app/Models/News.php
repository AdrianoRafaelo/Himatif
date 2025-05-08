<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'image',
    ];  


    public function creator()
{
    return $this->belongsTo(LocalUser::class, 'created_by');
}
}
