<?php

namespace App\Http\Controllers;

use App\Models\MangsaPertanian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaPertanianController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_pertanian.id', 'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'id_jenis_pertanian',
            'luas', 'luas_musnah', 'bilangan', 'bilangan_rosak', 'anggaran_nilai_rosak',
            'anggaran_nilai_bantuan', 'kos_bantuan', 'tarikh_bantuan', 'tbl_mangsa_pertanian.catatan',
            'status_mangsa_pertanian', 'sebab_hapus', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'nama_agensi',
            'nama_jenis_pertanian',  'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_pertanian')
            ->join('ref_bencana', 'tbl_mangsa_pertanian.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_pertanian.id_agensi_bantuan', 'ref_agensi.id')
            ->join('ref_jenis_pertanian', 'tbl_mangsa_pertanian.id_jenis_pertanian', 'ref_jenis_pertanian.id')
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

        $columns = [
            'tbl_mangsa_pertanian.id', 'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'id_jenis_pertanian',
            'luas', 'luas_musnah', 'bilangan', 'bilangan_rosak', 'anggaran_nilai_rosak',
            'anggaran_nilai_bantuan', 'kos_bantuan', 'tarikh_bantuan', 'tbl_mangsa_pertanian.catatan',
            'status_mangsa_pertanian', 'sebab_hapus', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'nama_agensi',
            'nama_jenis_pertanian',  'tarikh_bencana'
        ];

        $validator = Validator::make($request->all(), [
            'idMangsa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $data = DB::table('tbl_mangsa_pertanian')
            ->join('ref_bencana', 'tbl_mangsa_pertanian.id_bencana', 'ref_bencana.id')
            ->join('ref_agensi', 'tbl_mangsa_pertanian.id_agensi_bantuan', 'ref_agensi.id')
            ->join('ref_jenis_pertanian', 'tbl_mangsa_pertanian.id_jenis_pertanian', 'ref_jenis_pertanian.id')
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

    public function getMangsaPertanianForEdit(Request $request)
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
            'tbl_mangsa_pertanian.id', 'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'id_jenis_pertanian', 'luas', 'luas_musnah',
            'bilangan', 'bilangan_rosak', 'anggaran_nilai_rosak', 'anggaran_nilai_bantuan', 'kos_bantuan',
            'tarikh_bantuan', 'tbl_mangsa_pertanian.catatan', 'status_mangsa_pertanian', 'sebab_hapus', 'id_pengguna_cipta',
            'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'tarikh_bencana'
        ];

        $mangsaPertanian = DB::table('tbl_mangsa_pertanian')
        ->join('ref_bencana', 'tbl_mangsa_pertanian.id_bencana', 'ref_bencana.id')
        ->where('tbl_mangsa_pertanian.id', $request->id)
        ->select($columns)
        ->first();

        return response()->json(['mangsa_pertanian' => $mangsaPertanian], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaPertanian = $this->update($request);
        } else {
            $mangsaPertanian = $this->create($request);
        }

        return $mangsaPertanian;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'id_agensi_bantuan' => 'required|numeric',
            'id_jenis_pertanian' => 'required|numeric',
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
            $mangsaPertanian = MangsaPertanian::create([
                'id_bencana' => $request->id_bencana,
                'id_mangsa' => $request->id_mangsa,
                'id_agensi_bantuan' => $request->id_agensi_bantuan,
                'id_jenis_pertanian' => $request->id_jenis_pertanian,
                'luas' => $request->luas,
                'luas_musnah' => $request->luas_musnah,
                'bilangan' => $request->bilangan,
                'bilangan_rosak' => $request->bilangan_rosak,
                'anggaran_nilai_rosak' => $request->anggaran_nilai_rosak,
                'anggaran_nilai_bantuan' => $request->anggaran_nilai_bantuan,
                'kos_bantuan' => $request->kos_bantuan,
                'tarikh_bantuan' => $request->tarikh_bantuan,
                'catatan' => $request->catatan,
                'status_mangsa_pertanian' => 2,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now(),
                'id_agensi' => $user->id_agensi
            ]);

            $mangsaPertanian->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pendaftaran Bantuan Pertanian Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'id_agensi_bantuan' => 'required|numeric',
            'id_jenis_pertanian' => 'required|numeric',
            'kos_bantuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaPertanian = MangsaPertanian::where('id', $request->id)->first();

        try {
            DB::beginTransaction();
            $mangsaPertanian->id_bencana = $request->id_bencana;
            $mangsaPertanian->id_mangsa = $request->id_mangsa;
            $mangsaPertanian->id_agensi_bantuan = $request->id_agensi_bantuan;
            $mangsaPertanian->id_jenis_pertanian = $request->id_jenis_pertanian;
            $mangsaPertanian->luas = $request->luas;
            $mangsaPertanian->luas_musnah = $request->luas_musnah;
            $mangsaPertanian->bilangan = $request->bilangan;
            $mangsaPertanian->bilangan_rosak = $request->bilangan_rosak;
            $mangsaPertanian->anggaran_nilai_rosak = $request->anggaran_nilai_rosak;
            $mangsaPertanian->anggaran_nilai_bantuan = $request->anggaran_nilai_bantuan;
            $mangsaPertanian->kos_bantuan = $request->kos_bantuan;
            $mangsaPertanian->tarikh_bantuan = $request->tarikh_bantuan;
            $mangsaPertanian->catatan = $request->catatan;
            $mangsaPertanian->status_mangsa_pertanian = $request->status_mangsa_pertanian;
            $mangsaPertanian->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsaPertanian->tarikh_kemaskini = Carbon::now();

            $mangsaPertanian->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Bantuan Pertanian Berjaya Di Kemaskini!'], 200);
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

        $bantuanPertanian = MangsaPertanian::where('id', $request->id)->first();

        $bantuanPertanian->delete();

        return response()->json(["message" => "Bantuan Pertanian Berjaya Dibuang"], 200);
    }
}
