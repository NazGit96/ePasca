<?php

namespace App\Http\Controllers;

use App\Models\RefSumberDana;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefSumberDanaController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_sumber_dana', 'ringkasan_sumber_dana', 'status_sumber_dana'
        ];

        $data = DB::table('ref_sumber_dana')
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
                    return $query->where('status_sumber_dana', $filterStatus);
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

    public function getRefSumberDanaForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refSumberDana = RefSumberDana::where([['id', $request->id]])->first();
        return response()->json(['ref_sumber_dana'=> $refSumberDana], 200);
    }

    public function getRefSumberDanaForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_sumber_dana', 'ringkasan_sumber_dana', 'status_sumber_dana'
        ];

        $data = DB::table('ref_sumber_dana')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_sumber_dana', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refSumberDana = $this->update($request);
        }else{
            $refSumberDana = $this->create($request);
        }

        return $refSumberDana;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $sumber_dana = DB::table('ref_sumber_dana')
            ->select('nama_sumber_dana')
            ->orderBy('nama_sumber_dana')
            ->get();

            foreach($sumber_dana as $item){
                if(strcasecmp($request->nama_sumber_dana, $item->nama_sumber_dana) == 0){
                    return response()->json(['message' => 'Nama Sumber Dana yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refSumberDana = RefSumberDana::create([
                'nama_sumber_dana' => $request->nama_sumber_dana,
                'ringkasan_sumber_dana' => $request->ringkasan_sumber_dana,
                'status_sumber_dana' => $request->status_sumber_dana,

            ]);

            $refSumberDana->save();

            DB::commit();
            return response()->json($refSumberDana);
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

            $sumber_dana = DB::table('ref_sumber_dana')
            ->select('nama_sumber_dana')
            ->orderBy('nama_sumber_dana')
            ->get();

            $refSumberDana = RefSumberDana::where([['id', $request->id]])->first();

            foreach($sumber_dana as $item){
                if((strcasecmp($request->nama_sumber_dana, $refSumberDana->nama_sumber_dana) != 0) && (strcasecmp($request->nama_sumber_dana, $item->nama_sumber_dana) == 0)){
                    return response()->json(['message' => 'Nama Sumber Dana yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refSumberDana->id = $request->id;
            $refSumberDana->nama_sumber_dana = $request->nama_sumber_dana;
            $refSumberDana->ringkasan_sumber_dana = $request->ringkasan_sumber_dana;
            $refSumberDana->status_sumber_dana = $request->status_sumber_dana;

            $refSumberDana->save();
            DB::commit();
            return response()->json($refSumberDana, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
