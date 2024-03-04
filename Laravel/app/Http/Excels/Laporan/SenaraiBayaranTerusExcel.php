<?php

namespace App\Http\Excels\Laporan;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SenaraiBayaranTerusExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return (new LaporanController)->senaraiBayaranTerusExcelQuery($this->input);
    }

    public function headings(): array
    {
        return [
            'No. Rujukan Bayaran', 'No. Kelulusan', 'No. Baucer', 'Nama Tabung', 'Tarikh Bayaran', 'Perihal', 'Negeri',
            'Agensi', 'Kementerian', 'Penerima', 'Kategori Bayaran', 'Belanja(RM)'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
