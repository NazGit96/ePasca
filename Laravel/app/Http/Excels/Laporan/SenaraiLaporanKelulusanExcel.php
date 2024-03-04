<?php

namespace App\Http\Excels\Laporan;

use App\Http\Controllers\LaporanController;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SenaraiLaporanKelulusanExcel implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public $input;
    function __construct($input)
    {
        $this->input = $input;
    }

    use Exportable;

    public function collection()
    {

        return (new LaporanController)->senaraiLaporanKelulusanExcelQuery($this->input);
    }

    public function headings(): array
    {
        return [
            'No. Rujukan Kelulusan', 'Tarikh Surat', 'Perihal Surat', 'Tarikh Mula Kelulusan', 'Tarikh Tamat Kelulusan', 'Siling Peruntukan', 'Peruntukan Diambil', 'Baki Siling Peruntukan', 'Rujukan',
            'Bayaran Terus Covid (Tahun Semasa)', 'Bayaran Terus Bukan Covid (Tahun Semasa)', 'Bayaran Skb Covid (Tahun Semasa)', 'Bayaran Skb Bukan Covid (Tahun Semasa)',
            'Belanja Covid (Tahun Semasa)', 'Belanja Bukan Covid (Tahun Semasa)', 'Belanja Covid (Tahun Sebelum)', 'Belanja Bukan Covid (Tahun Sebelum)', 'Jumlah Belanja'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }
}
