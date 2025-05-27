<?php
namespace App\Exports;

use App\Models\FinancialRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinancialRecordsExport implements FromCollection, WithHeadings
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = FinancialRecord::query();

        if ($this->bulan) {
            $query->whereMonth('tanggal', $this->bulan);
        }
        if ($this->tahun) {
            $query->whereYear('tanggal', $this->tahun);
        }

        return $query->select('tanggal', 'keterangan', 'jenis', 'jumlah')->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Keterangan', 'Jenis', 'Jumlah'];
    }
}