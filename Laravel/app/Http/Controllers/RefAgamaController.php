<?php

namespace App\Http\Controllers;

use App\Models\RefAgama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefAgamaController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_agama', 'status_agama'
        ];

        $data = DB::table('ref_agama')
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

    public function getRefAgamaForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refAgama = RefAgama::where([['id', $request->id]])->first();
        return response()->json(['ref_agama'=> $refAgama], 200);
    }

    public function getRefAgamaForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_agama', 'status_agama'
        ];

        $data = DB::table('ref_agama')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_agama', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refAgama = $this->update($request);
        }else{
            $refAgama = $this->create($request);
        }

        return $refAgama;
    }

    private function create($request){
        $request->validate([]);

        $refAgama = RefAgama::create([
            'nama_agama' => $request->nama_agama,
            'status_agama' => $request->status_agama,

        ]);

        $refAgama->save();

        return response()->json($refAgama, 200);
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

        $refAgama = RefAgama::where([['id', $request->id]])->first();

        $refAgama->id = $request->id;
                $refAgama->nama_agama = $request->nama_agama;
                $refAgama->status_agama = $request->status_agama;

        $refAgama->save();

        return response()->json($refAgama, 200);
    }
}
