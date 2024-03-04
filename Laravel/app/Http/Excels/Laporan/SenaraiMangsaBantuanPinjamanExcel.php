<?php

namespace App\Http\Excels\Laporan;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SenaraiMangsaBantuanPinjamanExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return (new LaporanController)->senaraiMangsaBantuanPinjamanExcelQuery($this->input);
    }

    public function headings(): array
    {
        return [
            'Nama', 'No Kad Pengenalan', 'Alamat 1', 'Alamat 2', 'Nama Daerah', 'Nama Negeri',
            'Nama Agensi', 'Sektor', 'Tarikh Mula', 'Tempoh Pinjaman', 'Jumlah Pinjaman'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
