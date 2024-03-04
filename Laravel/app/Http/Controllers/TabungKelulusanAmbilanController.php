<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungKelulusan;
use App\Models\TabungKelulusanAmbilan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungKelulusanAmbilanController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterYear = $request->filterYear ?? Carbon::now()->year;;
        $filterIdKelulusan = $request->filterIdKelulusan;

        $columns = [
            'id', 'id_tabung_kelulusan', 'id_tabung', 'tarikh_cipta', 'baki_jumlah_siling_semasa', 'jumlah', 'baki_jumlah_siling_baharu', 'jenis_transaksi', 'catatan', 'id_pengguna_cipta'
        ];

        $data = DB::table('tbl_tabung_kelulusan_ambilan')
            ->where('id_tabung_kelulusan', $filterIdKelulusan)
            ->select($columns)
            ->where(DB::raw('EXTRACT(YEAR from tarikh_cipta)'), '=', $filterYear)
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

    public function getTabungKelulusanAmbilanForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungKelulusanAmbilan = TabungKelulusanAmbilan::where('id', $request->id)->first();
        return response()->json(['tabung_kelulusan_ambilan' => $tabungKelulusanAmbilan], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $tabungKelulusanAmbilan = $this->update($request);
        } else {
            $tabungKelulusanAmbilan = $this->create($request);
        }

        return $tabungKelulusanAmbilan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_tabung_kelulusan' => 'required',
            'id_tabung' => 'required',
            'jumlah' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabung = Tabung::where('id', $request->id_tabung)->first();
        $kelulusan = TabungKelulusan::where('id', $request->id_tabung_kelulusan)->first();

        try {
            DB::beginTransaction();

            if($request->jumlah <= $kelulusan->baki_jumlah_siling){
                $tabungKelulusanAmbilan = TabungKelulusanAmbilan::create([
                    'id_tabung_kelulusan' => $request->id_tabung_kelulusan,
                    'id_tabung' => $request->id_tabung,
                    'jenis_transaksi' => 1,
                    'jumlah' => $request->jumlah,
                    'catatan' => $request->catatan,
                    'baki_jumlah_siling_semasa' => $kelulusan->baki_jumlah_siling,
                    'tarikh_cipta' => Carbon::now(),
                    'id_pengguna_cipta' => JWTAuth::user()->id
                ]);

                $tabungKelulusanAmbilan->save();

                $tabung->peruntukan = $tabung->peruntukan - $request->jumlah;
                $tabung->save();

                $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $tabungKelulusanAmbilan->jumlah;
                $kelulusan->save();

                $tabungKelulusanAmbilan->baki_jumlah_siling_baharu = $kelulusan->baki_jumlah_siling;
                $tabungKelulusanAmbilan->save();

            }else{
                return response()->json(['message' => 'Jumlah Peruntukan Diambil Melebihi Baki Kelulusan'], 200);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Peruntukan Diambil Berjaya'], 200);
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

        $tabungKelulusanAmbilan = TabungKelulusanAmbilan::where('id', $request->id)->first();
        $tabung = Tabung::where('id', $request->id_tabung)->first();
        $kelulusan = TabungKelulusan::where('id', $request->id_tabung_kelulusan)->first();

        if($tabungKelulusanAmbilan->jumlah != $request->jumlah){
            $tabung->peruntukan = $tabung->peruntukan + $tabungKelulusanAmbilan->jumlah;
            $tabung->peruntukan = $tabung->peruntukan - $request->jumlah;
            $tabung->save();

            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $tabungKelulusanAmbilan->jumlah;
            if($request->jumlah > $kelulusan->baki_jumlah_siling){
                return response()->json(['message' => 'Jumlah Peruntukan Diambil Melebihi Baki Kelulusan'], 200);
            }
            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $request->jumlah;
            $kelulusan->save();

            $tabungKelulusanAmbilan->baki_jumlah_siling_baharu = $kelulusan->baki_jumlah_siling;
            $tabungKelulusanAmbilan->save();

            $tabungKelulusanAmbilan->jumlah = $request->jumlah;
        }

        $tabungKelulusanAmbilan->save();

        return response()->json(['message' => 'Peruntukan Diambil Berjaya Dikemaskini'], 200);
    }
}
