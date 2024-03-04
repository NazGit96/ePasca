<?php

namespace App\Http\Excels\Laporan;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SenaraiBwiByNegeriExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return (new LaporanController)->senaraiLaporanBwiByNegeriExcelQuery($this->input);
    }

    public function headings(): array
    {
        return [
            'Negeri', 'Bil. Kir', 'Jumlah(RM)', 'Jumlah Dipulangkan(RM)', 'Jumlah Diagihkan(RM)'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}