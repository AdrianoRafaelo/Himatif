<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CampusStudent extends Model
{
    use HasFactory;

    protected $table = 'campus_students';

    protected $fillable = [
        'dim_id',
        'user_id',
        'user_name',
        'nim',
        'nama',
        'email',
        'prodi_id',
        'prodi_name',
        'fakultas',
        'angkatan',
        'status',
        'asrama',
    ];

    /**
     * Mengambil semua mahasiswa dari database.
     *
     * @param string|null $batch
     * @return \Illuminate\Support\Collection
     */
    public static function getAllStudents($batch = null)
    {
        $query = DB::table('campus_students')->orderBy('angkatan')->orderBy('nama');
        
        if ($batch !== null && $batch !== 'all') {
            $query->where('angkatan', $batch);
        }
        
        return $query->get();
    }

    /**
     * Mengambil daftar angkatan yang unik.
     *
     * @return array
     */
    public static function getDistinctBatches()
    {
        try {
            $batches = DB::table('campus_students')->distinct()->pluck('angkatan')->toArray();
            sort($batches);
            return $batches;
        } catch (\Exception $e) {
            return [];
        }
    }
}
