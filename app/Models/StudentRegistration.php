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
        'hadir',
        'tidak_hadir',
        'nim',
        'angkatan',
        'prodi'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
