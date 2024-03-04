<?php

namespace App\Http\Controllers;

use App\Models\RefPelaksana;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefPelaksanaController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_pelaksana', 'status_pelaksana'
        ];

        $data = DB::table('ref_pelaksana')
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
                    return $query->where('status_pelaksana', $filterStatus);
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

    public function getRefPelaksanaForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refPelaksana = RefPelaksana::where([['id', $request->id]])->first();
        return response()->json(['ref_pelaksana'=> $refPelaksana], 200);
    }

    public function getRefPelaksanaForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_pelaksana', 'status_pelaksana'
        ];

        $data = DB::table('ref_pelaksana')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_pelaksana', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refPelaksana = $this->update($request);
        }else{
            $refPelaksana = $this->create($request);
        }

        return $refPelaksana;
    }

    private function create($request){
        $request->validate([]);

            try{

            DB::beginTransaction();

            $pelaksana = DB::table('ref_pelaksana')
            ->select('nama_pelaksana')
            ->orderBy('nama_pelaksana')
            ->get();

            foreach($pelaksana as $item){
                if(strcasecmp($request->nama_pelaksana, $item->nama_pelaksana) == 0){
                    return response()->json(['message' => 'Nama Pelaksana yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPelaksana = RefPelaksana::create([
                'nama_pelaksana' => $request->nama_pelaksana,
                'status_pelaksana' => $request->status_pelaksana,

            ]);

            $refPelaksana->save();

            DB::commit();
            return response()->json($refPelaksana);
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

            $pelaksana = DB::table('ref_pelaksana')
            ->select('nama_pelaksana')
            ->orderBy('nama_pelaksana')
            ->get();

            $refPelaksana = RefPelaksana::where([['id', $request->id]])->first();

            foreach($pelaksana as $item){
                if((strcasecmp($request->nama_pelaksana, $refPelaksana->nama_pelaksana) != 0) && (strcasecmp($request->nama_pelaksana, $item->nama_pelaksana) == 0)){
                    return response()->json(['message' => 'Nama Pelaksana yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPelaksana->id = $request->id;
            $refPelaksana->nama_pelaksana = $request->nama_pelaksana;
            $refPelaksana->status_pelaksana = $request->status_pelaksana;

            $refPelaksana->save();

            DB::commit();
            return response()->json($refPelaksana, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
