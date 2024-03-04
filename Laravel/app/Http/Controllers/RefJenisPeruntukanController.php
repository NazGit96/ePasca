<?php

namespace App\Http\Controllers;

use App\Models\RefJenisPeruntukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefJenisPeruntukanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_jenis_peruntukan'
        ];

        $data = DB::table('ref_jenis_peruntukan')
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

    public function getRefJenisPeruntukanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refJenisPeruntukan = RefJenisPeruntukan::where('id', $request->id)->first();
        return response()->json(['ref_jenis_peruntukan'=> $refJenisPeruntukan], 200);
    }

    public function getRefJenisPeruntukanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_jenis_peruntukan'
        ];

        $data = DB::table('ref_jenis_peruntukan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refJenisPeruntukan = $this->update($request);
        }else{
            $refJenisPeruntukan = $this->create($request);
        }

        return $refJenisPeruntukan;
    }

    private function create($request){
        $request->validate([]);

        $refJenisPeruntukan = RefJenisPeruntukan::create([
            'nama_jenis_peruntukan' => $request->nama_jenis_peruntukan,

        ]);

        $refJenisPeruntukan->save();

        return response()->json($refJenisPeruntukan, 200);
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

        $refJenisPeruntukan = RefJenisPeruntukan::where('id', $request->id)->first();

        $refJenisPeruntukan->id = $request->id;
        $refJenisPeruntukan->nama_jenis_peruntukan = $request->nama_jenis_peruntukan;

        $refJenisPeruntukan->save();

        return response()->json($refJenisPeruntukan, 200);
    }
}
