<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    const TYPE_NEWS = 'news';
    const TYPE_ANNOUNCEMENT = 'announcement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'type',
        'content',
        'image',
        'published_at',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the user that created the news.
     */
    public function creator()
    {
        return $this->belongsTo(LocalUser::class, 'created_by');
    }
}