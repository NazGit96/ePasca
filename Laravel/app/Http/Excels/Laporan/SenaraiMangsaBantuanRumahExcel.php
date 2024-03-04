<?php

namespace App\Http\Excels\Laporan;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SenaraiMangsaBantuanRumahExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return (new LaporanController)->senaraiMangsaBantuanRumahExcelQuery($this->input);
    }

    public function headings(): array
    {
        return [
            'Nama', 'No Kad Pengenalan', 'Alamat 1', 'Alamat 2', 'Nama Daerah', 'Nama Negeri',
            'Nama Pemilik', 'Nama Sumber Dana', 'Nama Pelaksana', 'Tarikh Mula', 'Tarikh Siap',
            'Peratus Kemajuan', 'Status Kemajuan', 'Kos Anggaran', 'Kos Sebenar'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'N' => NumberFormat::FORMAT_NUMBER_00,
            'O' => NumberFormat::FORMAT_NUMBER_00
        ];
    }
}
