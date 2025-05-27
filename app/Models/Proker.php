<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proker extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'objective',
        'location',
        'planned_date',
        'actual_date',
        'funding_source',
        'planned_budget',
        'actual_budget',
        'status',
        'period',
        'created_by',
        'report_file', // Tambahkan kolom baru
        'approval_status',
        'approved_by',
    ];

    public function creator()
    {
        return $this->belongsTo(LocalUser::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(LocalUser::class, 'approved_by');
    }
}