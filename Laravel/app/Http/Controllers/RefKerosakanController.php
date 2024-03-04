<?php

namespace App\Http\Controllers;

use App\Models\RefKerosakan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefKerosakanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_kerosakan', 'status_kerosakan'
        ];

        $data = DB::table('ref_kerosakan')
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
                    return $query->where('status_kerosakan', $filterStatus);
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

    public function getRefKerosakanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refKerosakan = RefKerosakan::where([['id', $request->id]])->first();
        return response()->json(['ref_kerosakan'=> $refKerosakan], 200);
    }

    public function getRefKerosakanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_kerosakan', 'status_kerosakan'
        ];

        $data = DB::table('ref_kerosakan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_kerosakan', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refKerosakan = $this->update($request);
        }else{
            $refKerosakan = $this->create($request);
        }

        return $refKerosakan;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $kerosakan = DB::table('ref_kerosakan')
            ->select('nama_kerosakan')
            ->orderBy('nama_kerosakan')
            ->get();

            foreach($kerosakan as $item){
                if(strcasecmp($request->nama_kerosakan, $item->nama_kerosakan) == 0){
                    return response()->json(['message' => 'Nama Kerosakan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refKerosakan = RefKerosakan::create([
                'nama_kerosakan' => $request->nama_kerosakan,
                'status_kerosakan' => $request->status_kerosakan,

            ]);

            $refKerosakan->save();

            DB::commit();
            return response()->json($refKerosakan);
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

            $kerosakan = DB::table('ref_kerosakan')
            ->select('nama_kerosakan')
            ->orderBy('nama_kerosakan')
            ->get();

            $refKerosakan = RefKerosakan::where([['id', $request->id]])->first();

            foreach($kerosakan as $item){
                if((strcasecmp($request->nama_kerosakan, $refKerosakan->nama_kerosakan) != 0) && (strcasecmp($request->nama_kerosakan, $item->nama_kerosakan) == 0)){
                    return response()->json(['message' => 'Nama Kerosakan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refKerosakan->id = $request->id;
            $refKerosakan->nama_kerosakan = $request->nama_kerosakan;
            $refKerosakan->status_kerosakan = $request->status_kerosakan;

            $refKerosakan->save();

            DB::commit();
            return response()->json($refKerosakan, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
