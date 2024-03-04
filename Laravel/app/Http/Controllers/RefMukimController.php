<?php

namespace App\Http\Controllers;

use App\Models\RefMukim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefMukimController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'id', 'id_negeri', 'id_daerah', 'nama_mukim'
        ];

        $data = DB::table('ref_mukim')
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

    public function getRefMukimForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refMukim = RefMukim::where([['id', $request->id]])->first();
        return response()->json(['ref_mukim'=> $refMukim], 200);
    }

    public function getRefMukimForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'id_negeri', 'id_daerah', 'nama_mukim'
        ];

        $data = DB::table('ref_mukim')
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
            $refMukim = $this->update($request);
        }else{
            $refMukim = $this->create($request);
        }

        return $refMukim;
    }

    private function create($request){
        $request->validate([]);

        $refMukim = RefMukim::create([
            'id_negeri' => $request->id_negeri,
            'id_daerah' => $request->id_daerah,
            'nama_mukim' => $request->nama_mukim,

        ]);

        $refMukim->save();

        return response()->json($refMukim, 200);
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

        $refMukim = RefMukim::where([['id', $request->id]])->first();

        $refMukim->id = $request->id;
                $refMukim->id_negeri = $request->id_negeri;
                $refMukim->id_daerah = $request->id_daerah;
                $refMukim->nama_mukim = $request->nama_mukim;

        $refMukim->save();

        return response()->json($refMukim, 200);
    }
}
