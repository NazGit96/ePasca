<?php

namespace App\Http\Excels\Laporan;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SenaraiMangsaTiadaBantuanExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return (new LaporanController)->senaraiMangsaBelumTerimaBantuanExcelQuery($this->input);
    }

    public function headings(): array
    {
        return [
            'Nama Mangsa (KIR)',
            'Kad Pengenalan',
            'Alamat 1',
            'Alamat 2'.
            'Daerah',
            'Negeri'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
