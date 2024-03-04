<?php

namespace App\Http\Controllers;

use App\Models\RefBantuan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefBantuanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_bantuan', 'status_bantuan'
        ];

        $data = DB::table('ref_bantuan')
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
                    return $query->where('status_bantuan', $filterStatus);
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

    public function getRefBantuanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refBantuan = RefBantuan::where([['id', $request->id]])->first();
        return response()->json(['ref_bantuan'=> $refBantuan], 200);
    }

    public function getRefBantuanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_bantuan', 'status_bantuan'
        ];

        $data = DB::table('ref_bantuan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_bantuan', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refBantuan = $this->update($request);
        }else{
            $refBantuan = $this->create($request);
        }

        return $refBantuan;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $bantuan = DB::table('ref_bantuan')
            ->select('nama_bantuan')
            ->orderBy('nama_bantuan')
            ->get();

            foreach($bantuan as $item){
                if(strcasecmp($request->nama_bantuan, $item->nama_bantuan) == 0){
                    return response()->json(['message' => 'Nama Bantuan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refBantuan = RefBantuan::create([
                'nama_bantuan' => $request->nama_bantuan,
                'status_bantuan' => $request->status_bantuan,

            ]);

            $refBantuan->save();


            DB::commit();
            return response()->json($refBantuan);
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

            $bantuan = DB::table('ref_bantuan')
            ->select('nama_bantuan')
            ->orderBy('nama_bantuan')
            ->get();

            $refBantuan = RefBantuan::where([['id', $request->id]])->first();

            foreach($bantuan as $item){
                if((strcasecmp($request->nama_bantuan, $refBantuan->nama_bantuan) != 0) && (strcasecmp($request->nama_bantuan, $item->nama_bantuan) == 0)){
                    return response()->json(['message' => 'Nama Bantuan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refBantuan->id = $request->id;
            $refBantuan->nama_bantuan = $request->nama_bantuan;
            $refBantuan->status_bantuan = $request->status_bantuan;

            $refBantuan->save();

            DB::commit();
            return response()->json($refBantuan, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
