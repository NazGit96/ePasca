<?php

namespace App\Http\Controllers;

use App\Models\RefSumberPeruntukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefSumberPeruntukanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_sumber_peruntukan', 'status_sumber_peruntukan'
        ];

        $data = DB::table('ref_sumber_peruntukan')
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

    public function getRefSumberPeruntukanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refSumberPeruntukan = RefSumberPeruntukan::where([['id', $request->id]])->first();
        return response()->json(['ref_sumber_peruntukan'=> $refSumberPeruntukan], 200);
    }

    public function getRefSumberPeruntukanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_sumber_peruntukan', 'status_sumber_peruntukan'
        ];

        $data = DB::table('ref_sumber_peruntukan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_sumber_peruntukan', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refSumberPeruntukan = $this->update($request);
        }else{
            $refSumberPeruntukan = $this->create($request);
        }

        return $refSumberPeruntukan;
    }

    private function create($request){
        $request->validate([]);

        $refSumberPeruntukan = RefSumberPeruntukan::create([
            'nama_sumber_peruntukan' => $request->nama_sumber_peruntukan,
            'status_sumber_peruntukan' => $request->status_sumber_peruntukan,
            
        ]);

        $refSumberPeruntukan->save();

        return response()->json($refSumberPeruntukan, 200);
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

        $refSumberPeruntukan = RefSumberPeruntukan::where([['id', $request->id]])->first();

        $refSumberPeruntukan->id = $request->id;
                $refSumberPeruntukan->nama_sumber_peruntukan = $request->nama_sumber_peruntukan;
                $refSumberPeruntukan->status_sumber_peruntukan = $request->status_sumber_peruntukan;
                
        $refSumberPeruntukan->save();

        return response()->json($refSumberPeruntukan, 200);
    }
}
        