<?php

namespace App\Http\Controllers;

use App\Models\Mangsa;
use App\Models\MangsaBencana;
use App\Models\MangsaWangIhsan;
use App\Models\RefBencana;
use App\Models\Tabung;
use App\Models\TabungKelulusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaWangIhsanController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_wang_ihsan.id', 'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'tarikh_serahan', 'jumlah',
            'id_sumber_dana', 'status_mangsa_wang_ihsan', 'sebab_hapus', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'nama_agensi', 'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_wang_ihsan')
            ->join('ref_bencana', 'tbl_mangsa_wang_ihsan.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_wang_ihsan.id_agensi_bantuan', 'ref_agensi.id')
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

    public function getAllByIdMangsa(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $validator = Validator::make($request->all(), [
            'idMangsa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'tbl_mangsa_wang_ihsan.id', 'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'tarikh_serahan', 'jumlah',
            'id_sumber_dana', 'status_mangsa_wang_ihsan', 'sebab_hapus', 'id_pengguna_cipta', 'id_jenis_bwi', 'nama_jenis_bwi',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'nama_agensi', 'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_wang_ihsan')
            ->join('ref_bencana', 'tbl_mangsa_wang_ihsan.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_wang_ihsan.id_agensi_bantuan', 'ref_agensi.id')
            ->join('ref_jenis_bwi', 'tbl_mangsa_wang_ihsan.id_jenis_bwi', 'ref_jenis_bwi.id')
            ->select($columns)
            ->where('id_mangsa', $request->idMangsa)
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

    public function getAllMangsaByBencanaAndJenisBwi(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterBencana = $request->filterBencana;
        $filterJenisBwi = $request->filterJenisBwi;
        $filteDaerah = $request->filteDaerah;

        $columns = [
            'tbl_mangsa_wang_ihsan.id', 'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'tarikh_serahan', 'jumlah', 'jumlah_dipulangkan', 'tarikh_dipulangkan',
            'status_mangsa_wang_ihsan', 'tbl_mangsa.nama', 'nama_daerah', 'nama_negeri', 'tbl_mangsa.no_kp', 'tbl_mangsa_wang_ihsan.status_mangsa_wang_ihsan'
        ];

        $data = DB::table('tbl_mangsa_wang_ihsan')
            ->join('tbl_mangsa', 'tbl_mangsa_wang_ihsan.id_mangsa', 'tbl_mangsa.id')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_daerah', 'tbl_mangsa.id_daerah', 'ref_daerah.id')
            ->where('id_bencana', $filterBencana)
            ->where('id_jenis_bwi', $filterJenisBwi)
            ->where('tbl_mangsa_wang_ihsan.id_daerah', $filteDaerah)
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

    public function getTotalBwiMangsaByIdBencana(Request $request){

        $jumlahBelumDibayar = DB::table('tbl_mangsa_wang_ihsan')
        ->where('id_bencana', $request->id_bencana)
        ->where('id_jenis_bwi', $request->id_jenis_bwi)
        ->where('id_daerah', $request->id_daerah)
        ->where('status_mangsa_wang_ihsan', 1)
        ->select(DB::raw('sum(jumlah) as jumlah_belum_dibayar'), DB::raw('count(id) as bil_belum_dibayar'))
        ->get();

        $jumlahDibayar = DB::table('tbl_mangsa_wang_ihsan')
        ->where('id_bencana', $request->id_bencana)
        ->where('id_jenis_bwi', $request->id_jenis_bwi)
        ->where('id_daerah', $request->id_daerah)
        ->where('status_mangsa_wang_ihsan', 2)
        ->select(DB::raw('sum(jumlah) as jumlah_dibayar'), DB::raw('count(id) as bil_dibayar'))
        ->get();

        $jumlahDipulangkan = DB::table('tbl_mangsa_wang_ihsan')
        ->where('id_bencana', $request->id_bencana)
        ->where('id_jenis_bwi', $request->id_jenis_bwi)
        ->where('id_daerah', $request->id_daerah)
        ->where('status_mangsa_wang_ihsan', 3)
        ->select(DB::raw('sum(jumlah_dipulangkan) as jumlah_dipulangkan'), DB::raw('count(id) as bil_dipulangkan'))
        ->get();

        return response()->json([
            'jumlah_belum_dibayar'=>$jumlahBelumDibayar->pluck('jumlah_belum_dibayar')->first(),
            'bil_belum_dibayar'=>$jumlahBelumDibayar->pluck('bil_belum_dibayar')->first(),
            'jumlah_dibayar'=>$jumlahDibayar->pluck('jumlah_dibayar')->first(),
            'bil_dibayar'=>$jumlahDibayar->pluck('bil_dibayar')->first(),
            'jumlah_dipulangkan'=>$jumlahDipulangkan->pluck('jumlah_dipulangkan')->first(),
            'bil_dipulangkan'=>$jumlahDipulangkan->pluck('bil_dipulangkan')->first(),
        ], 200);
    }

    public function getMangsaWangIhsanForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'tarikh_serahan', 'jumlah', 'jumlah_dipulangkan', 'tarikh_dipulangkan',
            'id_sumber_dana', 'status_mangsa_wang_ihsan', 'sebab_hapus', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_jenis_bwi', 'nama_bencana', 'tarikh_bencana'
        ];

        $mangsaWangIhsan = DB::table('tbl_mangsa_wang_ihsan')
        ->join('ref_bencana', 'tbl_mangsa_wang_ihsan.id_bencana', 'ref_bencana.id')
        ->where('tbl_mangsa_wang_ihsan.id', $request->id)
        ->select($columns)
        ->first();

        return response()->json(['mangsa_wang_ihsan' => $mangsaWangIhsan], 200);
    }

    public function multipleCreateMangsaBwi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mangsaBwi.id_bencana' => 'required|numeric',
            'mangsaBwi.id_agensi_bantuan' => 'required|numeric',
            'mangsaBwi.jumlah' => 'required',
            'mangsaBwi.status_mangsa_wang_ihsan' => 'required',
            'id_mangsa' => 'required|array|min:1'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();
        $idMangsaBwi = $request->id_mangsa;
        $mangsaBwi = $request->mangsaBwi;

        try {
            DB::beginTransaction();

            foreach ($idMangsaBwi as $mangsa_bwi) {
                $mangsa = Mangsa::where('id', $mangsa_bwi)->first();
                $mangsaBencana = MangsaBencana::where('id_mangsa', $mangsa_bwi)->where('id_bencana', $mangsaBwi['id_bencana'])->first();

                if($mangsaBencana){
                    $mangsaWangIhsan = MangsaWangIhsan::create([
                        'id_bencana' => $mangsaBwi['id_bencana'],
                        'id_mangsa' => $mangsa_bwi,
                        'id_agensi_bantuan' => $mangsaBwi['id_agensi_bantuan'],
                        'tarikh_serahan' => $mangsaBwi['tarikh_serahan'] ?? null,
                        'jumlah' => $mangsaBwi['jumlah'],
                        'id_jenis_bwi' => $mangsaBwi['id_jenis_bwi'],
                        'status_mangsa_wang_ihsan' => $mangsaBwi['status_mangsa_wang_ihsan'],
                        'id_pengguna_cipta' => $user->id,
                        'tarikh_cipta' => Carbon::now(),
                        'id_agensi' => $user->id_agensi,
                        'id_negeri' => $mangsa->id_negeri,
                        'id_daerah' => $mangsa->id_daerah,
                    ]);

                    $mangsaWangIhsan->save();
                }else{
                    $bencana = RefBencana::where('id', $mangsaBwi['id_bencana'])->first();
                    return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Belum Didaftarkan Di Dalam Maklumat Bencana Bagi Mangsa $mangsa->nama ($mangsa->no_kp)"], 200);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pendaftaran Bantuan Wang Ihsan Berjaya Disimpan'], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaWangIhsan = $this->update($request);
        } else {
            $mangsaWangIhsan = $this->create($request);
        }

        return $mangsaWangIhsan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'id_agensi_bantuan' => 'required|numeric',
            'jumlah' => 'required',
            'status_mangsa_wang_ihsan' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $mangsa = Mangsa::where('id', $request->id_mangsa)->first();

            $mangsaWangIhsan = MangsaWangIhsan::create([
                'id_bencana' => $request->id_bencana,
                'id_mangsa' => $request->id_mangsa,
                'id_agensi_bantuan' => $request->id_agensi_bantuan,
                'tarikh_serahan' => $request->tarikh_serahan,
                'jumlah' => $request->jumlah,
                'id_jenis_bwi' => $request->id_jenis_bwi,
                'status_mangsa_wang_ihsan' => $request->status_mangsa_wang_ihsan,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now(),
                'id_agensi' => $user->id_agensi,
                'id_negeri' => $mangsa->id_negeri,
                'id_daerah' => $mangsa->id_daerah,
            ]);

            $mangsaWangIhsan->save();

            if($mangsaWangIhsan->status_mangsa_wang_ihsan == 3){
                $mangsaWangIhsan->jumlah_dipulangkan = $mangsaWangIhsan->jumlah;
                $mangsaWangIhsan->tarikh_dipulangkan = Carbon::now();

                $bwi = DB::table('tbl_tabung_bwi')
                ->join('tbl_tabung_bwi_kawasan', 'tbl_tabung_bwi.id', 'tbl_tabung_bwi_kawasan.id_tabung_bwi')
                ->where('id_bencana', $mangsaWangIhsan->id_bencana)
                ->where('id_jenis_bwi', $mangsaWangIhsan->id_jenis_bwi)
                ->where('id_daerah', $mangsaWangIhsan->id_daerah)
                ->first();

                if($bwi){
                    $mangsaWangIhsan->id_dipulangkan = 1;

                    $bwiBayaran = DB::table('tbl_tabung_bwi_bayaran')
                    ->where('id_tabung_bwi', $bwi->id_tabung_bwi)
                    ->select('id_kelulusan')
                    ->first();

                    $kelulusan = TabungKelulusan::where('id', $bwiBayaran->id_kelulusan)->first();
                    $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

                    $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $mangsaWangIhsan->jumlah_dipulangkan;
                    $kelulusan->jumlah_dipulangkan = $kelulusan->jumlah_dipulangkan + $mangsaWangIhsan->jumlah_dipulangkan;
                    $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $mangsaWangIhsan->jumlah_dipulangkan;
                    $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $mangsaWangIhsan->jumlah_dipulangkan;

                    $kelulusan->save();
                    $tabung->save();
                }else{
                    $mangsaWangIhsan->id_dipulangkan = 2;
                }

                $mangsaWangIhsan->save();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pendaftaran Bantuan Wang Ihsan Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'id_agensi_bantuan' => 'required|numeric',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaWangIhsan = MangsaWangIhsan::where('id', $request->id)->first();
        try {
            DB::beginTransaction();

        $bwi = DB::table('tbl_tabung_bwi')
            ->join('tbl_tabung_bwi_kawasan', 'tbl_tabung_bwi.id', 'tbl_tabung_bwi_kawasan.id_tabung_bwi')
            ->where('id_bencana', $mangsaWangIhsan->id_bencana)
            ->where('id_jenis_bwi', $mangsaWangIhsan->id_jenis_bwi)
            ->where('id_daerah', $mangsaWangIhsan->id_daerah)
            ->first();

        if($mangsaWangIhsan->status_mangsa_wang_ihsan == 3 && $request->status_mangsa_wang_ihsan == 2){
            if($mangsaWangIhsan->id_dipulangkan == 2){
                $mangsaWangIhsan->id_dipulangkan = 1;
            }else{
            $mangsaWangIhsan->id_dipulangkan = null;
            $mangsaWangIhsan->jumlah_dipulangkan = 0;

            $bwiBayaran = DB::table('tbl_tabung_bwi_bayaran')
                ->where('id_tabung_bwi', $bwi->id_tabung_bwi)
                ->select('id_kelulusan')
                ->first();

            $kelulusan = TabungKelulusan::where('id', $bwiBayaran->id_kelulusan)->first();
            $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $mangsaWangIhsan->jumlah;
            $kelulusan->jumlah_dipulangkan = $kelulusan->jumlah_dipulangkan - $mangsaWangIhsan->jumlah;
            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $mangsaWangIhsan->jumlah;
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $mangsaWangIhsan->jumlah;

            $kelulusan->save();
            $tabung->save();
            }
        }

        if($mangsaWangIhsan->status_mangsa_wang_ihsan != $request->status_mangsa_wang_ihsan && $request->status_mangsa_wang_ihsan == 3){
            $mangsaWangIhsan->jumlah_dipulangkan = $mangsaWangIhsan->jumlah;
            $mangsaWangIhsan->tarikh_dipulangkan = Carbon::now();

            if($bwi){
                $mangsaWangIhsan->id_dipulangkan = 1;

                $bwiBayaran = DB::table('tbl_tabung_bwi_bayaran')
                    ->where('id_tabung_bwi', $bwi->id_tabung_bwi)
                    ->select('id_kelulusan')
                    ->first();

                $kelulusan = TabungKelulusan::where('id', $bwiBayaran->id_kelulusan)->first();
                $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

                $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $mangsaWangIhsan->jumlah_dipulangkan;
                $kelulusan->jumlah_dipulangkan = $kelulusan->jumlah_dipulangkan + $mangsaWangIhsan->jumlah_dipulangkan;
                $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $mangsaWangIhsan->jumlah_dipulangkan;
                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $mangsaWangIhsan->jumlah_dipulangkan;

                $kelulusan->save();
                $tabung->save();
            }else{
                $mangsaWangIhsan->id_dipulangkan = 2;
            }
        }

        $mangsaWangIhsan->id_bencana = $request->id_bencana;
        $mangsaWangIhsan->id_mangsa = $request->id_mangsa;
        $mangsaWangIhsan->id_agensi_bantuan = $request->id_agensi_bantuan;
        $mangsaWangIhsan->tarikh_serahan = $request->tarikh_serahan;
        $mangsaWangIhsan->jumlah = $request->jumlah;
        $mangsaWangIhsan->id_jenis_bwi = $request->id_jenis_bwi;
        $mangsaWangIhsan->status_mangsa_wang_ihsan = $request->status_mangsa_wang_ihsan;
        $mangsaWangIhsan->id_pengguna_kemaskini = JWTAuth::user()->id;
        $mangsaWangIhsan->tarikh_kemaskini = Carbon::now();

        $mangsaWangIhsan->save();
        DB::commit();
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json($e->getTrace(), 500);
    }
    return response()->json(['message' => 'Bantuan Wang Ihsan Berjaya Di Kemaskini!'], 200);
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

        $bantuanWangIhsan = MangsaWangIhsan::where('id', $request->id)->first();

        $bantuanWangIhsan->delete();

        return response()->json(["message" => "Bantuan Wang Ihsan Berjaya Dibuang"], 200);
    }
}
