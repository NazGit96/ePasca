<?php

namespace App\Http\Controllers;

use App\Models\RefJenisBwi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefJenisBwiController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_jenis_bwi', 'status_jenis_bwi'
        ];

        $data = DB::table('ref_jenis_bwi')
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
                    return $query->where('status_jenis_bwi', $filterStatus);
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

    public function getRefJenisBwiForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refJenisBwi = RefJenisBwi::where('id', $request->id)->first();
        return response()->json(['ref_jenis_bwi'=> $refJenisBwi], 200);
    }

    public function getRefJenisBwiForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_jenis_bwi', 'status_jenis_bwi'
        ];

        $data = DB::table('ref_jenis_bwi')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_jenis_bwi', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refJenisBwi = $this->update($request);
        }else{
            $refJenisBwi = $this->create($request);
        }

        return $refJenisBwi;
    }

    private function create($request){
        $request->validate([]);

            try{

            DB::beginTransaction();

            $jenisBwi = DB::table('ref_jenis_bwi')
            ->select('nama_jenis_bwi')
            ->orderBy('nama_jenis_bwi')
            ->get();

            foreach($jenisBwi as $item){
                if(strcasecmp($request->nama_jenis_bwi, $item->nama_jenis_bwi) == 0){
                    return response()->json(['message' => 'Nama Jenis Bantuan Wang Ihsan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refJenisBwi = RefJenisBwi::create([
                'nama_jenis_bwi' => $request->nama_jenis_bwi,
                'status_jenis_bwi' => $request->status_jenis_bwi,

            ]);

            $refJenisBwi->save();

            DB::commit();
            return response()->json($refJenisBwi);
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

            $jenisBwi = DB::table('ref_jenis_bwi')
            ->select('nama_jenis_bwi')
            ->orderBy('nama_jenis_bwi')
            ->get();

            $refJenisBwi = RefJenisBwi::where([['id', $request->id]])->first();

            foreach($jenisBwi as $item){
                if((strcasecmp($request->nama_jenis_bwi, $refJenisBwi->nama_jenis_bwi) != 0) && (strcasecmp($request->nama_jenis_bwi, $item->nama_jenis_bwi) == 0)){
                    return response()->json(['message' => 'Nama Jenis Bantuan Wang Ihsan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refJenisBwi->nama_jenis_bwi = $request->nama_jenis_bwi;
            $refJenisBwi->status_jenis_bwi = $request->status_jenis_bwi;

            $refJenisBwi->save();

            DB::commit();
            return response()->json($refJenisBwi, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
