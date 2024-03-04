<?php

namespace App\Http\Controllers;

use App\Models\MangsaRumah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaRumahController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_rumah.id', 'id_bencana', 'id_mangsa', 'id_jenis_bantuan', 'naik_taraf',
            'id_jenis_rumah', 'id_jenis_penempatan', 'id_status_kerosakan',
            'id_pemilik', 'id_sumber_dana', 'sumber_dana_lain', 'id_pelaksana',
            'pelaksana_lain', 'kontraktor', 'no_pkk', 'kos_anggaran', 'kos_sebenar',
            'tarikh_mula', 'tarikh_siap', 'peratus_kemajuan', 'id_status_kemajuan',
            'tbl_mangsa_rumah.catatan', 'geran_rumah', 'pemilik_tanah', 'id_tapak_rumah',
            'status_mangsa_rumah', 'sebab_hapus', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'nama_bantuan', 'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_rumah')
            ->join('ref_bencana', 'tbl_mangsa_rumah.id_bencana', 'ref_bencana.id')
            ->join('ref_bantuan', 'tbl_mangsa_rumah.id_jenis_bantuan', 'ref_bantuan.id')
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
            'tbl_mangsa_rumah.id', 'id_bencana', 'id_mangsa', 'id_jenis_bantuan', 'naik_taraf',
            'id_jenis_rumah', 'id_jenis_penempatan', 'id_status_kerosakan',
            'id_pemilik', 'id_sumber_dana', 'sumber_dana_lain', 'id_pelaksana',
            'pelaksana_lain', 'kontraktor', 'no_pkk', 'kos_anggaran', 'kos_sebenar',
            'tarikh_mula', 'tarikh_siap', 'peratus_kemajuan', 'id_status_kemajuan',
            'tbl_mangsa_rumah.catatan', 'geran_rumah', 'pemilik_tanah', 'id_tapak_rumah',
            'status_mangsa_rumah', 'sebab_hapus', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'nama_bantuan', 'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_rumah')
            ->join('ref_bencana', 'tbl_mangsa_rumah.id_bencana', 'ref_bencana.id')
            ->join('ref_bantuan', 'tbl_mangsa_rumah.id_jenis_bantuan', 'ref_bantuan.id')
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

    public function getMangsaRumahForEdit(Request $request)
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
            'tbl_mangsa_rumah.id', 'id_bencana', 'id_mangsa', 'id_jenis_bantuan', 'naik_taraf', 'id_jenis_rumah',
            'id_jenis_penempatan', 'id_status_kerosakan', 'id_pemilik', 'id_sumber_dana',
            'sumber_dana_lain', 'id_pelaksana', 'pelaksana_lain', 'kontraktor', 'no_pkk',
            'kos_anggaran', 'kos_sebenar', 'tarikh_mula', 'tarikh_siap', 'peratus_kemajuan',
            'id_status_kemajuan', 'tbl_mangsa_rumah.catatan', 'geran_rumah', 'pemilik_tanah', 'id_tapak_rumah',
            'status_mangsa_rumah', 'sebab_hapus', 'id_pengguna_cipta', 'tarikh_cipta',
            'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'tarikh_bencana'
        ];

        $mangsaRumah = DB::table('tbl_mangsa_rumah')
        ->join('ref_bencana', 'tbl_mangsa_rumah.id_bencana', 'ref_bencana.id')
        ->where('tbl_mangsa_rumah.id', $request->id)
        ->select($columns)
        ->first();

        return response()->json(['mangsa_rumah' => $mangsaRumah], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaRumah = $this->update($request);
        } else {
            $mangsaRumah = $this->create($request);
        }

        return $mangsaRumah;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'id_jenis_bantuan' => 'required|numeric',
            'id_pemilik' => 'required|numeric',
            'id_sumber_dana' => 'required|numeric',
            'kos_sebenar' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $mangsaRumah = MangsaRumah::create([
                'id_bencana' => $request->id_bencana,
                'id_mangsa' => $request->id_mangsa,
                'id_jenis_bantuan' => $request->id_jenis_bantuan,
                'naik_taraf' => $request->naik_taraf,
                'id_jenis_rumah' => $request->id_jenis_rumah,
                'id_jenis_penempatan' => $request->id_jenis_penempatan,
                'id_status_kerosakan' => $request->id_status_kerosakan,
                'id_pemilik' => $request->id_pemilik,
                'id_sumber_dana' => $request->id_sumber_dana,
                'sumber_dana_lain' => $request->sumber_dana_lain,
                'id_pelaksana' => $request->id_pelaksana,
                'pelaksana_lain' => $request->pelaksana_lain,
                'kontraktor' => $request->kontraktor,
                'no_pkk' => $request->no_pkk,
                'kos_anggaran' => $request->kos_anggaran,
                'kos_sebenar' => $request->kos_sebenar,
                'tarikh_mula' => $request->tarikh_mula,
                'tarikh_siap' => $request->tarikh_siap,
                'peratus_kemajuan' => $request->peratus_kemajuan,
                'id_status_kemajuan' => $request->id_status_kemajuan,
                'catatan' => $request->catatan,
                'geran_rumah' => $request->geran_rumah,
                'pemilik_tanah' => $request->pemilik_tanah,
                'id_tapak_rumah' => $request->id_tapak_rumah,
                'status_mangsa_rumah' => 2,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now(),
                'id_agensi' => $user->id_agensi
            ]);

            $mangsaRumah->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pendaftaran Bantuan Rumah Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'id_jenis_bantuan' => 'required|numeric',
            'id_pemilik' => 'required|numeric',
            'id_sumber_dana' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaRumah = MangsaRumah::where('id', $request->id)->first();

        try {
            DB::beginTransaction();
            $mangsaRumah->id_bencana = $request->id_bencana;
            $mangsaRumah->id_mangsa = $request->id_mangsa;
            $mangsaRumah->id_jenis_bantuan = $request->id_jenis_bantuan;
            $mangsaRumah->naik_taraf = $request->naik_taraf;
            $mangsaRumah->id_jenis_rumah = $request->id_jenis_rumah;
            $mangsaRumah->id_jenis_penempatan = $request->id_jenis_penempatan;
            $mangsaRumah->id_status_kerosakan = $request->id_status_kerosakan;
            $mangsaRumah->id_pemilik = $request->id_pemilik;
            $mangsaRumah->id_sumber_dana = $request->id_sumber_dana;
            $mangsaRumah->sumber_dana_lain = $request->sumber_dana_lain;
            $mangsaRumah->id_pelaksana = $request->id_pelaksana;
            $mangsaRumah->pelaksana_lain = $request->pelaksana_lain;
            $mangsaRumah->kontraktor = $request->kontraktor;
            $mangsaRumah->no_pkk = $request->no_pkk;
            $mangsaRumah->kos_anggaran = $request->kos_anggaran;
            $mangsaRumah->kos_sebenar = $request->kos_sebenar;
            $mangsaRumah->tarikh_mula = $request->tarikh_mula;
            $mangsaRumah->tarikh_siap = $request->tarikh_siap;
            $mangsaRumah->peratus_kemajuan = $request->peratus_kemajuan;
            $mangsaRumah->id_status_kemajuan = $request->id_status_kemajuan;
            $mangsaRumah->catatan = $request->catatan;
            $mangsaRumah->geran_rumah = $request->geran_rumah;
            $mangsaRumah->pemilik_tanah = $request->pemilik_tanah;
            $mangsaRumah->id_tapak_rumah = $request->id_tapak_rumah;
            $mangsaRumah->status_mangsa_rumah = $request->status_mangsa_rumah;
            $mangsaRumah->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsaRumah->tarikh_kemaskini = Carbon::now();
            $mangsaRumah->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Bantuan Rumah Berjaya Di Kemaskini!'], 200);
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

        $bantuanRumah = MangsaRumah::where('id', $request->id)->first();

        $bantuanRumah->delete();

        return response()->json(["message" => "Bantuan Rumah Berjaya Dibuang"], 200);
    }
}
