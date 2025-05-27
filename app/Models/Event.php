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
        'banner_path',
        'angkatan_akses',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function proker()
    {
        return $this->belongsTo(Proker::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
