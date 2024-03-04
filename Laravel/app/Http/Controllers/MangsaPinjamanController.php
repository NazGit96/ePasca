<?php

namespace App\Http\Controllers;

use App\Models\MangsaPinjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaPinjamanController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_pinjaman.id', 'id_bencana', 'id_mangsa', 'tbl_mangsa_pinjaman.catatan', 'id_sektor', 'sektor',
            'jumlah_pinjaman', 'tarikh_mula', 'tempoh_pinjaman', 'id_sumber_dana',
            'id_agensi_bantuan', 'status_mangsa_pinjaman', 'sebab_hapus',
            'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini',
            'tarikh_kemaskini', 'nama_agensi', 'nama_bencana', 'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_pinjaman')
            ->join('ref_bencana', 'tbl_mangsa_pinjaman.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_pinjaman.id_agensi_bantuan', 'ref_agensi.id')
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
            'tbl_mangsa_pinjaman.id', 'id_bencana', 'id_mangsa', 'tbl_mangsa_pinjaman.catatan', 'id_sektor', 'sektor',
            'jumlah_pinjaman', 'tarikh_mula', 'tempoh_pinjaman', 'id_sumber_dana',
            'id_agensi_bantuan', 'status_mangsa_pinjaman', 'sebab_hapus',
            'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini',
            'tarikh_kemaskini', 'nama_agensi', 'nama_bencana',  'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_pinjaman')
            ->join('ref_bencana', 'tbl_mangsa_pinjaman.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_pinjaman.id_agensi_bantuan', 'ref_agensi.id')
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

    public function getMangsaPinjamanForEdit(Request $request)
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
            'tbl_mangsa_pinjaman.id', 'id_bencana', 'id_mangsa', 'tbl_mangsa_pinjaman.catatan', 'id_sektor', 'sektor', 'jumlah_pinjaman',
            'tarikh_mula', 'tempoh_pinjaman', 'id_sumber_dana', 'id_agensi_bantuan',
            'status_mangsa_pinjaman', 'sebab_hapus', 'id_pengguna_cipta', 'tarikh_cipta',
            'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'tarikh_bencana'
        ];

        $mangsaPinjaman = DB::table('tbl_mangsa_pinjaman')
        ->join('ref_bencana', 'tbl_mangsa_pinjaman.id_bencana', 'ref_bencana.id')
        ->where('tbl_mangsa_pinjaman.id', $request->id)
        ->select($columns)
        ->first();

        return response()->json(['mangsa_pinjaman' => $mangsaPinjaman], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaPinjaman = $this->update($request);
        } else {
            $mangsaPinjaman = $this->create($request);
        }

        return $mangsaPinjaman;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'id_sektor' => 'required|numeric',
            'jumlah_pinjaman' => 'required',
            'id_agensi_bantuan' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $mangsaPinjaman = MangsaPinjaman::create([
                'id_bencana' => $request->id_bencana,
                'id_mangsa' => $request->id_mangsa,
                'catatan' => $request->catatan,
                'id_sektor' => $request->id_sektor,
                'sektor' => $request->sektor,
                'jumlah_pinjaman' => $request->jumlah_pinjaman,
                'tarikh_mula' => $request->tarikh_mula,
                'tempoh_pinjaman' => $request->tempoh_pinjaman,
                'id_sumber_dana' => $request->id_sumber_dana,
                'id_agensi_bantuan' => $request->id_agensi_bantuan,
                'status_mangsa_pinjaman' => 2,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now(),
                'id_agensi' => $user->id_agensi
            ]);

            $mangsaPinjaman->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pendaftaran Pinjaman Khas Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'jumlah_pinjaman' => 'required',
            'id_agensi_bantuan' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaPinjaman = MangsaPinjaman::where('id', $request->id)->first();
        try {
            DB::beginTransaction();
            $mangsaPinjaman->id_bencana = $request->id_bencana;
            $mangsaPinjaman->id_mangsa = $request->id_mangsa;
            $mangsaPinjaman->catatan = $request->catatan;
            $mangsaPinjaman->id_sektor = $request->id_sektor;
            $mangsaPinjaman->sektor = $request->sektor;
            $mangsaPinjaman->jumlah_pinjaman = $request->jumlah_pinjaman;
            $mangsaPinjaman->tarikh_mula = $request->tarikh_mula;
            $mangsaPinjaman->tempoh_pinjaman = $request->tempoh_pinjaman;
            $mangsaPinjaman->id_sumber_dana = $request->id_sumber_dana;
            $mangsaPinjaman->id_agensi_bantuan = $request->id_agensi_bantuan;
            $mangsaPinjaman->status_mangsa_pinjaman = $request->status_mangsa_pinjaman;
            $mangsaPinjaman->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsaPinjaman->tarikh_kemaskini = Carbon::now();

            $mangsaPinjaman->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pinjaman Khas Berjaya Di Kemaskini!'], 200);
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

        $bantuanPinjaman = MangsaPinjaman::where('id', $request->id)->first();

        $bantuanPinjaman->delete();

        return response()->json(["message" => "Bantuan Pinjaman Khas Berjaya Dibuang"], 200);
    }
}
