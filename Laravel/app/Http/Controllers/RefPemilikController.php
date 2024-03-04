<?php

namespace App\Http\Controllers;

use App\Models\RefPemilik;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefPemilikController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_pemilik', 'status_pemilik'
        ];

        $data = DB::table('ref_pemilik')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterStatus) {
                $query->when($filterStatus, function ($query, $filterStatus) {
                    return $query->where('status_pemilik', $filterStatus);
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

    public function getRefPemilikForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refPemilik = RefPemilik::where([['id', $request->id]])->first();
        return response()->json(['ref_pemilik'=> $refPemilik], 200);
    }

    public function getRefPemilikForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_pemilik', 'status_pemilik'
        ];

        $data = DB::table('ref_pemilik')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_pemilik', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refPemilik = $this->update($request);
        }else{
            $refPemilik = $this->create($request);
        }

        return $refPemilik;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $pemilik = DB::table('ref_pemilik')
            ->select('nama_pemilik')
            ->orderBy('nama_pemilik')
            ->get();

            foreach($pemilik as $item){
                if(strcasecmp($request->nama_pemilik, $item->nama_pemilik) == 0){
                    return response()->json(['message' => 'Nama Pemilik yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPemilik = RefPemilik::create([
                'nama_pemilik' => $request->nama_pemilik,
                'status_pemilik' => $request->status_pemilik,

            ]);

            $refPemilik->save();

            DB::commit();
            return response()->json($refPemilik);
                }catch (Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage()], 500);
            }
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

        try{

            DB::beginTransaction();

            $pemilik = DB::table('ref_pemilik')
            ->select('nama_pemilik')
            ->orderBy('nama_pemilik')
            ->get();

            $refPemilik = RefPemilik::where([['id', $request->id]])->first();

            foreach($pemilik as $item){
                if((strcasecmp($request->nama_pemilik, $refPemilik->nama_pemilik) != 0) && (strcasecmp($request->nama_pemilik, $item->nama_pemilik) == 0)){
                    return response()->json(['message' => 'Nama Pemilik yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPemilik->id = $request->id;
            $refPemilik->nama_pemilik = $request->nama_pemilik;
            $refPemilik->status_pemilik = $request->status_pemilik;

            $refPemilik->save();

            DB::commit();
            return response()->json($refPemilik, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
