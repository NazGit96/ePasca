<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungBayaranWaran;
use App\Models\TabungBayaranWaranBulanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungBayaranWaranBulananController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'tbl_tabung_bayaran_waran_bulanan.id', 'id_tabung_bayaran_waran', 'bulan', 'tahun', 'jumlah', 'id_bulan'
        ];

        $data = DB::table('tbl_tabung_bayaran_waran_bulanan')
            ->join('tbl_tabung_bayaran_waran', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran', '=', 'tbl_tabung_bayaran_waran.id')
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

    public function getAllBulananbyIdWaran(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterWaran = $request->filterWaran;

        $columns = [
            'tbl_tabung_bayaran_waran_bulanan.id', 'id_tabung_bayaran_waran', 'bulan', 'tahun', 'jumlah', 'id_bulan'
        ];

        $data = DB::table('tbl_tabung_bayaran_waran_bulanan')
            ->join('tbl_tabung_bayaran_waran', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran', '=', 'tbl_tabung_bayaran_waran.id')
            ->select($columns)
            ->where('id_tabung_bayaran_waran', $filterWaran)
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

    public function getTabungBayaranWaranBulananForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBayaranWaranBulanan = TabungBayaranWaranBulanan::where('id', $request->id)->first();
        return response()->json(['tabung_bayaran_waran_bulanan' => $tabungBayaranWaranBulanan], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $tabungBayaranWaranBulanan = $this->update($request);
        } else {
            $tabungBayaranWaranBulanan = $this->create($request);
        }

        return $tabungBayaranWaranBulanan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required',
            'id_tabung_bayaran_waran' => 'required',
            'id_tabung' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bayaranWaran = TabungBayaranWaran::where('id', $request->id_tabung_bayaran_waran)->first();
        $tabung = Tabung::where('id', $request->id_tabung)->first();

        try {
            DB::beginTransaction();

            if($request->jumlah <= $bayaranWaran->jumlah_baki_peruntukan){

                $tabungBayaranWaranBulanan = TabungBayaranWaranBulanan::create([
                    'id_tabung_bayaran_waran' => $request->id_tabung_bayaran_waran,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'jumlah' => $request->jumlah,
                    'id_bulan' => $request->id_bulan,
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now()
                ]);

                $tabungBayaranWaranBulanan->save();

                $bayaranWaran->jumlah_baki_peruntukan = $bayaranWaran->jumlah_baki_peruntukan - $tabungBayaranWaranBulanan->jumlah;
                $bayaranWaran->save();

                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $tabungBayaranWaranBulanan->jumlah;
                $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $tabungBayaranWaranBulanan->jumlah;
                $tabung->save();

            }else{
                return response()->json(['message'=> 'Jumlah Belanja Bulanan Melebihi Jumlah Baki Siling Waran'], 200);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message'=> 'Maklumat Waran Bulanan Berjaya Ditambah!'], 200);
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

        $tabungBayaranWaranBulanan = TabungBayaranWaranBulanan::where('id', $request->id)->first();
        $bayaranWaran = TabungBayaranWaran::where('id', $request->id_tabung_bayaran_waran)->first();
        $tabung = Tabung::where('id', $request->id_tabung)->first();

        try {
            DB::beginTransaction();

        $bayaranWaran->jumlah_baki_peruntukan = $bayaranWaran->jumlah_baki_peruntukan + $request->jumlah_lama;
        $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $request->jumlah_lama;
        $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $request->jumlah_lama;

        if($request->jumlah <= $bayaranWaran->jumlah_baki_peruntukan){

            $tabungBayaranWaranBulanan->id_tabung_bayaran_waran = $request->id_tabung_bayaran_waran;
            $tabungBayaranWaranBulanan->bulan = $request->bulan;
            $tabungBayaranWaranBulanan->tahun = $request->tahun;
            $tabungBayaranWaranBulanan->jumlah = $request->jumlah;
            $tabungBayaranWaranBulanan->id_bulan = $request->id_bulan;
            $tabungBayaranWaranBulanan->id_pengguna_kemaskini = JWTAuth::user()->id;
            $tabungBayaranWaranBulanan->tarikh_kemaskini = Carbon::now();

            $tabungBayaranWaranBulanan->save();

            $bayaranWaran->jumlah_baki_peruntukan = $bayaranWaran->jumlah_baki_peruntukan - $tabungBayaranWaranBulanan->jumlah;
            $bayaranWaran->save();

            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $tabungBayaranWaranBulanan->jumlah;
            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $tabungBayaranWaranBulanan->jumlah;
            $tabung->save();
        }else{
            return response()->json(['message'=> 'Jumlah Belanja Bulanan Melebihi Jumlah Baki Siling Waran'], 200);
        }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message'=> 'Maklumat Waran Bulanan Berjaya Dikemaskini!'], 200);
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

        $bayaranWaranBulanan = TabungBayaranWaranBulanan::where('id', $request->id)->first();
        $bayaranWaran = TabungBayaranWaran::where('id', $bayaranWaranBulanan->id_tabung_bayaran_waran)->first();

        $bayaranWaran->jumlah_baki_peruntukan = $bayaranWaran->jumlah_baki_peruntukan + $bayaranWaranBulanan->jumlah;
        $bayaranWaran->save();

        $bayaranWaranBulanan->delete();

        return response()->json(["message" => "Belanja Bulanan Waran Berjaya Dibuang"], 200);
    }
}
