<?php

namespace App\Http\Excels\Laporan;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SenaraiLaporanBwiExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return (new LaporanController)->senaraiLaporanBwiExcelQuery($this->input);
    }

    public function headings(): array
    {
        return [
            'No. Rujukan Bwi', 'Negeri', 'Daerah', 'Jenis Bencana', 'WI/KIR', 'Bil. Kir', 'Jumlah(RM)', 'Memo Perakuan KP', 'Tarikh Perakuan KP', 'Memo Penyaluran KPD BKP',
            'Tarikh Penyaluran KPD BKP', 'Tarikh Majlis', 'Surat Makluman Tarikh Majlis', 'Tarikh Surat Makluman Tarikh Majlis', 'Tarikh EFT/Pengeluaran', 'Due Report(21hr)',
            'Baki Dipulangkan', 'Surat Laporan Majlis DRP APM', 'Tarikh Surat Laporan Malis DRP APM', 'Memo Laporan KPD BKP', 'Tarikh Laporan KPD BKP', 'Catatan'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
