<?php

namespace App\Http\Controllers;

use App\Models\RefKategoriBayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefKategoriBayaranController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_kategori_bayaran', 'status_kategori_bayaran'
        ];

        $data = DB::table('ref_kategori_bayaran')
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

    public function getRefKategoriBayaranForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refKategoriBayaran = RefKategoriBayaran::where('id', $request->id)->first();
        return response()->json(['ref_kategori_bayaran'=> $refKategoriBayaran], 200);
    }

    public function getRefKategoriBayaranForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_kategori_bayaran', 'status_kategori_bayaran'
        ];

        $data = DB::table('ref_kategori_bayaran')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_kategori_bayaran', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refKategoriBayaran = $this->update($request);
        }else{
            $refKategoriBayaran = $this->create($request);
        }

        return $refKategoriBayaran;
    }

    private function create($request){
        $request->validate([]);

        $refKategoriBayaran = RefKategoriBayaran::create([
            'nama_kategori_bayaran' => $request->nama_kategori_bayaran,
            'status_kategori_bayaran' => $request->status_kategori_bayaran,

        ]);

        $refKategoriBayaran->save();

        return response()->json($refKategoriBayaran, 200);
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

        $refKategoriBayaran = RefKategoriBayaran::where('id', $request->id)->first();

        $refKategoriBayaran->nama_kategori_bayaran = $request->nama_kategori_bayaran;
        $refKategoriBayaran->status_kategori_bayaran = $request->status_kategori_bayaran;

        $refKategoriBayaran->save();

        return response()->json($refKategoriBayaran, 200);
    }
}
