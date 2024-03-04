<?php

namespace App\Imports;

use App\Models\Mangsa;
use App\Models\RefDaerah;
use App\Models\RefDun;
use App\Models\RefNegeri;
use App\Models\RefParlimen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MangsaImport extends ToCollectionImport implements SkipsOnError,
SkipsOnFailure,
SkipsEmptyRows,
WithStartRow,
WithChunkReading,
ShouldQueue,
WithValidation,
WithBatchInserts,
WithMultipleSheets,
WithHeadingRow
{
    use Importable, SkipsErrors, SkipsFailures;

    private $user = null;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function startRow(): int {
        return 2;
    }

    public function chunkSize(): int {
        return 100;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }

    public function processImport(Collection $rows){
        foreach ($rows as $row){
            $mangsa = Mangsa::where('no_kp', $row['no_kp'])->first();
            $daerah = RefDaerah::where('nama_daerah', 'ILIKE', $row['daerah'])->first();
            $negeri = RefNegeri::where('nama_negeri', 'ILIKE', $row['negeri'])->first();
            $dun = $row['dun'] != null ? RefDun::where('nama_dun', 'ILIKE', $row['dun'])->first(): null;
            $parlimen = $row['parlimen'] != null ? RefParlimen::where('nama_parlimen', 'ILIKE', $row['parlimen'])->first() : null;

            if(!$mangsa){
                $mangsa = $this->createMangsa($row, $daerah, $negeri, $dun, $parlimen);
            }
        }
    }

    function createMangsa($row, $daerah, $negeri, $dun, $parlimen){
        $mangsa = Mangsa::create([
            'no_kp' => $row['no_kp'],
            'nama' => $row['nama'],
            'telefon' => $row['no_telefon'],
            'alamat_1' => $row['alamat_1'],
            'alamat_2' => $row['alamat_2'],
            'poskod' => $row['poskod'],
            'id_daerah' => $daerah->id,
            'id_negeri' => $negeri->id,
            'id_dun' => $dun ? $dun->id : null,
            'id_parlimen' => $parlimen ? $parlimen->id : null,
            'catatan' => $row['catatan'],
            'status_mangsa' => 2,
            'status_verifikasi' => $row['verifikasi'] == 'Ya' ? true: false,
            'tarikh_cipta' => Carbon::now(),
            'id_pengguna_cipta' => $this->user->id,
            'id_agensi' => $this->user->id_agensi
        ]);

        return $mangsa;
    }

    function updateMangsa($row, $mangsa, $daerah, $negeri, $dun, $parlimen){
        $mangsa->telefon = $row['no_telefon'];
        $mangsa->alamat_1 = $row['alamat_1'];
        $mangsa->alamat_2 = $row['alamat_2'];
        $mangsa->poskod = $row['poskod'];
        $mangsa->id_daerah = $daerah->id;
        $mangsa->id_negeri = $negeri->id;
        $mangsa->id_dun = $dun ? $dun->id : null;
        $mangsa->id_parlimen = $parlimen ? $parlimen->id : null;
        $mangsa->catatan = $row['catatan'];
        $mangsa->status_verifikasi = $row['verifikasi'] == 'Ya' ? true: false;
        $mangsa->tarikh_kemaskini = Carbon::now();
        $mangsa->id_pengguna_kemaskini = $this->user->id;
        $mangsa->save();
    }

    public function user(){
        return $this->user;
    }

    public function rules(): array {
        return [
            '*.no_kp' => [
                'required',
                'string',
                'max:12',
                function ($attribute, $value, $fail) {
                    $mangsa = DB::table('tbl_mangsa')->where('no_kp', 'ILIKE', $value)->first();
                    if($mangsa){
                        $fail('No. Kad Pengenalan mangsa '.$value.' telah didaftarkan. Sila kemaskini maklumat di sistem');
                    }
                }
            ],
            '*.nama' => 'required|string|max:255',
            '*.no_telefon' => 'required|numeric',
            '*.catatan' => '',
            '*.alamat_1' => 'required|string|max:255',
            '*.alamat_2' => '',
            '*.poskod' => 'required|string|max:5',
            '*.daerah' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    $daerah = DB::table('ref_daerah')->where('nama_daerah', 'ILIKE', $value)->where('status_daerah', 1)->first();
                    if(!$daerah){
                        $fail('Tiada daerah '.$value.' dalam jadual rujukan daerah');
                    }
                }
            ],
            '*.negeri' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    $negeri = DB::table('ref_negeri')->where('nama_negeri', 'ILIKE', $value)->where('status_negeri', 1)->first();
                    if(!$negeri){
                        $fail('Tiada negeri '.$value.' dalam jadual rujukan negeri');
                    }
                }
            ],
            '*.dun' => [
                function ($attribute, $value, $fail) {
                    if($value !== null || $value !== ''){
                        $dun = DB::table('ref_dun')->where('nama_dun', 'ILIKE', $value)->where('status_dun', 1)->first();
                        if(!$dun){
                            $fail('Tiada dun '.$value.' dalam jadual rujukan dun');
                        }
                    }
                }
            ],
            '*.parlimen' => [
                function ($attribute, $value, $fail) {
                    if($value !== null || $value !== ''){
                        $parlimen = DB::table('ref_parlimen')->where('nama_parlimen', 'ILIKE', $value)->where('status_parlimen', 1)->first();
                        if(!$parlimen){
                            $fail('Tiada parlimen '.$value.' dalam jadual rujukan parlimen');
                        }
                    }
                }
            ],
            '*.verifikasi' => ['required', Rule::in(['Ya','Tidak'])]
        ];
    }

    public function validationMessages(): array {
        return [
            '*.no_kp.required' => 'No. kad pengenalan wajib diisi.',
            '*.no_kp.max' => 'No. kad pengenalan melebihi aksara dibenarkan (12).',
            '*.nama.required' => 'Nama wajib diisi.',
            '*.nama.max' => 'Nama melebihi aksara dibenarkan (255).',
            '*.no_telefon.required' => 'No. telefon wajib diisi.',
            '*.no_telefon.numeric' => 'No. telefon hanya digit sahaja dibenarkan.',
            '*.alamat_1.required' => 'Alamat 1 wajib diisi',
            '*.alamat_1.max' => 'Alamat 1 melebihi aksara dibenarkan (255)',
            '*.poskod.required' => 'Poskod wajib diisi',
            '*.poskod.max' => 'Poskod melebihi aksara dibenarkan (5)',
            '*.daerah.required' => 'Daerah wajib diisi',
            '*.daerah.max' => 'Daerah melebihi aksara dibenarkan (255)',
            '*.negeri.required' => 'Negeri wajib diisi',
            '*.negeri.max' => 'Negeri melebihi aksara dibenarkan (255)',
            '*.verifikasi.required' => 'Status verifikasi wajib diisi',
            '*.verifikasi.in' => 'Status verifikasi sama ada Ya atau Tidak'
        ];
    }
}
