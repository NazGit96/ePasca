<?php

namespace App\Http\Controllers;

use App\Models\RefPinjamanPerniagaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefPinjamanPerniagaanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_agensi_pinjaman', 'status_agensi_pinjaman'
        ];

        $data = DB::table('ref_pinjaman_perniagaan')
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
                    return $query->where('status_agensi_pinjaman', $filterStatus);
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

    public function getRefPinjamanPerniagaanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refPinjamanPerniagaan = RefPinjamanPerniagaan::where([['id', $request->id]])->first();
        return response()->json(['ref_pinjaman_perniagaan'=> $refPinjamanPerniagaan], 200);
    }

    public function getRefPinjamanPerniagaanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_agensi_pinjaman', 'status_agensi_pinjaman'
        ];

        $data = DB::table('ref_pinjaman_perniagaan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_agensi_pinjaman', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refPinjamanPerniagaan = $this->update($request);
        }else{
            $refPinjamanPerniagaan = $this->create($request);
        }

        return $refPinjamanPerniagaan;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $pinjaman = DB::table('ref_pinjaman_perniagaan')
            ->select('nama_agensi_pinjaman')
            ->orderBy('nama_agensi_pinjaman')
            ->get();

            foreach($pinjaman as $item){
                if(strcasecmp($request->nama_agensi_pinjaman, $item->nama_agensi_pinjaman) == 0){
                    return response()->json(['message' => 'Nama Pinjaman Perniagaan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPinjamanPerniagaan = RefPinjamanPerniagaan::create([
                'nama_agensi_pinjaman' => $request->nama_agensi_pinjaman,
                'status_agensi_pinjaman' => $request->status_agensi_pinjaman,

            ]);

            $refPinjamanPerniagaan->save();


            DB::commit();
            return response()->json($refPinjamanPerniagaan);
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

            $pinjaman = DB::table('ref_pinjaman_perniagaan')
            ->select('nama_agensi_pinjaman')
            ->orderBy('nama_agensi_pinjaman')
            ->get();

            $refPinjamanPerniagaan = RefPinjamanPerniagaan::where([['id', $request->id]])->first();

            foreach($pinjaman as $item){
                if((strcasecmp($request->nama_agensi_pinjaman, $refPinjamanPerniagaan->nama_agensi_pinjaman) != 0) && (strcasecmp($request->nama_agensi_pinjaman, $item->nama_agensi_pinjaman) == 0)){
                    return response()->json(['message' => 'Nama Pinjaman Perniagaan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPinjamanPerniagaan->id = $request->id;
            $refPinjamanPerniagaan->nama_agensi_pinjaman = $request->nama_agensi_pinjaman;
            $refPinjamanPerniagaan->status_agensi_pinjaman = $request->status_agensi_pinjaman;

            $refPinjamanPerniagaan->save();

            DB::commit();
            return response()->json($refPinjamanPerniagaan, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
