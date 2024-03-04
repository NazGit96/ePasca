<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungBayaranSkb;
use App\Models\TabungBayaranSkbBulanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungBayaranSkbBulananController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'tbl_tabung_bayaran_skb_bulanan.id', 'id_tabung_bayaran_skb', 'bulan', 'tahun', 'jumlah', 'id_bulan'
        ];

        $data = DB::table('tbl_tabung_bayaran_skb_bulanan')
            ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb', '=', 'tbl_tabung_bayaran_skb.id')
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

    public function getAllBulananbyIdSkb(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterSkb = $request->filterSkb;

        $columns = [
            'tbl_tabung_bayaran_skb_bulanan.id', 'id_tabung_bayaran_skb', 'bulan', 'tahun', 'jumlah', 'id_bulan'
        ];

        $data = DB::table('tbl_tabung_bayaran_skb_bulanan')
            ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb', '=', 'tbl_tabung_bayaran_skb.id')
            ->select($columns)
            ->where('id_tabung_bayaran_skb', $filterSkb)
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

    public function getTabungBayaranSkbBulananForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBayaranSkbBulanan = TabungBayaranSkbBulanan::where('id', $request->id)->first();
        return response()->json(['tabung_bayaran_skb_bulanan' => $tabungBayaranSkbBulanan], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $tabungBayaranSkbBulanan = $this->update($request);
        } else {
            $tabungBayaranSkbBulanan = $this->create($request);
        }

        return $tabungBayaranSkbBulanan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required',
            'id_tabung_bayaran_skb' => 'required',
            'id_tabung' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bayaranSkb = TabungBayaranSkb::where('id', $request->id_tabung_bayaran_skb)->first();
        $tabung = Tabung::where('id', $request->id_tabung)->first();

        try {
            DB::beginTransaction();

            if($request->jumlah <= $bayaranSkb->jumlah_baki_peruntukan){

                $tabungBayaranSkbBulanan = TabungBayaranSkbBulanan::create([
                    'id_tabung_bayaran_skb' => $request->id_tabung_bayaran_skb,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'jumlah' => $request->jumlah,
                    'id_bulan' => $request->id_bulan,
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now()
                ]);

                $tabungBayaranSkbBulanan->save();

                $bayaranSkb->jumlah_baki_peruntukan = $bayaranSkb->jumlah_baki_peruntukan - $tabungBayaranSkbBulanan->jumlah;
                $bayaranSkb->save();

                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $tabungBayaranSkbBulanan->jumlah;
                $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $tabungBayaranSkbBulanan->jumlah;
                $tabung->save();

            }else{
                return response()->json(['message'=> 'Jumlah Belanja Bulanan Melebihi Jumlah Baki Siling SKB'], 200);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message'=> 'Maklumat SKB Bulanan Berjaya Ditambah!'], 200);
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

        $tabungBayaranSkbBulanan = TabungBayaranSkbBulanan::where('id', $request->id)->first();
        $bayaranSkb = TabungBayaranSkb::where('id', $request->id_tabung_bayaran_skb)->first();
        $tabung = Tabung::where('id', $request->id_tabung)->first();

        try {
            DB::beginTransaction();

        $bayaranSkb->jumlah_baki_peruntukan = $bayaranSkb->jumlah_baki_peruntukan + $request->jumlah_lama;
        $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $request->jumlah_lama;
        $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $request->jumlah_lama;

        if($request->jumlah <= $bayaranSkb->jumlah_baki_peruntukan){

            $tabungBayaranSkbBulanan->id_tabung_bayaran_skb = $request->id_tabung_bayaran_skb;
            $tabungBayaranSkbBulanan->bulan = $request->bulan;
            $tabungBayaranSkbBulanan->tahun = $request->tahun;
            $tabungBayaranSkbBulanan->jumlah = $request->jumlah;
            $tabungBayaranSkbBulanan->id_bulan = $request->id_bulan;
            $tabungBayaranSkbBulanan->id_pengguna_kemaskini = JWTAuth::user()->id;
            $tabungBayaranSkbBulanan->tarikh_kemaskini = Carbon::now();

            $tabungBayaranSkbBulanan->save();

            $bayaranSkb->jumlah_baki_peruntukan = $bayaranSkb->jumlah_baki_peruntukan - $tabungBayaranSkbBulanan->jumlah;
            $bayaranSkb->save();

            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $tabungBayaranSkbBulanan->jumlah;
            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $tabungBayaranSkbBulanan->jumlah;
            $tabung->save();
        }else{
            return response()->json(['message'=> 'Jumlah Belanja Bulanan Melebihi Jumlah Baki Siling SKB'], 200);
        }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message'=> 'Maklumat SKB Bulanan Berjaya Dikemaskini!'], 200);
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

        $bayaranSkbBulanan = TabungBayaranSkbBulanan::where('id', $request->id)->first();
        $bayaranSkb = TabungBayaranSkb::where('id', $bayaranSkbBulanan->id_tabung_bayaran_skb)->first();

        $bayaranSkb->jumlah_baki_peruntukan = $bayaranSkb->jumlah_baki_peruntukan + $bayaranSkbBulanan->jumlah;
        $bayaranSkb->save();

        $bayaranSkbBulanan->delete();

        return response()->json(["message" => "Surat Kuasa Belanja Bulanan Berjaya Dibuang"], 200);
    }
}
