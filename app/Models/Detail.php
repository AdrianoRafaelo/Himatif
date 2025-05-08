<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = ['financial_id', 'keterangan', 'jumlah'];

    public function financialRecord()
    {
        return $this->belongsTo(FinancialRecord::class, 'financial_id');
    }
}
