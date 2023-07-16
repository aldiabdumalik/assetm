<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeliveriesExport implements FromCollection, WithHeadings
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
            'NO. PENGIRIMAN',
            'NO. RESI',
            'JML. ITEM',
            'STATUS',
            'ESTIMASI',
            'SCAN TIME',
            'SCAN BY',
        ];
    }
}
