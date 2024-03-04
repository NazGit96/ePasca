<?php

namespace App\Http\Controllers;

use App\Models\RefNegeri;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefNegeriController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_negeri', 'kod_negeri', 'status_negeri'
        ];

        $data = DB::table('ref_negeri')
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
                    return $query->where('status_negeri', $filterStatus);
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

    public function getRefNegeriForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refNegeri = RefNegeri::where([['id', $request->id]])->first();
        return response()->json(['ref_negeri'=> $refNegeri], 200);
    }

    public function getRefNegeriForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_negeri', 'kod_negeri', 'status_negeri'
        ];

        $data = DB::table('ref_negeri')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_negeri', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refNegeri = $this->update($request);
        }else{
            $refNegeri = $this->create($request);
        }

        return $refNegeri;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $negeri = DB::table('ref_negeri')
            ->select('nama_negeri', 'kod_negeri')
            ->orderBy('nama_negeri')
            ->get();

            foreach($negeri as $item){
                if(strcasecmp($request->nama_negeri, $item->nama_negeri) == 0){
                    return response()->json(['message' => 'Nama Negeri yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if(strcasecmp($request->kod_negeri, $item->kod_negeri) == 0){
                    return response()->json(['message' => 'Kod Negeri yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refNegeri = RefNegeri::create([
                'nama_negeri' => $request->nama_negeri,
                'kod_negeri' => $request->kod_negeri,
                'status_negeri' => $request->status_negeri,

            ]);

            $refNegeri->save();

            DB::commit();
            return response()->json($refNegeri, 200);
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

            $negeri = DB::table('ref_negeri')
            ->select('nama_negeri', 'kod_negeri')
            ->orderBy('nama_negeri')
            ->get();

            $refNegeri = RefNegeri::where([['id', $request->id]])->first();

            foreach($negeri as $item){
                if((strcasecmp($request->nama_negeri, $refNegeri->nama_negeri) != 0) && (strcasecmp($request->nama_negeri, $item->nama_negeri) == 0)){
                    return response()->json(['message' => 'Nama Negeri yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if((strcasecmp($request->kod_negeri, $refNegeri->kod_negeri) != 0) && (strcasecmp($request->kod_negeri, $item->kod_negeri) == 0)){
                    return response()->json(['message' => 'Kod Negeri yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refNegeri->id = $request->id;
            $refNegeri->nama_negeri = $request->nama_negeri;
            $refNegeri->kod_negeri = $request->kod_negeri;
            $refNegeri->status_negeri = $request->status_negeri;

            $refNegeri->save();

            DB::commit();
            return response()->json($refNegeri, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
