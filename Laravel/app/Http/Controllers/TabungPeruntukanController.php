<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungPeruntukan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungPeruntukanController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_peruntukan.id asc';
        $filter = $request->filter;

        $columns = [
            'tbl_tabung_peruntukan.id', 'id_tabung', 'nama_peruntukan', 'tarikh_peruntukan', 'no_rujukan',
            'jumlah', 'tbl_tabung_peruntukan.catatan', 'nama'
        ];

        $data = DB::table('tbl_tabung_peruntukan')
            ->join('tbl_pengguna', 'tbl_tabung_peruntukan.id_pengguna_cipta', 'tbl_pengguna.id')
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

    public function getPeruntukanByIdTabung(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $validator = Validator::make($request->all(), [
            'idTabung' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'tbl_tabung_peruntukan.id', 'id_tabung', 'nama_peruntukan', 'tarikh_peruntukan', 'no_rujukan',
            'id_sumber_peruntukan', 'sumber_peruntukan_lain', 'jumlah', 'tbl_tabung_peruntukan.catatan', 'nama'
        ];

        $data = DB::table('tbl_tabung_peruntukan')
            ->join('tbl_pengguna', 'tbl_tabung_peruntukan.id_pengguna_cipta', 'tbl_pengguna.id')
            ->select($columns)
            ->where('id_tabung', $request->idTabung)
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

    public function getTabungPeruntukanForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungPeruntukan = TabungPeruntukan::where('id', $request->id)->first();
        return response()->json(['tabung_peruntukan' => $tabungPeruntukan], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $tabungPeruntukan = $this->update($request);
        } else {
            $tabungPeruntukan = $this->create($request);
        }

        return $tabungPeruntukan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'nama_peruntukan' => 'required',
            'tarikh_peruntukan' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $generate = new GenerateController;
        $running_no = $generate->getDanaTambahanRunningNo();
        $user = JWTAuth::user();

        try {
            DB::beginTransaction();

            $tabungPeruntukan = TabungPeruntukan::create([
                'id_tabung' => $request->id_tabung,
                'nama_peruntukan' => $request->nama_peruntukan,
                'tarikh_peruntukan' => $request->tarikh_peruntukan,
                'no_rujukan' => $running_no,
                'jumlah' => $request->jumlah,
                'catatan' => $request->catatan,
                'id_jenis_peruntukan' => 2,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now()
            ]);

            $tabungPeruntukan->save();

            $tabung = Tabung::where('id', $tabungPeruntukan->id_tabung)->first();

            $tabung->jumlah_keseluruhan = $tabung->jumlah_keseluruhan + $tabungPeruntukan->jumlah;
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $tabungPeruntukan->jumlah;
            $tabung->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($tabungPeruntukan, 200);
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

        $tabung = Tabung::where('id', $request->id_tabung)->first();
        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $tabungPeruntukan = TabungPeruntukan::where('id', $request->id)->first();

            if($request->jumlah_baru){
                $tabung->jumlah_keseluruhan = $tabung->jumlah_keseluruhan - $request->jumlah_lama;
                $tabung->jumlah_keseluruhan = $tabung->jumlah_keseluruhan + $request->jumlah_baru;

                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $request->jumlah_lama;
                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $request->jumlah_baru;

                if($tabung->peruntukan <= $tabung->jumlah_keseluruhan){
                    $tabungPeruntukan->jumlah = $request->jumlah_baru;
                    $tabung->save();

                }else{
                    return response()->json(['message'=> 'Jumlah Kelulusan Melebihi Jumlah Keseluruhan Tabung'], 200);
                }
            }

            $tabungPeruntukan->nama_peruntukan = $request->nama_peruntukan;
            $tabungPeruntukan->tarikh_peruntukan = $request->tarikh_peruntukan;
            $tabungPeruntukan->catatan = $request->catatan;
            $tabungPeruntukan->id_pengguna_kemaskini = $user->id;
            $tabungPeruntukan->tarikh_kemaskini = Carbon::now();

            $tabungPeruntukan->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message'=> 'Tambahan Dana Berjaya Dikemaskini'], 200);
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

        $peruntukan = TabungPeruntukan::where('id', $request->id)->first();
        $tabung = Tabung::where('id', $peruntukan->id_tabung)->first();

        $tabung->jumlah_keseluruhan = $tabung->jumlah_keseluruhan - $peruntukan->jumlah;
        $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $peruntukan->jumlah;

        if ($tabung->peruntukan <= $tabung->jumlah_keseluruhan) {
            $peruntukan->delete();
            $tabung->save();

            return response()->json(["message" => "Tambahan Dana Berjaya Dibuang"], 200);

        } else {
            return response()->json(["message" => "Jumlah Kelulusan Melebihi Jumlah Keseluruhan Tabung"], 200);
        }
    }
}
