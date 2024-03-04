<?php

namespace App\Http\Controllers;

use App\Models\RefSektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefSektorController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_sektor', 'status_sektor'
        ];

        $data = DB::table('ref_sektor')
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

    public function getRefSektorForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refSektor = RefSektor::where([['id', $request->id]])->first();
        return response()->json(['ref_sektor'=> $refSektor], 200);
    }

    public function getRefSektorForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_sektor', 'status_sektor'
        ];

        $data = DB::table('ref_sektor')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_sektor', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refSektor = $this->update($request);
        }else{
            $refSektor = $this->create($request);
        }

        return $refSektor;
    }

    private function create($request){
        $request->validate([]);

        $refSektor = RefSektor::create([
            'nama_sektor' => $request->nama_sektor,
            'status_sektor' => $request->status_sektor,
            
        ]);

        $refSektor->save();

        return response()->json($refSektor, 200);
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

        $refSektor = RefSektor::where([['id', $request->id]])->first();

        $refSektor->id = $request->id;
                $refSektor->nama_sektor = $request->nama_sektor;
                $refSektor->status_sektor = $request->status_sektor;
                
        $refSektor->save();

        return response()->json($refSektor, 200);
    }
}
        