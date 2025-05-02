<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'proker_id',
        'proposal_id',
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'status',
        'notes',
        'banner_path'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    // Relasi ke proker
    public function proker()
    {
        return $this->belongsTo(Proker::class);
    }

    // Relasi ke proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    // Accessor untuk URL banner
    public function getBannerUrlAttribute()
    {
        return $this->banner_path ? Storage::url($this->banner_path) : null;
    }
}