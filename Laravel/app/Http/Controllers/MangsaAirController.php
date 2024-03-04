<?php

namespace App\Http\Controllers;

use App\Models\MangsaAir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaAirController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_air.id', 'id_mangsa', 'nama', 'no_kp', 'id_hubungan', 'umur', 'pekerjaan',
            'status_mangsa_air', 'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi',
            'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus', 'nama_hubungan', 'tarikh_lahir', 'id_umur'
        ];

        $data = DB::table('tbl_mangsa_air')
            ->join('ref_hubungan', 'tbl_mangsa_air.id_hubungan', 'ref_hubungan.id')
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
            'tbl_mangsa_air.id', 'id_mangsa', 'nama', 'no_kp', 'id_hubungan', 'umur', 'pekerjaan',
            'status_mangsa_air', 'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi',
            'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus', 'nama_hubungan', 'tarikh_lahir', 'id_umur'
        ];

        $data = DB::table('tbl_mangsa_air')
            ->join('ref_hubungan', 'tbl_mangsa_air.id_hubungan', 'ref_hubungan.id')
            ->select($columns)
            ->where('id_mangsa', $request->idMangsa)
            ->where('status_mangsa_air', 2)
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

    public function getMangsaAirForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaAir = MangsaAir::where('id', $request->id)->first();
        return response()->json(['mangsa_air' => $mangsaAir], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaAir = $this->update($request);
        } else {
            $mangsaAir = $this->create($request);
        }

        return $mangsaAir;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_mangsa' => 'required|numeric',
            'nama' => 'required|max:80',
            'id_hubungan' => 'required|numeric',
            'tarikh_lahir' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            if($request->no_kp){
                $checkNoKp = MangsaAir::where('no_kp', 'ILIKE', '%' . $request->no_kp . '%')->first();

                if($checkNoKp){
                    return response()->json([
                        'message' => 'No. Kad Pengenalan Sudah Didaftarkan. Sila Masukkan No. Kad Pengenalan Lain'
                    ], 200);
                }
            }

            $mangsaAir = MangsaAir::create([
                'id_mangsa' => $request->id_mangsa,
                'nama' => $request->nama,
                'no_kp' => $request->no_kp,
                'id_hubungan' => $request->id_hubungan,
                'umur' => $request->umur,
                'pekerjaan' => $request->pekerjaan,
                'status_mangsa_air' => 2,
                'catatan' => $request->catatan,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now(),
                'id_agensi' => $user->id_agensi,
                'tarikh_lahir' => $request->tarikh_lahir,
                'id_umur' => $request->id_umur
            ]);

            $mangsaAir->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pendaftaran Ahli Isi Rumah Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_mangsa' => 'required|numeric',
            'nama' => 'required|max:80',
            'id_hubungan' => 'required|numeric',
            'tarikh_lahir' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaAir = MangsaAir::where('id', $request->id)->first();

        try {
            DB::beginTransaction();
            if($mangsaAir->no_kp != $request->no_kp && $request->no_kp != null){
                $checkNoKp = MangsaAir::where('no_kp', 'ILIKE', '%' . $request->no_kp . '%')->first();

                if($checkNoKp){
                    return response()->json([
                        'message' => 'No. Kad Pengenalan Sudah Didaftarkan. Sila Masukkan No. Kad Pengenalan Lain'
                    ], 200);
                }
            }

            $mangsaAir->id_mangsa = $request->id_mangsa;
            $mangsaAir->nama = $request->nama;
            $mangsaAir->no_kp = $request->no_kp;
            $mangsaAir->id_hubungan = $request->id_hubungan;
            $mangsaAir->umur = $request->umur;
            $mangsaAir->pekerjaan = $request->pekerjaan;
            $mangsaAir->status_mangsa_air = $request->status_mangsa_air;
            $mangsaAir->catatan = $request->catatan;
            $mangsaAir->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsaAir->tarikh_kemaskini = Carbon::now();
            $mangsaAir->tarikh_lahir = $request->tarikh_lahir;
            $mangsaAir->id_umur = $request->id_umur;

            $mangsaAir->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Ahli Isi Rumah Berjaya Di Kemaskini!'], 200);
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

        $mangsaAir = MangsaAir::where('id', $request->id)->first();
        $mangsaAir->delete();

        return response()->json(["message" => "Isi Rumah Berjaya Dibuang"], 200);
    }
}
