<?php

namespace App\Http\Controllers;

use App\Models\RefKadarBwi;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefKadarBwiController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nilai', 'status_bencana_bwi', 'tarikh_cipta', 'id_pengguna_cipta'
        ];

        $data = DB::table('ref_kadar_bwi')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterStatus) {
                $query->when($filterStatus, function ($query, $filterStatus) {
                    return $query->where('status_bencana_bwi', $filterStatus);
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
            'total_count'=>$totalCount,
            'items'=> $result
        ], 200);
    }

    public function getRefKadarBwiForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refKadarBwi = RefKadarBwi::where('id', $request->id)->first();
        return response()->json(['ref_kadar_bwi'=> $refKadarBwi], 200);
    }

    public function getRefKadarBwiForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nilai'
        ];

        $data = DB::table('ref_kadar_bwi')
            ->select($columns)
            ->where('status_bencana_bwi', 1)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_bencana_bwi', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refKadarBwi = $this->update($request);
        }else{
            $refKadarBwi = $this->create($request);
        }

        return $refKadarBwi;
    }

    private function create($request){
        $validator = Validator::make($request->all(), [
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

        $refKadarBwi = RefKadarBwi::create([
            'nilai' => $request->nilai,
            'status_bencana_bwi' => 1,
            'tarikh_cipta' => Carbon::now(),
            'id_pengguna_cipta' => JWTAuth::user()->id
        ]);

        $refKadarBwi->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json($refKadarBwi, 200);
    }

    private function update($request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refKadarBwi = RefKadarBwi::where('id', $request->id)->first();

        $refKadarBwi->nilai = $request->nilai;
        $refKadarBwi->status_bencana_bwi = $request->status_bencana_bwi;

        $refKadarBwi->save();

        return response()->json($refKadarBwi, 200);
    }
}
