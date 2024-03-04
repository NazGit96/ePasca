<?php

namespace App\Http\Controllers;

use App\Models\RefJenisBayaran;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefJenisBayaranController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_jenis_bayaran', 'status_jenis_bayaran'
        ];

        $data = DB::table('ref_jenis_bayaran')
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
                    return $query->where('status_jenis_bayaran', $filterStatus);
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

    public function getRefJenisBayaranForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refJenisBayaran = RefJenisBayaran::where('id', $request->id)->first();
        return response()->json(['ref_jenis_bayaran'=> $refJenisBayaran], 200);
    }

    public function getRefJenisBayaranForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_jenis_bayaran', 'status_jenis_bayaran'
        ];

        $data = DB::table('ref_jenis_bayaran')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_jenis_bayaran', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refJenisBayaran = $this->update($request);
        }else{
            $refJenisBayaran = $this->create($request);
        }

        return $refJenisBayaran;
    }

    private function create($request){
        $request->validate([]);

            try{

            DB::beginTransaction();

            $jenisBayaran = DB::table('ref_jenis_bayaran')
            ->select('nama_jenis_bayaran')
            ->orderBy('nama_jenis_bayaran')
            ->get();

            foreach($jenisBayaran as $item){
                if(strcasecmp($request->nama_jenis_bayaran, $item->nama_jenis_bayaran) == 0){
                    return response()->json(['message' => 'Nama Jenis Bayaran yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refJenisBayaran = RefJenisBayaran::create([
                'nama_jenis_bayaran' => $request->nama_jenis_bayaran,
                'status_jenis_bayaran' => $request->status_jenis_bayaran,

            ]);

            $refJenisBayaran->save();

            DB::commit();
            return response()->json($refJenisBayaran);
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

            $jenisBayaran = DB::table('ref_jenis_bayaran')
            ->select('nama_jenis_bayaran')
            ->orderBy('nama_jenis_bayaran')
            ->get();

            $refJenisBayaran = RefJenisBayaran::where([['id', $request->id]])->first();

            foreach($jenisBayaran as $item){
                if((strcasecmp($request->nama_jenis_bayaran, $refJenisBayaran->nama_jenis_bayaran) != 0) && (strcasecmp($request->nama_jenis_bayaran, $item->nama_jenis_bayaran) == 0)){
                    return response()->json(['message' => 'Nama Jenis Bayaran yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refJenisBayaran->nama_jenis_bayaran = $request->nama_jenis_bayaran;
            $refJenisBayaran->status_jenis_bayaran = $request->status_jenis_bayaran;

            $refJenisBayaran->save();

            DB::commit();
            return response()->json($refJenisBayaran, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
