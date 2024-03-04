<?php

namespace App\Http\Controllers;

use App\Http\Excels\Laporan\SenaraiBayaranTerusExcel;
use App\Http\Excels\Laporan\SenaraiBwiBencanaKirExcel;
use App\Http\Excels\Laporan\SenaraiBwiByNegeriExcel;
use App\Http\Excels\Laporan\SenaraiBwiKematianExcel;
use App\Http\Excels\Laporan\SenaraiLaporanBwiExcel;
use App\Http\Excels\Laporan\SenaraiLaporanKelulusanExcel;
use App\Http\Excels\Laporan\SenaraiLaporanSkbExcel;
use App\Http\Excels\Laporan\SenaraiLaporanWaranExcel;
use App\Http\Excels\Laporan\SenaraiMangsaExcel;
use App\Http\Excels\Laporan\SenaraiMangsaTiadaBantuanExcel;
use App\Http\Excels\Laporan\SenaraiMangsaBantuanLainExcel;
use App\Http\Excels\Laporan\SenaraiMangsaBantuanAntarabangsaExcel;
use App\Http\Excels\Laporan\SenaraiMangsaBantuanPinjamanExcel;
use App\Http\Excels\Laporan\senaraiMangsaBantuanPertanianExcel;
use App\Http\Excels\Laporan\senaraiMangsaBantuanRumahExcel;
use App\Http\Excels\Laporan\SenaraiMangsaBantuanWangIhsanExcel;
use App\Models\RefNegeri;
use App\Models\RefSumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class LaporanController extends Controller
{

    public function getAllMangsa(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa.id asc';
        $filter = $request->filter;
        $filterAgensi = $request->filterAgensi;
        $filterKementerian = $request->filterKementerian;
        $filterNegeri = $request->filterNegeri;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_mangsa.id', 'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_negeri', 'nama_agensi', 'nama_kementerian', 'tarikh_cipta'
        ];

        $data = DB::table('tbl_mangsa')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa.id_agensi', 'ref_agensi.id')
            ->join('ref_kementerian', 'ref_agensi.id_kementerian', 'ref_kementerian.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterAgensi) {
                $query->when($filterAgensi, function ($query, $filterAgensi) {
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function ($query) use ($filterKementerian) {
                $query->when($filterKementerian, function ($query, $filterKementerian) {
                    return $query->where('id_kementerian', $filterKementerian);
                });
            })
            ->where(function($query) use ($filterNegeri){
                $query->when($filterNegeri, function($query, $filterNegeri){
                    return $query->where('id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function getKosBantuanByJenisBantuan(Request $request)
    {

        $kos_bantuan_antarabangsa = DB::table('tbl_mangsa_antarabangsa')
            ->select(DB::raw('sum(kos_bantuan) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $kos_bantuan_lain = DB::table('tbl_mangsa_bantuan')
            ->select(DB::raw('sum(kos_bantuan) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $kos_bantuan_pertanian = DB::table('tbl_mangsa_pertanian')
            ->select(DB::raw('sum(kos_bantuan) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $kos_bantuan_pinjaman = DB::table('tbl_mangsa_pinjaman')
            ->select(DB::raw('sum(jumlah_pinjaman) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $kos_bantuan_wang_ihsan = DB::table('tbl_mangsa_wang_ihsan')
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $kos_bantuan_bina_rumah = DB::table('tbl_mangsa_rumah')
            ->where('id_jenis_bantuan', 2)
            ->select(DB::raw('sum(kos_sebenar) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $kos_bantuan_baik_pulih = DB::table('tbl_mangsa_rumah')
            ->where('id_jenis_bantuan', 3)
            ->select(DB::raw('sum(kos_sebenar) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $data = array();
        $result = array();
        $item = array();

        $result = array("kategori" => "Bantuan Antarabangsa", "jumlah" => $kos_bantuan_antarabangsa);
        $data[] = $result;

        $result = array("kategori" => "Bantuan lain", "jumlah" => $kos_bantuan_lain);
        $data[] = $result;

        $result = array("kategori" => "Bantuan Pertanian", "jumlah" => $kos_bantuan_pertanian);
        $data[] = $result;

        $result = array("kategori" => "Pinjaman Khas", "jumlah" => $kos_bantuan_pinjaman);
        $data[] = $result;

        $result = array("kategori" => "Wang Ihsan", "jumlah" => $kos_bantuan_wang_ihsan);
        $data[] = $result;

        $result = array("kategori" => "Bina Rumah", "jumlah" => $kos_bantuan_bina_rumah);
        $data[] = $result;

        $result = array("kategori" => "Baik Pulih", "jumlah" => $kos_bantuan_baik_pulih);
        $data[] = $result;

        $item['bantuan'] = $data;

        return response()->json([
            'bantuan' => $data
        ], 200);
    }

    public function getSumberDanaRumah(Request $request)
    {
        $id_jenis_bantuan = $request->id_jenis_bantuan ?? 2;

        $bantuan_rumah = DB::table('ref_sumber_dana')
            ->leftJoin('tbl_mangsa_rumah', 'ref_sumber_dana.id', '=', 'tbl_mangsa_rumah.id_sumber_dana')
            ->where('tbl_mangsa_rumah.id_jenis_bantuan', $id_jenis_bantuan)
            ->select('nama_sumber_dana', 'ref_sumber_dana.id as id_sumber_dana', DB::raw('count(distinct tbl_mangsa_rumah.id_mangsa) as jumlah'))
            ->groupBy('nama_sumber_dana', 'ref_sumber_dana.id')
            ->orderBy('ref_sumber_dana.id')
            ->get();

        $data = array();
        for ($i = 1; $i <= 5; $i++) {
            $result = array();
            $result['jumlah'] = 0;

            $sumber_dana = RefSumberDana::where('id', $i)->pluck('nama_sumber_dana')->first();
            $result['nama_sumber_dana'] = $sumber_dana;

            $jumlahBantuanRumah = $bantuan_rumah->where('id_sumber_dana', $i)->pluck('jumlah')->first();
            $result['jumlah'] = $jumlahBantuanRumah;

            $data[] = $result;
        }
        $item = array();
        $item['sumber_dana'] = $data;

        return response()->json([
            'sumber_dana' => $data
        ], 200);
    }

    public function exportAllMangsaToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterAgensi = array_key_exists('filterAgensi', $input) ? $input['filterAgensi']  : null;
        $filterKementerian = array_key_exists('filterKementerian', $input) ? $input['filterKementerian']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;

        $columns = [
            'nama', 'no_kp', 'nama_negeri', 'nama_kementerian', 'nama_agensi', 'tarikh_cipta',
        ];

        return DB::table('tbl_mangsa')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa.id_agensi', 'ref_agensi.id')
            ->join('ref_kementerian', 'ref_agensi.id_kementerian', 'ref_kementerian.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterAgensi) {
                $query->when($filterAgensi, function ($query, $filterAgensi) {
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function ($query) use ($filterKementerian) {
                $query->when($filterKementerian, function ($query, $filterKementerian) {
                    return $query->where('id_kementerian', $filterKementerian);
                });
            })
            ->where(function($query) use ($filterNegeri){
                $query->when($filterNegeri, function($query, $filterNegeri){
                    return $query->where('id_negeri', $filterNegeri);
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa.id')
            ->get();
    }

    public function getAllMangsaBelumTerimaBantuan(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa.id asc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;

        $columns = [
            'tbl_mangsa.id', 'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_negeri', 'nama_daerah'
        ];

        $data = DB::table('tbl_mangsa')
            ->join('tbl_mangsa_wang_ihsan', 'tbl_mangsa.id', 'tbl_mangsa_wang_ihsan.id_mangsa')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->where('status_mangsa_wang_ihsan', 1)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function exportAllMangsaBelumTerimaBantuanToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa_Belum_Terima_Bantuan' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaTiadaBantuanExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaBelumTerimaBantuanExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;

        $columns = [
            'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri'
        ];

        return DB::table('tbl_mangsa')
            ->join('tbl_mangsa_wang_ihsan', 'tbl_mangsa.id', 'tbl_mangsa_wang_ihsan.id_mangsa')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->where('status_mangsa_wang_ihsan', 1)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa.id')
            ->get();
    }

    public function getAllMangsaBantuanLain(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa_bantuan.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_mangsa_bantuan.id', 'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_bantuan', 'nama_agensi', 'nama_sumber_dana', 'sumber_dana_lain',
            'tarikh_bantuan', 'kos_bantuan', 'tbl_mangsa_bantuan.catatan', 'tbl_mangsa_bantuan.tarikh_cipta'
        ];

        $data = DB::table('tbl_mangsa_bantuan')
            ->join('tbl_mangsa', 'tbl_mangsa_bantuan.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa_bantuan.id_agensi_bantuan', 'ref_agensi.id')
            ->join('ref_sumber_dana', 'tbl_mangsa_bantuan.id_sumber_dana', 'ref_sumber_dana.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_bantuan.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function exportAllMangsaBantuanLainToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa_Bantuan_Lain' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaBantuanLainExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaBantuanLainExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_bantuan', 'nama_agensi', 'nama_sumber_dana', 'sumber_dana_lain',
            'tarikh_bantuan', 'kos_bantuan', 'tbl_mangsa_bantuan.catatan'
        ];

        return DB::table('tbl_mangsa_bantuan')
            ->join('tbl_mangsa', 'tbl_mangsa_bantuan.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa_bantuan.id_agensi_bantuan', 'ref_agensi.id')
            ->join('ref_sumber_dana', 'tbl_mangsa_bantuan.id_sumber_dana', 'ref_sumber_dana.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_bantuan.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa_bantuan.id')
            ->get();
    }

    public function getAllMangsaBantuanAntarabangsa(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa_antarabangsa.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_mangsa_antarabangsa.id', 'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_bantuan', 'negara', 'tarikh_bantuan', 'kos_bantuan', 'tbl_mangsa_antarabangsa.catatan', 'tarikh_cipta'
        ];

        $data = DB::table('tbl_mangsa_antarabangsa')
            ->join('tbl_mangsa', 'tbl_mangsa_antarabangsa.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_antarabangsa.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function exportAllMangsaBantuanAntarabangsaToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa_Bantuan_Antarabangsa' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaBantuanAntarabangsaExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaBantuanAntarabangsaExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_bantuan', 'negara', 'tarikh_bantuan', 'kos_bantuan', 'tbl_mangsa_antarabangsa.catatan'
        ];

        return DB::table('tbl_mangsa_antarabangsa')
            ->join('tbl_mangsa', 'tbl_mangsa_antarabangsa.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_antarabangsa.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa_antarabangsa.id')
            ->get();
    }

    public function getAllMangsaBantuanPinjaman(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa_pinjaman.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_mangsa_pinjaman.id', 'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_agensi', 'sektor', 'tarikh_mula', 'tempoh_pinjaman', 'jumlah_pinjaman', 'tbl_mangsa_pinjaman.tarikh_cipta'
        ];

        $data = DB::table('tbl_mangsa_pinjaman')
            ->join('tbl_mangsa', 'tbl_mangsa_pinjaman.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa_pinjaman.id_agensi_bantuan', 'ref_agensi.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_pinjaman.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function exportAllMangsaBantuanPinjamanToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa_Bantuan_Pinjaman' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaBantuanPinjamanExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaBantuanPinjamanExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_agensi', 'sektor', 'tarikh_mula', 'tempoh_pinjaman', 'jumlah_pinjaman'
        ];

        return DB::table('tbl_mangsa_pinjaman')
            ->join('tbl_mangsa', 'tbl_mangsa_pinjaman.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa_pinjaman.id_agensi_bantuan', 'ref_agensi.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_pinjaman.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa_pinjaman.id')
            ->get();
    }

    public function getAllMangsaBantuanPertanian(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa_pertanian.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_mangsa_pertanian.id', 'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_agensi', 'nama_jenis_pertanian', 'luas', 'luas_musnah', 'bilangan', 'bilangan_rosak', 'anggaran_nilai_rosak',
            'anggaran_nilai_bantuan', 'tarikh_bantuan', 'kos_bantuan', 'tbl_mangsa_pertanian.catatan', 'tbl_mangsa_pertanian.tarikh_cipta'
        ];

        $data = DB::table('tbl_mangsa_pertanian')
            ->join('tbl_mangsa', 'tbl_mangsa_pertanian.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_jenis_pertanian', 'tbl_mangsa_pertanian.id_jenis_pertanian', 'ref_jenis_pertanian.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa_pertanian.id_agensi_bantuan', 'ref_agensi.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_pertanian.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function exportAllMangsaBantuanPertanianToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa_Bantuan_Pertanian' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaBantuanPertanianExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaBantuanPertanianExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_agensi', 'nama_jenis_pertanian', 'luas', 'luas_musnah', 'bilangan', 'bilangan_rosak', 'anggaran_nilai_rosak',
            'anggaran_nilai_bantuan', 'tarikh_bantuan', 'kos_bantuan', 'tbl_mangsa_pertanian.catatan'
        ];

        return DB::table('tbl_mangsa_pertanian')
            ->join('tbl_mangsa', 'tbl_mangsa_pertanian.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_jenis_pertanian', 'tbl_mangsa_pertanian.id_jenis_pertanian', 'ref_jenis_pertanian.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa_pertanian.id_agensi_bantuan', 'ref_agensi.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_pertanian.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa_pertanian.id')
            ->get();
    }

    public function getAllMangsaBantuanRumah(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa_rumah.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterJenisBantuan = $request->filterJenisBantuan;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_mangsa_rumah.id', 'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_pemilik', 'nama_sumber_dana', 'nama_pelaksana', 'tarikh_mula', 'tarikh_siap','tbl_mangsa_rumah.tarikh_cipta', 'peratus_kemajuan',
            'status_kemajuan', 'kos_anggaran', 'kos_sebenar'
        ];

        $data = DB::table('tbl_mangsa_rumah')
            ->join('tbl_mangsa', 'tbl_mangsa_rumah.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_pemilik', 'tbl_mangsa_rumah.id_pemilik', 'ref_pemilik.id')
            ->join('ref_sumber_dana', 'tbl_mangsa_rumah.id_sumber_dana', 'ref_sumber_dana.id')
            ->join('ref_pelaksana', 'tbl_mangsa_rumah.id_pelaksana', 'ref_pelaksana.id')
            ->join('ref_status_kemajuan', 'tbl_mangsa_rumah.id_status_kemajuan', 'ref_status_kemajuan.id')
            ->join('ref_bantuan', 'tbl_mangsa_rumah.id_jenis_bantuan', 'ref_bantuan.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterJenisBantuan) {
                $query->when($filterJenisBantuan, function ($query, $filterJenisBantuan) {
                    return $query->where('tbl_mangsa_rumah.id_jenis_bantuan', $filterJenisBantuan);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_rumah.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function exportAllMangsaBantuanRumahToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa_Bantuan_Rumah' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaBantuanRumahExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaBantuanRumahExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterJenisBantuan = array_key_exists('filterJenisBantuan', $input) ? $input['filterJenisBantuan']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama', 'no_kp', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'nama_pemilik', 'nama_sumber_dana', 'nama_pelaksana', 'tarikh_mula', 'tarikh_siap', 'peratus_kemajuan',
            'status_kemajuan', 'kos_anggaran', 'kos_sebenar'
        ];

        return DB::table('tbl_mangsa_rumah')
            ->join('tbl_mangsa', 'tbl_mangsa_rumah.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_pemilik', 'tbl_mangsa_rumah.id_pemilik', 'ref_pemilik.id')
            ->join('ref_sumber_dana', 'tbl_mangsa_rumah.id_sumber_dana', 'ref_sumber_dana.id')
            ->join('ref_pelaksana', 'tbl_mangsa_rumah.id_pelaksana', 'ref_pelaksana.id')
            ->join('ref_status_kemajuan', 'tbl_mangsa_rumah.id_status_kemajuan', 'ref_status_kemajuan.id')
            ->join('ref_bantuan', 'tbl_mangsa_rumah.id_jenis_bantuan', 'ref_bantuan.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterJenisBantuan) {
                $query->when($filterJenisBantuan, function ($query, $filterJenisBantuan) {
                    return $query->where('tbl_mangsa_rumah.id_jenis_bantuan', $filterJenisBantuan);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_rumah.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa_rumah.id')
            ->get();
    }

    public function getAllMangsaBantuanWangIhsan(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_mangsa_wang_ihsan.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterBencana = $request->filterBencana;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_mangsa_wang_ihsan.id', 'nama', 'no_kp', 'nama_bencana', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'tarikh_serahan', 'jumlah', 'tarikh_bencana', 'nama_jenis_bwi'
        ];

        $data = DB::table('tbl_mangsa_wang_ihsan')
            ->join('tbl_mangsa', 'tbl_mangsa_wang_ihsan.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_bencana', 'tbl_mangsa_wang_ihsan.id_bencana', 'ref_bencana.id')
            ->join('ref_jenis_bwi', 'tbl_mangsa_wang_ihsan.id_jenis_bwi', 'ref_jenis_bwi.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('tbl_mangsa_wang_ihsan.id_bencana', $filterBencana);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_wang_ihsan.tarikh_serahan)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }

    public function exportAllMangsaBantuanWangIhsanToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Mangsa_Bantuan_Wang_Ihsan' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiMangsaBantuanWangIhsanExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiMangsaBantuanWangIhsanExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterBencana = array_key_exists('filterBencana', $input) ? $input['filterBencana']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama', 'no_kp', 'nama_bencana', 'tarikh_bencana', 'nama_jenis_bwi', 'alamat_1', 'alamat_2', 'nama_daerah', 'nama_negeri',
            'tarikh_serahan', 'jumlah'
        ];

        return DB::table('tbl_mangsa_wang_ihsan')
            ->join('tbl_mangsa', 'tbl_mangsa_wang_ihsan.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_bencana', 'tbl_mangsa_wang_ihsan.id_bencana', 'ref_bencana.id')
            ->join('ref_jenis_bwi', 'tbl_mangsa_wang_ihsan.id_jenis_bwi', 'ref_jenis_bwi.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('tbl_mangsa.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_mangsa.id_daerah', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('tbl_mangsa_wang_ihsan.id_bencana', $filterBencana);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_wang_ihsan.tarikh_cipta)'), '=', $filterYear)                    ;
                });
            })
            ->select($columns)
            ->orderBy('tbl_mangsa_wang_ihsan.id')
            ->get();
    }

    public function getAllLaporanBayaranTerus(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bayaran_terus.id desc';
        $filter = $request->filter;
        $filterKategori = $request->filterKategori;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_tabung_bayaran_terus.no_rujukan_terus', 'no_rujukan_kelulusan', 'no_baucar', 'tarikh', 'perihal', 'penerima',
            'id_kategori_bayaran', 'nama_kategori_bayaran', 'jumlah', 'nama_negeri', 'nama_agensi', 'nama_kementerian', 'nama_tabung'
        ];

        $data = DB::table('tbl_tabung_bayaran_terus')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung', 'tbl_tabung_kelulusan.id_tabung', 'tbl_tabung.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_terus.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->leftJoin('ref_negeri', 'tbl_tabung_bayaran_terus.id_negeri', 'ref_negeri.id')
            ->leftJoin('ref_agensi', 'tbl_tabung_bayaran_terus.id_agensi', 'ref_agensi.id')
            ->leftJoin('ref_kementerian', 'tbl_tabung_bayaran_terus.id_kementerian', 'ref_kementerian.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterKategori) {
                $query->when($filterKategori, function ($query, $filterKategori) {
                    return $query->where('tbl_tabung_bayaran_terus.id_kategori_bayaran', $filterKategori);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh)'), '=', $filterYear);
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $totalBayaranTerus = DB::Table('tbl_tabung_bayaran_terus')
        ->where(function ($query) use ($filterKategori) {
            $query->when($filterKategori, function ($query, $filterKategori) {
                return $query->where('tbl_tabung_bayaran_terus.id_kategori_bayaran', $filterKategori);
            });
        })
        ->where(function ($query) use ($filterYear) {
            $query->when($filterYear, function ($query, $filterYear) {
                return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh)'), '=', $filterYear);
            });
        })
        ->select(DB::raw('sum(jumlah) as jumlah_bayaran_terus'))
        ->first();

        return response()->json([
            'total_count' => $totalCount,
            'jumlah_bayaran_terus' => $totalBayaranTerus->jumlah_bayaran_terus,
            'items' => $result
        ], 200);
    }

    public function exportAllBayaranTerusToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Bayaran_Terus' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiBayaranTerusExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiBayaranTerusExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterKategori = array_key_exists('filterKategori', $input) ? $input['filterKategori']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'no_rujukan_terus', 'tbl_tabung_kelulusan.no_rujukan_kelulusan', 'no_baucar', 'tbl_tabung.nama_tabung', 'tarikh', 'perihal', 'ref_negeri.nama_negeri',
            'ref_agensi.nama_agensi', 'ref_kementerian.nama_kementerian', 'penerima', 'nama_kategori_bayaran', 'jumlah'
        ];

        return DB::table('tbl_tabung_bayaran_terus')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_terus.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->join('tbl_tabung', 'tbl_tabung_kelulusan.id_tabung', 'tbl_tabung.id')
            ->leftJoin('ref_negeri', 'tbl_tabung_bayaran_terus.id_negeri', 'ref_negeri.id')
            ->leftJoin('ref_agensi', 'tbl_tabung_bayaran_terus.id_agensi', 'ref_agensi.id')
            ->leftJoin('ref_kementerian', 'tbl_tabung_bayaran_terus.id_kementerian', 'ref_kementerian.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterKategori) {
                $query->when($filterKategori, function ($query, $filterKategori) {
                    return $query->where('tbl_tabung_bayaran_terus.id_kategori_bayaran', $filterKategori);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh)'), '=', $filterYear);
                });
            })
            ->select($columns)
            ->orderBy('tbl_tabung_bayaran_terus.id')
            ->get();
    }

    public function getAllLaporanBwi(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bwi.id asc';
        $filter = $request->filter;
        $filterBencana = $request->filterBencana;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterYearEft = $request->filterYearEft;
        $filterYearBencana = $request->filterYearBencana;

        $columns = [
            'tbl_tabung_bwi.id', 'no_rujukan_bwi', 'nama_negeri', 'nama_daerah', 'nama_bencana', 'tbl_mangsa_wang_ihsan.jumlah',
            'no_rujukan_akuan_kp', 'tarikh_akuan_kp', 'no_rujukan_saluran_kpd_bkp',
            'tarikh_saluran_kpd_bkp', 'tarikh_majlis_makluman_majlis', 'no_rujukan_makluman_majlis', 'tarikh_makluman_majlis', 'tarikh_eft', 'due_report',
            'no_rujukan_majlis_drp_apm', 'tarikh_majlis_drp_apm', 'no_rujukan_laporan_kpd_bkp', 'tarikh_laporan_kpd_bkp', 'tbl_tabung_bwi_kawasan.catatan'
        ];

        $data = DB::table('tbl_tabung_bwi')
            ->join('tbl_tabung_bwi_kawasan', 'tbl_tabung_bwi.id', 'tbl_tabung_bwi_kawasan.id_tabung_bwi')
            ->join('ref_negeri', 'tbl_tabung_bwi_kawasan.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_tabung_bwi_kawasan.id_daerah', 'ref_daerah.id')
            ->join('ref_bencana', 'tbl_tabung_bwi.id_bencana', 'ref_bencana.id')
            ->leftJoin('tbl_mangsa_wang_ihsan', function ($join) {
                $join->on('tbl_mangsa_wang_ihsan.id_bencana', '=', 'tbl_tabung_bwi.id_bencana');
                $join->on('tbl_mangsa_wang_ihsan.id_jenis_bwi', '=', 'tbl_tabung_bwi.id_jenis_bwi');
                $join->on('tbl_mangsa_wang_ihsan.id_daerah', '=', 'tbl_tabung_bwi_kawasan.id_daerah');
            })
            ->select(  'tbl_tabung_bwi.id', 'no_rujukan_bwi', 'nama_negeri', 'nama_daerah', 'nama_bencana', 'tbl_mangsa_wang_ihsan.jumlah', DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil_kir'),
            DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah_keseluruhan'), 'no_rujukan_akuan_kp', 'tarikh_akuan_kp', 'no_rujukan_saluran_kpd_bkp',
            'tarikh_saluran_kpd_bkp', 'tarikh_majlis_makluman_majlis', 'no_rujukan_makluman_majlis', 'tarikh_makluman_majlis', 'tarikh_eft', 'due_report', DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan'),
            'no_rujukan_majlis_drp_apm', 'tarikh_majlis_drp_apm', 'no_rujukan_laporan_kpd_bkp', 'tarikh_laporan_kpd_bkp', 'tbl_tabung_bwi_kawasan.catatan')
            ->groupBy('tbl_tabung_bwi.id', 'ref_bencana.id', 'ref_negeri.id', 'ref_daerah.id', 'tbl_mangsa_wang_ihsan.jumlah', 'tbl_tabung_bwi_kawasan.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('ref_bencana.id', $filterBencana);
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('ref_negeri.id', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('ref_daerah.id', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYearEft) {
                $query->when($filterYearEft, function ($query, $filterYearEft) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tarikh_eft)'), '=', $filterYearEft);
                });
            })
            ->where(function ($query) use ($filterYearBencana) {
                $query->when($filterYearBencana, function ($query, $filterYearBencana) {
                    return $query->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYearBencana);
                });
            });

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $countData = $result->toArray();
        $totalCount = count($countData);
        $total_kir = 0;
        $total_jumlah = 0;
        $total_dipulangkan = 0;

        foreach($result as $d){
            $total_kir = $total_kir + $d->bil_kir;
            $total_jumlah = $total_jumlah + $d->jumlah_keseluruhan;
            $total_dipulangkan = $total_dipulangkan + $d->jumlah_dipulangkan;
        }

        return response()->json([
            'total_count' => $totalCount,
            'total_kir' => $total_kir,
            'total_jumlah' => $total_jumlah,
            'total_dipulangkan' => $total_dipulangkan,
            'items' => $result,
        ], 200);
    }

    public function exportAllLaporanBwiToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Bwi' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiLaporanBwiExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiLaporanBwiExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterBencana = array_key_exists('filterBencana', $input) ? $input['filterBencana']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterYearEft = array_key_exists('filterYearEft', $input) ? $input['filterYearEft']  : null;
        $filterYearBencana = array_key_exists('filterYearBencana', $input) ? $input['filterYearBencana']  : null;

        $columns = [
            'no_rujukan_bwi', 'nama_negeri', 'nama_daerah', 'nama_bencana', 'tbl_mangsa_wang_ihsan.jumlah', DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil_kir'),
            DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah_keseluruhan'), 'no_rujukan_akuan_kp', 'tarikh_akuan_kp', 'no_rujukan_saluran_kpd_bkp',
            'tarikh_saluran_kpd_bkp', 'tarikh_majlis_makluman_majlis', 'no_rujukan_makluman_majlis', 'tarikh_makluman_majlis', 'tarikh_eft', 'due_report', DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan'),
            'no_rujukan_majlis_drp_apm', 'tarikh_majlis_drp_apm', 'no_rujukan_laporan_kpd_bkp', 'tarikh_laporan_kpd_bkp', 'tbl_tabung_bwi_kawasan.catatan'
        ];

        return DB::table('tbl_tabung_bwi')
            ->join('tbl_tabung_bwi_kawasan', 'tbl_tabung_bwi.id', 'tbl_tabung_bwi_kawasan.id_tabung_bwi')
            ->join('ref_negeri', 'tbl_tabung_bwi_kawasan.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_tabung_bwi_kawasan.id_daerah', 'ref_daerah.id')
            ->join('ref_bencana', 'tbl_tabung_bwi.id_bencana', 'ref_bencana.id')
            ->leftJoin('tbl_mangsa_wang_ihsan', function ($join) {
                $join->on('tbl_mangsa_wang_ihsan.id_bencana', '=', 'tbl_tabung_bwi.id_bencana');
                $join->on('tbl_mangsa_wang_ihsan.id_jenis_bwi', '=', 'tbl_tabung_bwi.id_jenis_bwi');
                $join->on('tbl_mangsa_wang_ihsan.id_daerah', '=', 'tbl_tabung_bwi_kawasan.id_daerah');
            })
            ->groupBy('tbl_tabung_bwi.id', 'ref_bencana.id', 'ref_negeri.id', 'ref_daerah.id', 'tbl_mangsa_wang_ihsan.jumlah', 'tbl_tabung_bwi_kawasan.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('ref_bencana.id', $filterBencana);
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('ref_negeri.id', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('ref_daerah.id', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYearEft) {
                $query->when($filterYearEft, function ($query, $filterYearEft) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tarikh_eft)'), '=', $filterYearEft);
                });
            })
            ->where(function ($query) use ($filterYearBencana) {
                $query->when($filterYearBencana, function ($query, $filterYearBencana) {
                    return $query->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYearBencana);
                });
            })
            ->select($columns)
            ->orderBy('tbl_tabung_bwi.id')
            ->get();
    }

    public function getAllLaporanBwiBencanaKir(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'ref_bencana.id asc';
        $filter = $request->filter;
        $filterBencana = $request->filterBencana;
        $filterYear = $request->filterYear;

        $columns = [
            'nama_bencana', 'tbl_mangsa_wang_ihsan.jumlah'
        ];

        $data = DB::table('ref_bencana')
            ->join('tbl_mangsa_wang_ihsan', 'ref_bencana.id', 'tbl_mangsa_wang_ihsan.id_bencana')
            ->select(
                'ref_bencana.id as id_bencana',
                'nama_bencana', 'ref_bencana.tarikh_bencana',
                'tbl_mangsa_wang_ihsan.jumlah',
                DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah_peruntukan'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan'),
                DB::raw("(coalesce((select sum(tbl_mangsa_wang_ihsan.jumlah) ), 0.00) -
                    coalesce((select sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan)), 0.00)) as jumlah_diagihkan")
            )
            ->groupBy('ref_bencana.id', 'tbl_mangsa_wang_ihsan.jumlah')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('ref_bencana.id', $filterBencana);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear);
                });
            });


        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $totalCount = $result->count();

        $total_kir = 0;
        $total_peruntukan = 0;
        $total_dipulangkan = 0;
        $total_diagihkan = 0;

        foreach($result as $d){
            $total_kir = $total_kir + $d->bil;
            $total_peruntukan = $total_peruntukan + $d->jumlah_peruntukan;
            $total_dipulangkan = $total_dipulangkan + $d->jumlah_dipulangkan;
            $total_diagihkan = $total_diagihkan + $d->jumlah_diagihkan;
        }

        return response()->json([
            'total_count' => $totalCount,
            'total_kir' => $total_kir,
            'total_peruntukan' => $total_peruntukan,
            'total_dipulangkan' => $total_dipulangkan,
            'total_diagihkan' => $total_diagihkan,
            'items' => $result,
        ], 200);
    }

    public function exportAllLaporanBwiBencanaKirToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Bwi_Bencana_Kir' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiBwiBencanaKirExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiLaporanBwiBencanaKirExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterBencana = array_key_exists('filterBencana', $input) ? $input['filterBencana']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama_bencana', 'tbl_mangsa_wang_ihsan.jumlah', DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil'),
            DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah_peruntukan'), DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan'),
            DB::raw("(coalesce((select sum(tbl_mangsa_wang_ihsan.jumlah) ), 0.00) - coalesce((select sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan)), 0.00)) as jumlah_diagihkan")
        ];

        return DB::table('ref_bencana')
            ->join('tbl_mangsa_wang_ihsan', 'ref_bencana.id', 'tbl_mangsa_wang_ihsan.id_bencana')
            ->select(
                'nama_bencana',
                'tbl_mangsa_wang_ihsan.jumlah',
                DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah_peruntukan'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan'),
                DB::raw("(coalesce((select sum(tbl_mangsa_wang_ihsan.jumlah) ), 0.00) -
                    coalesce((select sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan)), 0.00)) as jumlah_diagihkan")
            )
            ->groupBy('ref_bencana.id', 'tbl_mangsa_wang_ihsan.jumlah')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('ref_bencana.id', $filterBencana);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear);
                });
            })
            ->orderBy('ref_bencana.id')
            ->get();
    }

    public function getAllLaporanBwiByNegeri(Request $request)
    {
        $maxResultCount = 14;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'ref_negeri.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterYear = $request->filterYear;

        $columns = [
            'ref_negeri.id', 'nama_negeri'
        ];

        $bwiNegeri = DB::table('ref_negeri')
            ->leftJoin('tbl_mangsa_wang_ihsan', 'ref_negeri.id', 'tbl_mangsa_wang_ihsan.id_negeri')
            ->where('ref_negeri.status_negeri', 1)
            ->select(
                'ref_negeri.id',
                'nama_negeri', 'tbl_mangsa_wang_ihsan.tarikh_cipta',
                DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan')
            )
            ->groupBy('ref_negeri.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('ref_negeri.id', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_wang_ihsan.tarikh_cipta)'), '=', $filterYear);
                });
            });

        $result = $bwiNegeri
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $data = array();
        $total_kir = 0;
        $total_jumlah = 0;
        $total_dipulangkan = 0;
        $total_diagihkan = 0;

        foreach($result as $r){
            $item = array();
            $item['nama_negeri'] = $r->nama_negeri;
            $item['bil'] = $r->bil ?? 0;
            $item['jumlah'] = $r->jumlah ?? 0;
            $item['jumlah_dipulangkan'] = $r->jumlah_dipulangkan ?? 0;
            $item['jumlah_diagihkan'] = $r->jumlah - $r->jumlah_dipulangkan;

            $total_kir = $total_kir + $r->bil;
            $total_jumlah = $total_jumlah + $r->jumlah;
            $total_dipulangkan = $total_dipulangkan + $r->jumlah_dipulangkan;
            $total_diagihkan = $total_diagihkan + $item['jumlah_diagihkan'];

            $data[] = $item;
        }


        // if($filterNegeri == null && $filter == null){
        //     for ($i = 1; $i <= 14; $i++) {
        //         $result_negeri = array();

        //         $negeri = RefNegeri::where('id', $i)->pluck('nama_negeri')->first();
        //         $result_negeri['nama_negeri'] = $negeri;

        //         $item = $result->where('id', $i)->first();

        //         if ($item) {
        //             $result_negeri['bil'] = $item->bil ?? 0;
        //             $result_negeri['jumlah'] = $item->jumlah ?? 0;
        //             $result_negeri['jumlah_dipulangkan'] = $item->jumlah_dipulangkan ?? 0;
        //             $result_negeri['jumlah_diagihkan'] = $item->jumlah - $item->jumlah_dipulangkan;
        //         } else {
        //             $result_negeri['bil'] = 0;
        //             $result_negeri['jumlah'] = 0;
        //             $result_negeri['jumlah_dipulangkan'] = 0;
        //             $result_negeri['jumlah_diagihkan'] = 0;
        //         }

        //         $total_kir = $total_kir + $result_negeri['bil'];
        //         $total_jumlah = $total_jumlah + $result_negeri['jumlah'];
        //         $total_dipulangkan = $total_dipulangkan + $result_negeri['jumlah_dipulangkan'];
        //         $total_diagihkan = $total_diagihkan + $result_negeri['jumlah_diagihkan'];

        //         $data[] = $result_negeri;
        //     }
        // }else{
        //     $item = $result->where('id', $filterNegeri)->first();
        //     $filterUpper = strtoupper($filter);
        //     $itemFilter = $result->where('nama_negeri', $filterUpper)->first();

        //     if($item || $itemFilter){
        //         foreach($result as $r){
        //             $result_negeri['nama_negeri'] = $r->nama_negeri;
        //             $result_negeri['bil'] = $r->bil ?? 0;
        //             $result_negeri['jumlah'] = $r->jumlah ?? 0;
        //             $result_negeri['jumlah_dipulangkan'] = $r->jumlah_dipulangkan ?? 0;
        //             $result_negeri['jumlah_diagihkan'] = $r->jumlah - $r->jumlah_dipulangkan;

        //             $total_kir = $total_kir + $result_negeri['bil'];
        //             $total_jumlah = $total_jumlah + $result_negeri['jumlah'];
        //             $total_dipulangkan = $total_dipulangkan + $result_negeri['jumlah_dipulangkan'];
        //             $total_diagihkan = $total_diagihkan + $result_negeri['jumlah_diagihkan'];
        //             $data[] = $result_negeri;
        //         }
        //     }else{
        //         $negeri = RefNegeri::where('id', $filterNegeri)->pluck('nama_negeri')->first();
        //         $negeriFilter = RefNegeri::where('nama_negeri', 'ILIKE', '%' . $filter . '%')->pluck('nama_negeri')->first();

        //         $result_negeri['nama_negeri'] = $negeri ?? $negeriFilter;
        //         $result_negeri['bil'] = 0;
        //         $result_negeri['jumlah'] =  0;
        //         $result_negeri['jumlah_dipulangkan'] =  0;
        //         $result_negeri['jumlah_diagihkan'] = 0;

        //         $total_kir = $total_kir + $result_negeri['bil'];
        //         $total_jumlah = $total_jumlah + $result_negeri['jumlah'];
        //         $total_dipulangkan = $total_dipulangkan + $result_negeri['jumlah_dipulangkan'];
        //         $total_diagihkan = $total_diagihkan + $result_negeri['jumlah_diagihkan'];
        //         $data[] = $result_negeri;
        //     }

        // }

        $totalCount = count($data);

        return response()->json([
            'total_count' => $totalCount,
            'total_kir' => $total_kir,
            'total_jumlah' => $total_jumlah,
            'total_dipulangkan' => $total_dipulangkan,
            'total_diagihkan' => $total_diagihkan,
            'items' => $data,
        ], 200);
    }

    public function exportAllLaporanBwiByNegeriToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Bwi_Negeri' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiBwiByNegeriExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiLaporanBwiByNegeriExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear'] : null;

        $columns = [
            'nama_negeri', 'ref_negeri.id'
        ];

        $bwi = DB::table('ref_negeri')
            ->leftJoin('tbl_mangsa_wang_ihsan', 'ref_negeri.id', 'tbl_mangsa_wang_ihsan.id_negeri')
            ->select(
                'ref_negeri.id',
                'nama_negeri',
                DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan'),
            )
            ->groupBy('ref_negeri.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('ref_negeri.id', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_wang_ihsan.tarikh_cipta)'), '=', $filterYear);
                });
            })
            ->orderBy('ref_negeri.id')
            ->get();

        $data = array();

        if($filterNegeri == null && $filter == null){
            for ($i = 1; $i <= 14; $i++) {
                $result_negeri = array();

                $negeri = RefNegeri::where('id', $i)->pluck('nama_negeri')->first();
                $result_negeri['nama_negeri'] = $negeri;

                $item = $bwi->where('id', $i)->first();

                if ($item) {
                    $result_negeri['bil'] = $item->bil ?? 0;
                    $result_negeri['jumlah'] = $item->jumlah ?? 0;
                    $result_negeri['jumlah_dipulangkan'] = $item->jumlah_dipulangkan ?? 0;
                    $result_negeri['jumlah_diagihkan'] = $item->jumlah - $item->jumlah_dipulangkan;
                } else {
                    $result_negeri['bil'] = 0;
                    $result_negeri['jumlah'] = 0;
                    $result_negeri['jumlah_dipulangkan'] = 0;
                    $result_negeri['jumlah_diagihkan'] = 0;
                }

                $data[] = $result_negeri;
            }
        }else{
            $item = $bwi->where('id', $filterNegeri)->first();
            $filterUpper = strtoupper($filter);
            $itemFilter = $bwi->where('nama_negeri', $filterUpper)->first();

            if($item || $itemFilter){
                foreach($bwi as $r){
                    $result_negeri['nama_negeri'] = $r->nama_negeri;
                    $result_negeri['bil'] = $r->bil ?? 0;
                    $result_negeri['jumlah'] = $r->jumlah ?? 0;
                    $result_negeri['jumlah_dipulangkan'] = $r->jumlah_dipulangkan ?? 0;
                    $result_negeri['jumlah_diagihkan'] = $r->jumlah - $r->jumlah_dipulangkan;
                    $data[] = $result_negeri;
                }
            }else{
                $negeri = RefNegeri::where('id', $filterNegeri)->pluck('nama_negeri')->first();
                $negeriFilter = RefNegeri::where('nama_negeri', 'ILIKE', '%' . $filter . '%')->pluck('nama_negeri')->first();

                $result_negeri['nama_negeri'] = $negeri ?? $negeriFilter;
                $result_negeri['bil'] = 0;
                $result_negeri['jumlah'] =  0;
                $result_negeri['jumlah_dipulangkan'] =  0;
                $result_negeri['jumlah_diagihkan'] = 0;
                $data[] = $result_negeri;
            }
        }
        return collect($data);
    }

    public function getAllLaporanBwiKematian(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bwi_kawasan.id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;
        $filterYear = $request->filterYear;

        $columns = [
            'nama_negeri', 'nama_daerah', 'no_rujukan_saluran_kpd_bkp', 'tarikh_saluran_kpd_bkp', 'catatan'
        ];

        $data = DB::table('tbl_tabung_bwi_kawasan')
            ->join('ref_negeri', 'tbl_tabung_bwi_kawasan.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_tabung_bwi_kawasan.id_daerah', 'ref_daerah.id')
            ->join('tbl_tabung_bwi', 'tbl_tabung_bwi_kawasan.id_tabung_bwi', 'tbl_tabung_bwi.id')
            ->where('id_jenis_bwi', 2)
            ->select(
                'nama_negeri',
                'nama_daerah', 'tbl_tabung_bwi_kawasan.tarikh_cipta',
                'no_rujukan_saluran_kpd_bkp',
                'tarikh_saluran_kpd_bkp',
                'catatan',
                DB::raw("(coalesce((select count(id) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi
                    and id_daerah = tbl_tabung_bwi_kawasan.id_daerah), 0.00)) as bil_kir"),
                DB::raw("(coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi
                    and id_daerah = tbl_tabung_bwi_kawasan.id_daerah), 0.00)) as jumlah")
            )
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('ref_negeri.id', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('ref_daerah.id', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bwi_kawasan.tarikh_cipta)'), '=', $filterYear);
                });
            });

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $totalCount = $result->count();
        $total_kir = 0;
        $total_peruntukan = 0;

        foreach($result as $r){
            $total_kir = $total_kir + $r->bil_kir;
            $total_peruntukan = $total_peruntukan + $r->jumlah;
        }

        return response()->json([
            'total_count' => $totalCount,
            'total_kir' => $total_kir,
            'total_peruntukan' => $total_peruntukan,
            'items' => $result,
        ], 200);
    }

    public function exportAllLaporanBwiKematianToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Bwi_Kematian' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiBwiKematianExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiLaporanBwiKematianExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterNegeri = array_key_exists('filterNegeri', $input) ? $input['filterNegeri']  : null;
        $filterDaerah = array_key_exists('filterDaerah', $input) ? $input['filterDaerah']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'nama_negeri', 'nama_daerah', 'no_rujukan_saluran_kpd_bkp', DB::raw("(coalesce((select count(id) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi
            and id_daerah = tbl_tabung_bwi_kawasan.id_daerah), 0.00)) as bil_kir"),
            DB::raw("(coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi
            and id_daerah = tbl_tabung_bwi_kawasan.id_daerah), 0.00)) as jumlah"),
            'tarikh_saluran_kpd_bkp', 'catatan'
        ];

        return DB::table('tbl_tabung_bwi_kawasan')
            ->join('ref_negeri', 'tbl_tabung_bwi_kawasan.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_tabung_bwi_kawasan.id_daerah', 'ref_daerah.id')
            ->join('tbl_tabung_bwi', 'tbl_tabung_bwi_kawasan.id_tabung_bwi', 'tbl_tabung_bwi.id')
            ->where('id_jenis_bwi', 2)
            ->select(
                'nama_negeri',
                'nama_daerah',
                'no_rujukan_saluran_kpd_bkp',
                DB::raw("(coalesce((select count(id) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi
                    and id_daerah = tbl_tabung_bwi_kawasan.id_daerah), 0.00)) as bil_kir"),
                DB::raw("(coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi
                    and id_daerah = tbl_tabung_bwi_kawasan.id_daerah), 0.00)) as jumlah"),
                'tarikh_saluran_kpd_bkp',
                'catatan'
            )
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterNegeri) {
                $query->when($filterNegeri, function ($query, $filterNegeri) {
                    return $query->where('ref_negeri.id', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('ref_daerah.id', $filterDaerah);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bwi_kawasan.tarikh_cipta)'), '=', $filterYear);
                });
            })
            ->orderBy('tbl_tabung_bwi_kawasan.id')
            ->get();
    }

    public function getAllLaporanKelulusan(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_kelulusan.id asc';
        $filter = $request->filter;
        $filterFromDateMula =  $request->filterFromDateMula;
        $filterToDateMula = $request->filterToDateMula;
        $filterFromDateTamat =  $request->filterFromDateTamat;
        $filterToDateTamat = $request->filterToDateTamat;

        $columns = [
            'tbl_tabung_kelulusan.id', 'no_rujukan_kelulusan', 'tarikh_surat', 'perihal_surat', 'tarikh_mula_kelulusan', 'tarikh_tamat_kelulusan', 'jumlah_siling',
            'baki_jumlah_siling', 'rujukan'
        ];

        $data = DB::table('tbl_tabung_kelulusan')
            ->where('status_tabung_kelulusan', 1)
            ->select(
                'tbl_tabung_kelulusan.id', 'no_rujukan_kelulusan', 'tarikh_surat', 'perihal_surat', 'tarikh_mula_kelulusan', 'tarikh_tamat_kelulusan', 'jumlah_siling',
                'baki_jumlah_siling', 'rujukan',
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_kelulusan_ambilan where id_tabung_kelulusan = tbl_tabung_kelulusan.id), 0.00) as jumlah_diambil"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 1), 0.00) as jumlah_terus_covid_semasa"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 2), 0.00) as jumlah_terus_bukan_covid_semasa"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 1), 0.00) as jumlah_terus_covid_sebelum"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 2), 0.00) as jumlah_terus_bukan_covid_sebelum")
            )
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterFromDateMula){
                $query->when($filterFromDateMula, function($query, $filterFromDateMula){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_mula_kelulusan', '>=', Carbon::parse($filterFromDateMula)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDateMula){
                $query->when($filterToDateMula, function($query, $filterToDateMula){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_mula_kelulusan', '<=', Carbon::parse($filterToDateMula)->endOfDay());
                });
            })
            ->where(function($query) use ($filterFromDateTamat){
                $query->when($filterFromDateTamat, function($query, $filterFromDateTamat){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_tamat_kelulusan', '>=', Carbon::parse($filterFromDateTamat)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDateTamat){
                $query->when($filterToDateTamat, function($query, $filterToDateTamat){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_tamat_kelulusan', '<=', Carbon::parse($filterToDateTamat)->endOfDay());
                });
            });

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $skbCovid = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 1)
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $skbBukanCovid = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 2)
            ->whereIn('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $skbCovidSebelum = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 1)
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $skbBukanCovidSebelum = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 2)
            ->whereIn('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $waranSemasa = DB::table('tbl_tabung_bayaran_waran')
            ->join('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
            ->where('tbl_tabung_bayaran_waran.id_kategori_bayaran', 1)
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $waranSebelum = DB::table('tbl_tabung_bayaran_waran')
            ->join('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
            ->where('tbl_tabung_bayaran_waran.id_kategori_bayaran', 1)
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $data = array();
        $total_siling_peruntukan = 0;
        $total_peruntukan_diambil = 0;
        $total_belanja_covid_sebelum = 0;
        $total_belanja__bukan_covid_sebelum = 0;
        $total_skb_covid = 0;
        $total_skb_bukan_covid = 0;
        $total_terus_covid = 0;
        $total_terus_bukan_covid = 0;
        $total_belanja_covid_semasa = 0;
        $total_belanja__bukan_covid_semasa = 0;
        $total_waran = 0;
        $total_belanja = 0;
        $total_baki_peruntukan = 0;

        foreach ($result as $kelulusan) {
            $item = array();
            $item['kelulusan'] = $kelulusan;
            $item['jumlah_skb_covid_semasa'] = $skbCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() ?? 0;
            $item['jumlah_skb_bukan_covid_semasa'] = $skbBukanCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() ?? 0;
            $item['jumlah_waran_semasa'] = $waranSemasa->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() ?? 0;
            $item['belanja_covid_semasa'] = $skbCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_covid_semasa + $item['jumlah_waran_semasa'];
            $item['belanja_bukan_covid_semasa'] = $skbBukanCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_bukan_covid_semasa;
            $item['belanja_covid_sebelum'] = $skbCovidSebelum->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_covid_sebelum + $waranSebelum->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first();
            $item['belanja_bukan_covid_sebelum'] = $skbBukanCovidSebelum->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_bukan_covid_sebelum;
            $item['jumlah_belanja'] = $item['belanja_covid_semasa'] + $item['belanja_bukan_covid_semasa'] + $item['belanja_covid_sebelum'] + $item['belanja_bukan_covid_sebelum'];

            $total_siling_peruntukan = $total_siling_peruntukan + $kelulusan->jumlah_siling;
            $total_peruntukan_diambil = $total_peruntukan_diambil + $kelulusan->jumlah_diambil;
            $total_belanja_covid_sebelum = $total_belanja_covid_sebelum + $item['belanja_covid_sebelum'];
            $total_belanja__bukan_covid_sebelum = $total_belanja__bukan_covid_sebelum + $item['belanja_bukan_covid_sebelum'];
            $total_skb_covid = $total_skb_covid + $item['jumlah_skb_covid_semasa'];
            $total_skb_bukan_covid = $total_skb_bukan_covid + $item['jumlah_skb_bukan_covid_semasa'];
            $total_terus_covid = $total_terus_covid + $kelulusan->jumlah_terus_covid_semasa;
            $total_terus_bukan_covid = $total_terus_bukan_covid + $kelulusan->jumlah_terus_bukan_covid_semasa;
            $total_belanja_covid_semasa = $total_belanja_covid_semasa + $item['belanja_covid_semasa'];
            $total_belanja__bukan_covid_semasa = $total_belanja__bukan_covid_semasa + $item['belanja_bukan_covid_semasa'];
            $total_waran = $total_waran + $item['jumlah_waran_semasa'];
            $total_belanja = $total_belanja + $item['jumlah_belanja'];
            $total_baki_peruntukan = $total_baki_peruntukan + $kelulusan->baki_jumlah_siling;

            $data[] = $item;
        }

        return response()->json([
            'total_count' => $totalCount,
            'total_siling_peruntukan'=> $total_siling_peruntukan,
            'total_peruntukan_diambil'=> $total_peruntukan_diambil,
            'total_belanja_covid_sebelum'=> $total_belanja_covid_sebelum,
            'total_belanja__bukan_covid_sebelum'=> $total_belanja__bukan_covid_sebelum,
            'total_skb_covid'=> $total_skb_covid,
            'total_skb_bukan_covid'=> $total_skb_bukan_covid,
            'total_terus_covid'=> $total_terus_covid,
            'total_terus_bukan_covid'=> $total_terus_bukan_covid,
            'total_belanja_covid_semasa'=> $total_belanja_covid_semasa,
            'total_belanja__bukan_covid_semasa'=> $total_belanja__bukan_covid_semasa,
            'total_waran'=> $total_waran,
            'total_belanja'=> $total_belanja,
            'total_baki_peruntukan'=> $total_baki_peruntukan,
            'items' => $data,
        ], 200);
    }

    public function exportAllLaporanKelulusanToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Kelulusan' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiLaporanKelulusanExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiLaporanKelulusanExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterFromDateMula = array_key_exists('filterFromDateMula', $input) ? $input['filterFromDateMula']  : null;
        $filterToDateMula = array_key_exists('filterToDateMula', $input) ? $input['filterToDateMula']  : null;
        $filterFromDateTamat = array_key_exists('filterFromDateTamat', $input) ? $input['filterFromDateTamat']  : null;
        $filterToDateTamat = array_key_exists('filterToDateTamat', $input) ? $input['filterToDateTamat']  : null;

        $columns = [
            'tbl_tabung_kelulusan.id', 'no_rujukan_kelulusan', 'tarikh_surat', 'perihal_surat', 'tarikh_mula_kelulusan', 'tarikh_tamat_kelulusan', 'jumlah_siling',
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_kelulusan_ambilan where id_tabung_kelulusan = tbl_tabung_kelulusan.id), 0.00) as jumlah_diambil"),
            'baki_jumlah_siling', 'rujukan',
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 1), 0.00) as jumlah_terus_covid_semasa"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 2), 0.00) as jumlah_terus_bukan_covid_semasa"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 1), 0.00) as jumlah_terus_covid_sebelum"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 2), 0.00) as jumlah_terus_bukan_covid_sebelum")
        ];

        $tabungKelulusan = DB::table('tbl_tabung_kelulusan')
            ->where('status_tabung_kelulusan', 1)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterFromDateMula){
                $query->when($filterFromDateMula, function($query, $filterFromDateMula){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_mula_kelulusan', '>=', Carbon::parse($filterFromDateMula)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDateMula){
                $query->when($filterToDateMula, function($query, $filterToDateMula){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_mula_kelulusan', '<=', Carbon::parse($filterToDateMula)->endOfDay());
                });
            })
            ->where(function($query) use ($filterFromDateTamat){
                $query->when($filterFromDateTamat, function($query, $filterFromDateTamat){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_tamat_kelulusan', '>=', Carbon::parse($filterFromDateTamat)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDateTamat){
                $query->when($filterToDateTamat, function($query, $filterToDateTamat){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_tamat_kelulusan', '<=', Carbon::parse($filterToDateTamat)->endOfDay());
                });
            })
            ->select($columns)
            ->orderBy('tbl_tabung_kelulusan.id')
            ->get();

        $skbCovid = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 1)
            ->whereIn('id_tabung_kelulusan', $tabungKelulusan->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $skbBukanCovid = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 2)
            ->whereIn('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $tabungKelulusan->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $skbCovidSebelum = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 1)
            ->whereIn('id_tabung_kelulusan', $tabungKelulusan->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $skbBukanCovidSebelum = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 2)
            ->whereIn('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $tabungKelulusan->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $data = array();
        foreach ($tabungKelulusan as $kelulusan) {
            $item = array();
            $item['no_rujukan_kelulusan'] = $kelulusan->no_rujukan_kelulusan;
            $item['tarikh_surat'] = $kelulusan->tarikh_surat;
            $item['perihal_surat'] = $kelulusan->perihal_surat;
            $item['tarikh_mula_kelulusan'] = $kelulusan->tarikh_mula_kelulusan;
            $item['tarikh_tamat_kelulusan'] = $kelulusan->tarikh_tamat_kelulusan;
            $item['jumlah_siling'] = $kelulusan->jumlah_siling;
            $item['jumlah_diambil'] = $kelulusan->jumlah_diambil;
            $item['baki_jumlah_siling'] = $kelulusan->baki_jumlah_siling;
            $item['rujukan'] = $kelulusan->rujukan;
            $item['jumlah_terus_covid_semasa'] = $kelulusan->jumlah_terus_covid_semasa;
            $item['jumlah_terus_bukan_covid_semasa'] = $kelulusan->jumlah_terus_bukan_covid_semasa;
            $item['jumlah_skb_covid_semasa'] = $skbCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() ?? 0;
            $item['jumlah_skb_bukan_covid_semasa'] = $skbBukanCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() ?? 0;
            $item['belanja_covid_semasa'] = $skbCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_covid_semasa;
            $item['belanja_bukan_covid_semasa'] = $skbBukanCovid->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_bukan_covid_semasa;
            $item['belanja_covid_sebelum'] = $skbCovidSebelum->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_covid_sebelum;
            $item['belanja_bukan_covid_sebelum'] = $skbBukanCovidSebelum->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $kelulusan->jumlah_terus_bukan_covid_sebelum;
            $item['jumlah_belanja'] = $item['belanja_covid_semasa'] + $item['belanja_bukan_covid_semasa'] + $item['belanja_covid_sebelum'] + $item['belanja_bukan_covid_sebelum'];
            $data[] = $item;
        }
        return collect($data);
    }

    public function getAllLaporanSkb(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bayaran_skb.id desc';
        $filter = $request->filter;
        $filterAgensi = $request->filterAgensi;
        $filterKategori = $request->filterKategori;
        $filterStatus = $request->filterStatus;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_tabung_bayaran_skb.id', 'no_rujukan_skb', 'no_rujukan_kelulusan', 'tarikh_mula', 'tarikh_tamat', 'nama_skb_status', 'perihal', 'nama_pegawai', 'nama_agensi',
            'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_kategori_bayaran'
        ];

        $data = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
            ->join('ref_status_skb', 'tbl_tabung_bayaran_skb_status.id_status_skb', 'ref_status_skb.id')
            ->join('ref_agensi', 'tbl_tabung_bayaran_skb.id_agensi', 'ref_agensi.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_skb.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->select(
                'tbl_tabung_bayaran_skb.id', 'no_rujukan_skb', 'no_rujukan_kelulusan', 'tarikh_mula', 'tarikh_tamat', 'nama_skb_status', 'perihal', 'nama_pegawai', 'nama_agensi',
                'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_kategori_bayaran',
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 1), 0.00) as jumlah_januari"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 2), 0.00) as jumlah_februari"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 3), 0.00) as jumlah_mac"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 4), 0.00) as jumlah_april"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 5), 0.00) as jumlah_mei"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 6), 0.00) as jumlah_jun"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 7), 0.00) as jumlah_julai"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 8), 0.00) as jumlah_ogos"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 9), 0.00) as jumlah_september"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 10), 0.00) as jumlah_oktober"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 11), 0.00) as jumlah_november"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 12), 0.00) as jumlah_disember"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id), 0.00) as jumlah_keseluruhan"),
            )
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterAgensi) {
                $query->when($filterAgensi, function ($query, $filterAgensi) {
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function ($query) use ($filterKategori) {
                $query->when($filterKategori, function ($query, $filterKategori) {
                    return $query->where('id_kategori_bayaran', $filterKategori);
                });
            })
            ->where(function ($query) use ($filterStatus) {
                $query->when($filterStatus, function ($query, $filterStatus) {
                    return $query->where('id_status_skb', $filterStatus);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_skb.tarikh_cipta)'), '=', $filterYear);
                });
            });

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $totalBayaranSkb = DB::Table('tbl_tabung_bayaran_skb')
        ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
        ->where(function ($query) use ($filterAgensi) {
            $query->when($filterAgensi, function ($query, $filterAgensi) {
                return $query->where('id_agensi', $filterAgensi);
            });
        })
        ->where(function ($query) use ($filterKategori) {
            $query->when($filterKategori, function ($query, $filterKategori) {
                return $query->where('id_kategori_bayaran', $filterKategori);
            });
        })
        ->where(function ($query) use ($filterStatus) {
            $query->when($filterStatus, function ($query, $filterStatus) {
                return $query->where('id_status_skb', $filterStatus);
            });
        })
        ->where(function ($query) use ($filterYear) {
            $query->when($filterYear, function ($query, $filterYear) {
                return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_skb.tarikh_cipta)'), '=', $filterYear);
            });
        })
        ->select(DB::raw('sum(jumlah_siling_peruntukan) as jumlah_siling_peruntukan'), DB::raw('sum(jumlah_baki_peruntukan) as jumlah_baki_peruntukan'))
        ->first();

        $totalBelanjaSkbBulan = DB::Table('tbl_tabung_bayaran_skb')
        ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
        ->leftJoin('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
        ->where(function ($query) use ($filterAgensi) {
            $query->when($filterAgensi, function ($query, $filterAgensi) {
                return $query->where('id_agensi', $filterAgensi);
            });
        })
        ->where(function ($query) use ($filterKategori) {
            $query->when($filterKategori, function ($query, $filterKategori) {
                return $query->where('id_kategori_bayaran', $filterKategori);
            });
        })
        ->where(function ($query) use ($filterStatus) {
            $query->when($filterStatus, function ($query, $filterStatus) {
                return $query->where('id_status_skb', $filterStatus);
            });
        })
        ->where(function ($query) use ($filterYear) {
            $query->when($filterYear, function ($query, $filterYear) {
                return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_skb.tarikh_cipta)'), '=', $filterYear);
            });
        })
        ->select( DB::raw("coalesce((select sum(tbl_tabung_bayaran_skb_bulanan.jumlah)), 0.00) as total_jumlah_keseluruhan"))
        ->groupBy('tahun')
        ->first();

        return response()->json([
            'total_count' => $totalCount,
            'jumlah_siling_peruntukan' => $totalBayaranSkb->jumlah_siling_peruntukan ?? 0,
            'jumlah_baki_peruntukan' => $totalBayaranSkb->jumlah_baki_peruntukan ?? 0,
            'total_jumlah_keseluruhan' => $totalBelanjaSkbBulan->total_jumlah_keseluruhan ?? 0,
            'items' => $result,
        ], 200);
    }

    public function exportAllLaporanSkbToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Skb' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiLaporanSkbExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiLaporanSkbExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterAgensi = array_key_exists('filterAgensi', $input) ? $input['filterAgensi']  : null;
        $filterKategori = array_key_exists('filterKategori', $input) ? $input['filterKategori']  : null;
        $filterStatus = array_key_exists('filterStatus', $input) ? $input['filterStatus']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'no_rujukan_skb', 'no_rujukan_kelulusan', 'tarikh_mula', 'tarikh_tamat', 'nama_skb_status', 'perihal', 'nama_pegawai', 'nama_agensi',
            'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_kategori_bayaran',
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 1), 0.00) as jumlah_januari"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 2), 0.00) as jumlah_februari"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 3), 0.00) as jumlah_mac"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 4), 0.00) as jumlah_april"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 5), 0.00) as jumlah_mei"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 6), 0.00) as jumlah_jun"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 7), 0.00) as jumlah_julai"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 8), 0.00) as jumlah_ogos"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 9), 0.00) as jumlah_september"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 10), 0.00) as jumlah_oktober"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 11), 0.00) as jumlah_november"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id and id_bulan = 12), 0.00) as jumlah_disember"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id), 0.00) as jumlah_keseluruhan"),
        ];

        return DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
            ->join('ref_status_skb', 'tbl_tabung_bayaran_skb_status.id_status_skb', 'ref_status_skb.id')
            ->join('ref_agensi', 'tbl_tabung_bayaran_skb.id_agensi', 'ref_agensi.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_skb.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterAgensi) {
                $query->when($filterAgensi, function ($query, $filterAgensi) {
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function ($query) use ($filterKategori) {
                $query->when($filterKategori, function ($query, $filterKategori) {
                    return $query->where('id_kategori_bayaran', $filterKategori);
                });
            })
            ->where(function ($query) use ($filterStatus) {
                $query->when($filterStatus, function ($query, $filterStatus) {
                    return $query->where('id_status_skb', $filterStatus);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_skb.tarikh_cipta)'), '=', $filterYear);
                });
            })
            ->select($columns)
            ->orderBy('tbl_tabung_bayaran_skb.id')
            ->get();
    }

    public function getAllLaporanWaran(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bayaran_waran.id desc';
        $filter = $request->filter;
        $filterAgensi = $request->filterAgensi;
        $filterKategori = $request->filterKategori;
        $filterStatus = $request->filterStatus;
        $filterYear = $request->filterYear;

        $columns = [
            'tbl_tabung_bayaran_waran.id', 'no_rujukan_waran', 'no_rujukan_kelulusan', 'tarikh_surat_waran', 'tbl_tabung_bayaran_waran.tarikh_cipta', 'nama_waran_status', 'perihal', 'nama_agensi',
            'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_kategori_bayaran', 'rujukan_surat_waran'
        ];

        $data = DB::table('tbl_tabung_bayaran_waran')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_waran.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
            ->join('ref_status_waran', 'tbl_tabung_bayaran_waran_status.id_status_waran', 'ref_status_waran.id')
            ->join('ref_agensi', 'tbl_tabung_bayaran_waran.id_agensi', 'ref_agensi.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_waran.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->select(
                'tbl_tabung_bayaran_waran.id', 'no_rujukan_waran', 'no_rujukan_kelulusan', 'tarikh_surat_waran', 'tbl_tabung_bayaran_waran.tarikh_cipta', 'nama_waran_status', 'perihal', 'nama_agensi',
                'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_kategori_bayaran', 'rujukan_surat_waran',
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 1), 0.00) as jumlah_januari"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 2), 0.00) as jumlah_februari"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 3), 0.00) as jumlah_mac"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 4), 0.00) as jumlah_april"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 5), 0.00) as jumlah_mei"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 6), 0.00) as jumlah_jun"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 7), 0.00) as jumlah_julai"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 8), 0.00) as jumlah_ogos"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 9), 0.00) as jumlah_september"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 10), 0.00) as jumlah_oktober"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 11), 0.00) as jumlah_november"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 12), 0.00) as jumlah_disember"),
                DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id), 0.00) as jumlah_keseluruhan")
            )
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterAgensi) {
                $query->when($filterAgensi, function ($query, $filterAgensi) {
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function ($query) use ($filterKategori) {
                $query->when($filterKategori, function ($query, $filterKategori) {
                    return $query->where('id_kategori_bayaran', $filterKategori);
                });
            })
            ->where(function ($query) use ($filterStatus) {
                $query->when($filterStatus, function ($query, $filterStatus) {
                    return $query->where('id_status_waran', $filterStatus);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_waran.tarikh_cipta)'), '=', $filterYear);
                });
            });

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $totalBayaranWaran = DB::Table('tbl_tabung_bayaran_waran')
        ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
        ->where(function ($query) use ($filterAgensi) {
            $query->when($filterAgensi, function ($query, $filterAgensi) {
                return $query->where('id_agensi', $filterAgensi);
            });
        })
        ->where(function ($query) use ($filterKategori) {
            $query->when($filterKategori, function ($query, $filterKategori) {
                return $query->where('id_kategori_bayaran', $filterKategori);
            });
        })
        ->where(function ($query) use ($filterStatus) {
            $query->when($filterStatus, function ($query, $filterStatus) {
                return $query->where('id_status_waran', $filterStatus);
            });
        })
        ->where(function ($query) use ($filterYear) {
            $query->when($filterYear, function ($query, $filterYear) {
                return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_waran.tarikh_cipta)'), '=', $filterYear);
            });
        })
        ->select(DB::raw('sum(jumlah_siling_peruntukan) as jumlah_siling_peruntukan'), DB::raw('sum(jumlah_baki_peruntukan) as jumlah_baki_peruntukan'))
        ->first();

        $totalBelanjaWaranBulan = DB::Table('tbl_tabung_bayaran_waran')
        ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
        ->leftJoin('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
        ->where(function ($query) use ($filterAgensi) {
            $query->when($filterAgensi, function ($query, $filterAgensi) {
                return $query->where('id_agensi', $filterAgensi);
            });
        })
        ->where(function ($query) use ($filterKategori) {
            $query->when($filterKategori, function ($query, $filterKategori) {
                return $query->where('id_kategori_bayaran', $filterKategori);
            });
        })
        ->where(function ($query) use ($filterStatus) {
            $query->when($filterStatus, function ($query, $filterStatus) {
                return $query->where('id_status_waran', $filterStatus);
            });
        })
        ->where(function ($query) use ($filterYear) {
            $query->when($filterYear, function ($query, $filterYear) {
                return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_waran.tarikh_cipta)'), '=', $filterYear);
            });
        })
        ->select( DB::raw("coalesce((select sum(tbl_tabung_bayaran_waran_bulanan.jumlah)), 0.00) as total_jumlah_keseluruhan"))
        ->groupBy('tahun')
        ->first();

        return response()->json([
            'total_count' => $totalCount,
            'jumlah_siling_peruntukan' => $totalBayaranWaran->jumlah_siling_peruntukan ?? 0,
            'jumlah_baki_peruntukan' => $totalBayaranWaran->jumlah_baki_peruntukan ?? 0,
            'total_jumlah_keseluruhan' => $totalBelanjaWaranBulan->total_jumlah_keseluruhan ?? 0,
            'items' => $result,
        ], 200);
    }

    public function exportAllLaporanWaranToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Waran' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiLaporanWaranExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiLaporanWaranExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterAgensi = array_key_exists('filterAgensi', $input) ? $input['filterAgensi']  : null;
        $filterKategori = array_key_exists('filterKategori', $input) ? $input['filterKategori']  : null;
        $filterStatus = array_key_exists('filterStatus', $input) ? $input['filterStatus']  : null;
        $filterYear = array_key_exists('filterYear', $input) ? $input['filterYear']  : null;

        $columns = [
            'no_rujukan_waran', 'no_rujukan_kelulusan', 'rujukan_surat_waran', 'perihal', 'tarikh_surat_waran', 'nama_waran_status', 'nama_agensi',
            'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_kategori_bayaran',
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 1), 0.00) as jumlah_januari"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 2), 0.00) as jumlah_februari"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 3), 0.00) as jumlah_mac"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 4), 0.00) as jumlah_april"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 5), 0.00) as jumlah_mei"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 6), 0.00) as jumlah_jun"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 7), 0.00) as jumlah_julai"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 8), 0.00) as jumlah_ogos"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 9), 0.00) as jumlah_september"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 10), 0.00) as jumlah_oktober"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 11), 0.00) as jumlah_november"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id and id_bulan = 12), 0.00) as jumlah_disember"),
            DB::raw("coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id), 0.00) as jumlah_keseluruhan"),
        ];


        return DB::table('tbl_tabung_bayaran_waran')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_waran.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
            ->join('ref_status_waran', 'tbl_tabung_bayaran_waran_status.id_status_waran', 'ref_status_waran.id')
            ->join('ref_agensi', 'tbl_tabung_bayaran_waran.id_agensi', 'ref_agensi.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_waran.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterAgensi) {
                $query->when($filterAgensi, function ($query, $filterAgensi) {
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function ($query) use ($filterKategori) {
                $query->when($filterKategori, function ($query, $filterKategori) {
                    return $query->where('id_kategori_bayaran', $filterKategori);
                });
            })
            ->where(function ($query) use ($filterStatus) {
                $query->when($filterStatus, function ($query, $filterStatus) {
                    return $query->where('id_status_waran', $filterStatus);
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_waran.tarikh_cipta)'), '=', $filterYear);
                });
            })
            ->select($columns)
            ->orderBy('tbl_tabung_bayaran_waran.id')
            ->get();
    }

    public function getAllRingkasanLaporanBwiByNegeri(Request $request)
    {
        $filterYear = $request->filterYear;

        $negeriBwi = DB::table('ref_negeri')
            ->leftJoin('tbl_mangsa_wang_ihsan', 'ref_negeri.id', 'tbl_mangsa_wang_ihsan.id_negeri')
            ->select(
                'ref_negeri.id',
                'nama_negeri',
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah'),
                DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah_dipulangkan')
            )
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa_wang_ihsan.tarikh_cipta)'), '=', $filterYear);
                });
            })
            ->groupBy('ref_negeri.id')
            ->get();


        $data = array();

        for ($i = 1; $i <= 14; $i++) {
            $result_negeri = array();

            $negeri = RefNegeri::where('id', $i)->pluck('nama_negeri')->first();
            $result_negeri['kategori'] = $negeri;

            $item = $negeriBwi->where('id', $i)->first();

            if ($item) {
                $result_negeri['jumlah_diagihkan'] = $item->jumlah - $item->jumlah_dipulangkan;
                $result_negeri['jumlah_dipulangkan'] = $item->jumlah_dipulangkan ?? 0;
            } else {
                $result_negeri['jumlah_diagihkan'] = 0;
                $result_negeri['jumlah_dipulangkan'] = 0;
            }

            $data[] = $result_negeri;
            }

        return response()->json([
            'items' => $data
        ], 200);
    }

    public function getBilBwiKirByJenisBayaran()
    {
        $BilKir = DB::Table('ref_jenis_bwi')
            ->join('tbl_mangsa_wang_ihsan', 'ref_jenis_bwi.id', 'tbl_mangsa_wang_ihsan.id_jenis_bwi')
            ->select('nama_jenis_bwi', DB::raw('count(tbl_mangsa_wang_ihsan.id_mangsa) as bil'))
            ->groupBy('ref_jenis_bwi.id')
            ->get();

        $data = array();
        $result = array();

        foreach($BilKir as $bk){
            $result = array("kategori" => $bk->nama_jenis_bwi, "bil" => $bk->bil);
            $data[] = $result;
        }
        $item = array();
        $item['items'] = $data;

        return response()->json([
            'items' => $data
        ], 200);
    }
}
