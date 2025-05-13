<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'student_name',
        'username',
        'email',
        'attendance_status',
        'nim',
        'angkatan',
        'prodi'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}