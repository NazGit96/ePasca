<?php

namespace App\Http\Controllers;

use App\Models\TabungBayaranSkbStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungBayaranSkbStatusController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'id_tabung_bayaran_skb', 'id_status_skb', 'catatan', 'tarikh_cipta', 'id_pengguna_cipta'
        ];

        $data = DB::table('tbl_tabung_bayaran_skb_status')
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

    public function getTabungBayaranSkbStatusForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBayaranSkbStatus = TabungBayaranSkbStatus::where('id', $request->id)->first();

        return response()->json(['tabungBayaranSkbStatus' => $tabungBayaranSkbStatus], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $tabungBayaranSkbStatus = $this->update($request);
        } else {
            $tabungBayaranSkbStatus = $this->create($request);
        }

        return $tabungBayaranSkbStatus;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_tabung_bayaran_skb' => 'required',
            'id_status_skb' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }


        try {
            DB::beginTransaction();

            $tabungBayaranSkbStatus = TabungBayaranSkbStatus::create([
                'id_tabung_bayaran_skb' => $request->id_tabung_bayaran_skb,
                'id_status_skb' => $request->id_status_skb,
                'catatan' => $request->catatan,
                'tarikh_cipta' => Carbon::now(),
                'id_pengguna_cipta' => JWTAuth::user()->id
            ]);

            $tabungBayaranSkbStatus->save();


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Status Berjaya'], 200);
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

        $tabungBayaranSkbStatus = TabungBayaranSkbStatus::where('id', $request->id)->first();

        $tabungBayaranSkbStatus->id_tabung_bayaran_skb = $request->id_tabung_bayaran_skb;
        $tabungBayaranSkbStatus->id_status_skb = $request->id_status_skb;
        $tabungBayaranSkbStatus->catatan = $request->catatan;

        $tabungBayaranSkbStatus->save();

        return response()->json($tabungBayaranSkbStatus, 200);
    }
}
