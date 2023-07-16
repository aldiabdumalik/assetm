<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestingsExport implements FromCollection, WithHeadings
{
    use Exportable;
    protected $result;

    function __construct($result) 
    {
        $this->result = $result;
    }
    
    public function collection()
    {
        return $this->result;
    }

    public function headings(): array
    {
        return [
            'BARCODE',
            'MAC',
            'JENIS',
            'MERK',
            'TIPE',
            'STATUS',
            'SCAN TIME',
            'SCAN BY',
            'ID IGI',
        ];
    }
}
