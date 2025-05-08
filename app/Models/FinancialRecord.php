<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'keterangan', 'jenis', 'jumlah'];

    public function details()
    {
        return $this->hasMany(Detail::class, 'financial_id');
    }
}



