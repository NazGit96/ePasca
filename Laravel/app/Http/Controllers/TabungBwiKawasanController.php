<?php

namespace App\Http\Controllers;

use App\Models\TabungBwiKawasan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TabungBwiKawasanController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'tbl_tabung_bwi_kawasan.id', 'id_tabung_bwi', 'tbl_tabung_bwi_kawasan.id_daerah', 'tbl_tabung_bwi_kawasan.id_negeri', 'jumlah_kir', 'jumlah_kembali', 'tarikh_eft', 'catatan', 'no_rujukan_akuan_kp', 'tarikh_akuan_kp', 'no_rujukan_saluran_kpd_bkp', 'tarikh_saluran_kpd_bkp', 'no_rujukan_laporan_kpd_bkp', 'tarikh_laporan_kpd_bkp', 'no_rujukan_makluman_majlis', 'tarikh_makluman_majlis', 'tarikh_majlis_makluman_majlis', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_pengguna_hapus', 'tarikh_hapus', 'sebab_hapus'
        ];

        $data = DB::table('tbl_tabung_bwi_kawasan')
            ->join('ref_negeri', 'tbl_tabung_bwi_kawasan.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_tabung_bwi_kawasan.id_daerah', 'ref_daerah.id')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
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

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getAllKawasanByIdBwi(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterIdBwi = $request->filterIdBwi;
        $filterNegeri = $request->filterNegeri;
        $filterDaerah = $request->filterDaerah;

        $columns = [
            'tbl_tabung_bwi_kawasan.id', 'tbl_tabung_bwi_kawasan.id', 'id_tabung_bwi', 'tbl_tabung_bwi_kawasan.id_daerah', 'tbl_tabung_bwi_kawasan.id_negeri',
            'jumlah_bwi', 'jumlah_kir', 'jumlah_kembali', 'nama_negeri', 'nama_daerah'
        ];

        $data = DB::table('tbl_tabung_bwi_kawasan')
            ->join('tbl_tabung_bwi', 'tbl_tabung_bwi_kawasan.id_tabung_bwi', 'tbl_tabung_bwi.id')
            ->join('ref_negeri', 'tbl_tabung_bwi_kawasan.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_tabung_bwi_kawasan.id_daerah', 'ref_daerah.id')
            ->where('id_tabung_bwi', $filterIdBwi)
            ->select(
                'tbl_tabung_bwi_kawasan.id', 'tbl_tabung_bwi_kawasan.id', 'id_tabung_bwi', 'tbl_tabung_bwi_kawasan.id_daerah', 'tbl_tabung_bwi_kawasan.id_negeri',
                'jumlah_bwi', 'jumlah_kir', 'jumlah_kembali', 'nama_negeri', 'nama_daerah',
                DB::raw("coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_daerah = tbl_tabung_bwi_kawasan.id_daerah and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi and status_mangsa_wang_ihsan = 2), 0.00) as jumlah_dibayar"),
                DB::raw("coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_daerah = tbl_tabung_bwi_kawasan.id_daerah and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi and status_mangsa_wang_ihsan = 1), 0.00) as jumlah_belum_dibayar"),
                DB::raw("coalesce((select sum(jumlah_dipulangkan) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_daerah = tbl_tabung_bwi_kawasan.id_daerah and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi and status_mangsa_wang_ihsan = 3), 0.00) as jumlah_dipulangkan"),
                DB::raw("coalesce((select count(id) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_daerah = tbl_tabung_bwi_kawasan.id_daerah and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi and status_mangsa_wang_ihsan = 1), 0.00) as bil_kir_belum_dibayar"),
                DB::raw("coalesce((select count(id) from tbl_mangsa_wang_ihsan where id_bencana = tbl_tabung_bwi.id_bencana and id_daerah = tbl_tabung_bwi_kawasan.id_daerah and id_jenis_bwi = tbl_tabung_bwi.id_jenis_bwi), 0.00) as bil_kir")
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
                    return $query->where('tbl_tabung_bwi_kawasan.id_negeri', $filterNegeri);
                });
            })
            ->where(function ($query) use ($filterDaerah) {
                $query->when($filterDaerah, function ($query, $filterDaerah) {
                    return $query->where('tbl_tabung_bwi_kawasan.id_daerah', $filterDaerah);
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

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getTabungBwiKawasanForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBwiKawasan = TabungBwiKawasan::where('id', $request->id)->first();
        return response()->json(['tabung_bwi_kawasan' => $tabungBwiKawasan], 200);
    }

    public function addBwiKawasan(Request $request){
        $validator = Validator::make($request->all(), [
            'id_tabung_bwi' => 'required|numeric',
            'bwi_kawasan' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bantuanWangIhsanKawasan = $request->bwi_kawasan;

        try {
            DB::beginTransaction();

            foreach($bantuanWangIhsanKawasan as $bwi_kawasan){
                $bwiKawasan = TabungBwiKawasan::create([
                    'id_tabung_bwi' => $request->id_tabung_bwi,
                    'id_daerah' =>  $bwi_kawasan['id_daerah'],
                    'id_negeri' => $bwi_kawasan['id_negeri'],
                    'jumlah_bwi' => $bwi_kawasan['jumlah_bwi'],
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now()
                ]);

                $bwiKawasan->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message' => 'Maklumat Berjaya Ditambah!'], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $tabungBwiKawasan = $this->update($request);
        } else {
            $tabungBwiKawasan = $this->create($request);
        }

        return $tabungBwiKawasan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $tabungBwiKawasan = TabungBwiKawasan::create([
                'id_tabung_bwi' => $request->id_tabung_bwi,
                'id_daerah' => $request->id_daerah,
                'id_negeri' => $request->id_negeri,
                'jumlah_setiap_kir' => $request->jumlah_setiap_kir,
                'jumlah_kir' => $request->jumlah_kir,
                'jumlah_kembali' => $request->jumlah_kembali,
                'tarikh_eft' => $request->tarikh_eft,
                'catatan' => $request->catatan,
                'no_rujukan_akuan_kp' => $request->no_rujukan_akuan_kp,
                'tarikh_akuan_kp' => $request->tarikh_akuan_kp,
                'no_rujukan_saluran_kpd_bkp' => $request->no_rujukan_saluran_kpd_bkp,
                'tarikh_saluran_kpd_bkp' => $request->tarikh_saluran_kpd_bkp,
                'no_rujukan_laporan_kpd_bkp' => $request->no_rujukan_laporan_kpd_bkp,
                'tarikh_laporan_kpd_bkp' => $request->tarikh_laporan_kpd_bkp,
                'no_rujukan_makluman_majlis' => $request->no_rujukan_makluman_majlis,
                'tarikh_makluman_majlis' => $request->tarikh_makluman_majlis,
                'tarikh_majlis_makluman_majlis' => $request->tarikh_majlis_makluman_majlis,
                'tarikh_cipta' => Carbon::now(),
                'id_pengguna_cipta' => JWTAuth::user()->id

            ]);

            $tabungBwiKawasan->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message' => 'Maklumat Berjaya Ditambah!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBwiKawasan = TabungBwiKawasan::where('id', $request->id)->first();

        $tabungBwiKawasan->tarikh_eft = $request->tarikh_eft;
        $tabungBwiKawasan->due_report = $request->due_report;
        $tabungBwiKawasan->catatan = $request->catatan;
        $tabungBwiKawasan->no_rujukan_akuan_kp = $request->no_rujukan_akuan_kp;
        $tabungBwiKawasan->tarikh_akuan_kp = $request->tarikh_akuan_kp;
        $tabungBwiKawasan->no_rujukan_saluran_kpd_bkp = $request->no_rujukan_saluran_kpd_bkp;
        $tabungBwiKawasan->tarikh_saluran_kpd_bkp = $request->tarikh_saluran_kpd_bkp;
        $tabungBwiKawasan->no_rujukan_makluman_majlis = $request->no_rujukan_makluman_majlis;
        $tabungBwiKawasan->tarikh_makluman_majlis = $request->tarikh_makluman_majlis;
        $tabungBwiKawasan->tarikh_majlis_makluman_majlis = $request->tarikh_majlis_makluman_majlis;
        $tabungBwiKawasan->no_rujukan_majlis_drp_apm = $request->no_rujukan_majlis_drp_apm;
        $tabungBwiKawasan->tarikh_majlis_drp_apm = $request->tarikh_majlis_drp_apm;
        $tabungBwiKawasan->no_rujukan_laporan_kpd_bkp = $request->no_rujukan_laporan_kpd_bkp;
        $tabungBwiKawasan->tarikh_laporan_kpd_bkp = $request->tarikh_laporan_kpd_bkp;
        $tabungBwiKawasan->id_pengguna_kemaskini = JWTAuth::user()->id;
        $tabungBwiKawasan->tarikh_kemaskini = Carbon::now();

        $tabungBwiKawasan->save();

        return response()->json($tabungBwiKawasan, 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bwi = TabungBwiKawasan::where('id', $request->id)->first();

        $mangsa = DB::Table('tbl_tabung_bwi_kawasan')
        ->where('tbl_tabung_bwi_kawasan.id', $request->id)
        ->join('tbl_tabung_bwi', 'tbl_tabung_bwi_kawasan.id_tabung_bwi', 'tbl_tabung_bwi.id')
        ->join('tbl_mangsa_wang_ihsan', function ($join) {
            $join->on('tbl_mangsa_wang_ihsan.id_bencana', '=', 'tbl_tabung_bwi.id_bencana');
            $join->on('tbl_mangsa_wang_ihsan.id_jenis_bwi', '=', 'tbl_tabung_bwi.id_jenis_bwi');
            $join->on('tbl_mangsa_wang_ihsan.id_daerah', '=', 'tbl_tabung_bwi_kawasan.id_daerah');
        })
        ->select('id_mangsa')
        ->get();

        $mangsa->toArray();
        $mangsaCount =  count($mangsa);

        if ($mangsaCount > 0) {
            return response()->json(["message" => "Terdapat Bil. Kir di Dalam Bantuan Kawasan Wang Ihsan"], 200);

        } else {

            $bwi->delete();
            return response()->json(["message" => "Bantuan Kawasan Wang Ihsan Berjaya Dibuang"], 200);
        }
    }
}
