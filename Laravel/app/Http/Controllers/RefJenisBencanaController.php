<?php

namespace App\Http\Controllers;

use App\Models\RefJenisBencana;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefJenisBencanaController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'nama_jenis_bencana desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_jenis_bencana', 'catatan', 'status_bencana', 'id_pengguna'
        ];

        $data = DB::table('ref_jenis_bencana')
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
                    return $query->where('status_bencana', $filterStatus);
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

    public function getRefJenisBencanaForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refJenisBencana = RefJenisBencana::where('id', $request->id)->first();
        return response()->json(['ref_jenis_bencana'=> $refJenisBencana], 200);
    }

    public function getRefJenisBencanaForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_jenis_bencana', 'catatan', 'status_bencana', 'id_pengguna'
        ];

        $data = DB::table('ref_jenis_bencana')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_bencana', '=', 1)
            ->select($columns)
            ->orderBy('nama_jenis_bencana')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refJenisBencana = $this->update($request);
        }else{
            $refJenisBencana = $this->create($request);
        }

        return $refJenisBencana;
    }

    private function create($request){
        $request->validate([]);

            try{

            DB::beginTransaction();

            $jenisBencana = DB::table('ref_jenis_bencana')
            ->select('nama_jenis_bencana')
            ->orderBy('nama_jenis_bencana')
            ->get();

            foreach($jenisBencana as $item){
                if(strcasecmp($request->nama_jenis_bencana, $item->nama_jenis_bencana) == 0){
                    return response()->json(['message' => 'Nama Jenis Bencana yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refJenisBencana = RefJenisBencana::create([
                'nama_jenis_bencana' => $request->nama_jenis_bencana,
                'catatan' => $request->catatan,
                'status_bencana' => $request->status_bencana,
                'id_pengguna' => $request->id_pengguna,

            ]);

            $refJenisBencana->save();

            DB::commit();
            return response()->json($refJenisBencana);
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

            $jenisBencana = DB::table('ref_jenis_bencana')
            ->select('nama_jenis_bencana')
            ->orderBy('nama_jenis_bencana')
            ->get();

            $refJenisBencana = RefJenisBencana::where([['id', $request->id]])->first();

            foreach($jenisBencana as $item){
                if((strcasecmp($request->nama_jenis_bencana, $refJenisBencana->nama_jenis_bencana) != 0) && (strcasecmp($request->nama_jenis_bencana, $item->nama_jenis_bencana) == 0)){
                    return response()->json(['message' => 'Nama Jenis Bencana yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refJenisBencana->id = $request->id;
            $refJenisBencana->nama_jenis_bencana = $request->nama_jenis_bencana;
            $refJenisBencana->catatan = $request->catatan;
            $refJenisBencana->status_bencana = $request->status_bencana;
            $refJenisBencana->id_pengguna = $request->id_pengguna;

            $refJenisBencana->save();

            DB::commit();
            return response()->json($refJenisBencana, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
