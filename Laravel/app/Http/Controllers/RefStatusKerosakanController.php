<?php

namespace App\Http\Controllers;

use App\Models\RefStatusKerosakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefStatusKerosakanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_status_kerosakan', 'status'
        ];

        $data = DB::table('ref_status_kerosakan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
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
            'total_count'=>$totalCount,
            'items'=> $result
        ], 200);
    }

    public function getRefStatusKerosakanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refStatusKerosakan = RefStatusKerosakan::where([['id', $request->id]])->first();
        return response()->json(['ref_status_kerosakan'=> $refStatusKerosakan], 200);
    }

    public function getRefStatusKerosakanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_status_kerosakan', 'status'
        ];

        $data = DB::table('ref_status_kerosakan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refStatusKerosakan = $this->update($request);
        }else{
            $refStatusKerosakan = $this->create($request);
        }

        return $refStatusKerosakan;
    }

    private function create($request){
        $request->validate([]);

        $refStatusKerosakan = RefStatusKerosakan::create([
            'nama_status_kerosakan' => $request->nama_status_kerosakan,
            'status' => $request->status,

        ]);

        $refStatusKerosakan->save();

        return response()->json($refStatusKerosakan, 200);
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

        $refStatusKerosakan = RefStatusKerosakan::where([['id', $request->id]])->first();

        $refStatusKerosakan->id = $request->id;
                $refStatusKerosakan->nama_status_kerosakan = $request->nama_status_kerosakan;
                $refStatusKerosakan->status = $request->status;

        $refStatusKerosakan->save();

        return response()->json($refStatusKerosakan, 200);
    }
}
