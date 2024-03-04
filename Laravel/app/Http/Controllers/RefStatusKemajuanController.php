<?php

namespace App\Http\Controllers;

use App\Models\RefStatusKemajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefStatusKemajuanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'status_kemajuan', 'status', 'kod_status_kemajuan'
        ];

        $data = DB::table('ref_status_kemajuan')
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

    public function getRefStatusKemajuanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refStatusKemajuan = RefStatusKemajuan::where([['id', $request->id]])->first();
        return response()->json(['ref_status_kemajuan'=> $refStatusKemajuan], 200);
    }

    public function getRefStatusKemajuanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'status_kemajuan', 'status', 'kod_status_kemajuan'
        ];

        $data = DB::table('ref_status_kemajuan')
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
            $refStatusKemajuan = $this->update($request);
        }else{
            $refStatusKemajuan = $this->create($request);
        }

        return $refStatusKemajuan;
    }

    private function create($request){
        $request->validate([]);

        $refStatusKemajuan = RefStatusKemajuan::create([
            'status_kemajuan' => $request->status_kemajuan,
            'status' => $request->status,
            'kod_status_kemajuan' => $request->kod_status_kemajuan,

        ]);

        $refStatusKemajuan->save();

        return response()->json($refStatusKemajuan, 200);
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

        $refStatusKemajuan = RefStatusKemajuan::where([['id', $request->id]])->first();

        $refStatusKemajuan->id = $request->id;
                $refStatusKemajuan->status_kemajuan = $request->status_kemajuan;
                $refStatusKemajuan->status = $request->status;
                $refStatusKemajuan->kod_status_kemajuan = $request->kod_status_kemajuan;

        $refStatusKemajuan->save();

        return response()->json($refStatusKemajuan, 200);
    }
}
