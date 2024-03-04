<?php

namespace App\Http\Excels\Errors;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MangsaExportFailureExcel implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return $this->input;
    }

    public function headings(): array
    {
        return [
            'Row', 'Column', 'Error'
        ];
    }
}
