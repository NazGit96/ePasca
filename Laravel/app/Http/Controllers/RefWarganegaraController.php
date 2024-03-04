<?php

namespace App\Http\Controllers;

use App\Models\RefWarganegara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefWarganegaraController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'kod_warganegara', 'nama_warganegara', 'status_warganegara'
        ];

        $data = DB::table('ref_warganegara')
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

    public function getRefWarganegaraForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refWarganegara = RefWarganegara::where([['id', $request->id]])->first();
        return response()->json(['ref_warganegara'=> $refWarganegara], 200);
    }

    public function getRefWarganegaraForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'kod_warganegara', 'nama_warganegara', 'status_warganegara'
        ];

        $data = DB::table('ref_warganegara')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_warganegara', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refWarganegara = $this->update($request);
        }else{
            $refWarganegara = $this->create($request);
        }

        return $refWarganegara;
    }

    private function create($request){
        $request->validate([]);

        $refWarganegara = RefWarganegara::create([
            'kod_warganegara' => $request->kod_warganegara,
            'nama_warganegara' => $request->nama_warganegara,
            'status_warganegara' => $request->status_warganegara,
            
        ]);

        $refWarganegara->save();

        return response()->json($refWarganegara, 200);
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

        $refWarganegara = RefWarganegara::where([['id', $request->id]])->first();

        $refWarganegara->id = $request->id;
                $refWarganegara->kod_warganegara = $request->kod_warganegara;
                $refWarganegara->nama_warganegara = $request->nama_warganegara;
                $refWarganegara->status_warganegara = $request->status_warganegara;
                
        $refWarganegara->save();

        return response()->json($refWarganegara, 200);
    }
}
        