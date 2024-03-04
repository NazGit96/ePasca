<?php

namespace App\Http\Controllers;

use App\Models\RefJenisPertanian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefJenisPertanianController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_jenis_pertanian', 'status_jenis_pertanian'
        ];

        $data = DB::table('ref_jenis_pertanian')
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

    public function getRefJenisPertanianForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refJenisPertanian = RefJenisPertanian::where([['id', $request->id]])->first();
        return response()->json(['ref_jenis_pertanian'=> $refJenisPertanian], 200);
    }

    public function getRefJenisPertanianForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_jenis_pertanian', 'status_jenis_pertanian'
        ];

        $data = DB::table('ref_jenis_pertanian')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_jenis_pertanian', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refJenisPertanian = $this->update($request);
        }else{
            $refJenisPertanian = $this->create($request);
        }

        return $refJenisPertanian;
    }

    private function create($request){
        $request->validate([]);

        $refJenisPertanian = RefJenisPertanian::create([
            'nama_jenis_pertanian' => $request->nama_jenis_pertanian,
            'status_jenis_pertanian' => $request->status_jenis_pertanian,

        ]);

        $refJenisPertanian->save();

        return response()->json($refJenisPertanian, 200);
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

        $refJenisPertanian = RefJenisPertanian::where([['id', $request->id]])->first();

        $refJenisPertanian->id = $request->id;
                $refJenisPertanian->nama_jenis_pertanian = $request->nama_jenis_pertanian;
                $refJenisPertanian->status_jenis_pertanian = $request->status_jenis_pertanian;

        $refJenisPertanian->save();

        return response()->json($refJenisPertanian, 200);
    }
}
