<?php

namespace App\Http\Controllers;

use App\Models\MangsaBantuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaBantuanController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_bantuan.id', 'id_bencana', 'id_mangsa', 'nama_bantuan', 'id_sumber_dana',
            'sumber_dana_lain', 'id_agensi_bantuan', 'kos_bantuan', 'tarikh_bantuan',
            'tbl_mangsa_bantuan.catatan', 'status_mangsa_bantuan', 'id_pengguna_cipta', 'tarikh_cipta',
            'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus', 'nama_agensi', 'nama_bencana',  'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_bantuan')
            ->join('ref_bencana', 'tbl_mangsa_bantuan.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_bantuan.id_agensi_bantuan', 'ref_agensi.id')
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
            'tbl_mangsa_bantuan.id', 'id_bencana', 'id_mangsa', 'nama_bantuan', 'id_sumber_dana',
            'sumber_dana_lain', 'id_agensi_bantuan', 'kos_bantuan', 'tarikh_bantuan',
            'tbl_mangsa_bantuan.catatan', 'status_mangsa_bantuan', 'id_pengguna_cipta', 'tarikh_cipta',
            'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus', 'nama_agensi', 'nama_bencana',  'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_bantuan')
            ->join('ref_bencana', 'tbl_mangsa_bantuan.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_bantuan.id_agensi_bantuan', 'ref_agensi.id')
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

    public function getMangsaBantuanForEdit(Request $request)
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
            'tbl_mangsa_bantuan.id', 'id_bencana', 'id_mangsa', 'nama_bantuan', 'id_sumber_dana', 'sumber_dana_lain', 'id_agensi_bantuan',
            'kos_bantuan', 'tarikh_bantuan', 'tbl_mangsa_bantuan.catatan', 'status_mangsa_bantuan', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus', 'nama_bencana', 'tarikh_bencana'
        ];

        $mangsaBantuan = DB::table('tbl_mangsa_bantuan')
        ->join('ref_bencana', 'tbl_mangsa_bantuan.id_bencana', 'ref_bencana.id')
        ->where('tbl_mangsa_bantuan.id', $request->id)
        ->select($columns)
        ->first();

        return response()->json(['mangsa_bantuan' => $mangsaBantuan], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaBantuan = $this->update($request);
        } else {
            $mangsaBantuan = $this->create($request);
        }

        return $mangsaBantuan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'nama_bantuan' => 'required|max:255',
            'id_agensi_bantuan' => 'required|numeric',
            'kos_bantuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $mangsaBantuan = MangsaBantuan::create([
                'id_bencana' => $request->id_bencana,
                'id_mangsa' => $request->id_mangsa,
                'nama_bantuan' => $request->nama_bantuan,
                'id_sumber_dana' => $request->id_sumber_dana,
                'sumber_dana_lain' => $request->sumber_dana_lain,
                'id_agensi_bantuan' => $request->id_agensi_bantuan,
                'kos_bantuan' => $request->kos_bantuan,
                'tarikh_bantuan' => $request->tarikh_bantuan,
                'catatan' => $request->catatan,
                'status_mangsa_bantuan' => 2,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now(),
                'id_agensi' => $user->id_agensi
            ]);

            $mangsaBantuan->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        return response()->json(['message' => 'Pendaftaran Bantuan Lain Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'nama_bantuan' => 'required|max:255',
            'id_agensi_bantuan' => 'required|numeric',
            'kos_bantuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaBantuan = MangsaBantuan::where('id', $request->id)->first();
        try {
            DB::beginTransaction();
            $mangsaBantuan->id_bencana = $request->id_bencana;
            $mangsaBantuan->id_mangsa = $request->id_mangsa;
            $mangsaBantuan->nama_bantuan = $request->nama_bantuan;
            $mangsaBantuan->id_sumber_dana = $request->id_sumber_dana;
            $mangsaBantuan->sumber_dana_lain = $request->sumber_dana_lain;
            $mangsaBantuan->id_agensi_bantuan = $request->id_agensi_bantuan;
            $mangsaBantuan->kos_bantuan = $request->kos_bantuan;
            $mangsaBantuan->tarikh_bantuan = $request->tarikh_bantuan;
            $mangsaBantuan->catatan = $request->catatan;
            $mangsaBantuan->status_mangsa_bantuan = $request->status_mangsa_bantuan;
            $mangsaBantuan->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsaBantuan->tarikh_kemaskini = Carbon::now();

            $mangsaBantuan->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        return response()->json(['message' => 'Bantuan Lain Berjaya Di Kemaskini!'], 200);
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

        $bantuanLain = MangsaBantuan::where('id', $request->id)->first();

        $bantuanLain->delete();

        return response()->json(["message" => "Bantuan Lain Berjaya Dibuang"], 200);
    }
}
