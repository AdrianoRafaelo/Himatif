<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'proker_id',
        'title',
        'description',
        'file_path',
        'status',
        'sent_at',
        'reviewed_at',
    ];

    public function proker()
    {
        return $this->belongsTo(Proker::class);
    }
}
