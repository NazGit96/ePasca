<?php

namespace App\Http\Controllers;

use App\Models\RefKementerian;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefKementerianController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_kementerian', 'kod_kementerian', 'status_kementerian'
        ];

        $data = DB::table('ref_kementerian')
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
                    return $query->where('status_kementerian', $filterStatus);
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

    public function getRefKementerianForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refKementerian = RefKementerian::where([['id', $request->id]])->first();
        return response()->json(['ref_kementerian'=> $refKementerian], 200);
    }

    public function getRefKementerianForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_kementerian', 'kod_kementerian', 'status_kementerian'
        ];

        $data = DB::table('ref_kementerian')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_kementerian', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refKementerian = $this->update($request);
        }else{
            $refKementerian = $this->create($request);
        }

        return $refKementerian;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $kementerian = DB::table('ref_kementerian')
            ->select('nama_kementerian', 'kod_kementerian')
            ->orderBy('nama_kementerian')
            ->get();

            foreach($kementerian as $item){
                if(strcasecmp($request->nama_kementerian, $item->nama_kementerian) == 0){
                    return response()->json(['message' => 'Nama Kementerian yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if(strcasecmp($request->kod_kementerian, $item->kod_kementerian) == 0){
                    return response()->json(['message' => 'Kod Kementerian yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refKementerian = RefKementerian::create([
                'nama_kementerian' => $request->nama_kementerian,
                'kod_kementerian' => $request->kod_kementerian,
                'status_kementerian' => $request->status_kementerian,

            ]);

            $refKementerian->save();

            DB::commit();
            return response()->json($refKementerian, 200);
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

            $kementerian = DB::table('ref_kementerian')
            ->select('nama_kementerian', 'kod_kementerian')
            ->orderBy('nama_kementerian')
            ->get();

            $refKementerian = RefKementerian::where([['id', $request->id]])->first();

            foreach($kementerian as $item){
                if((strcasecmp($request->nama_kementerian, $refKementerian->nama_kementerian) != 0) && (strcasecmp($request->nama_kementerian, $item->nama_kementerian) == 0)){
                    return response()->json(['message' => 'Nama Kementerian yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if((strcasecmp($request->kod_kementerian, $refKementerian->kod_kementerian) != 0) && (strcasecmp($request->kod_kementerian, $item->kod_kementerian) == 0)){
                    return response()->json(['message' => 'Kod Kementerian yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refKementerian->id = $request->id;
            $refKementerian->nama_kementerian = $request->nama_kementerian;
            $refKementerian->kod_kementerian = $request->kod_kementerian;
            $refKementerian->status_kementerian = $request->status_kementerian;

            $refKementerian->save();

            DB::commit();
            return response()->json($refKementerian, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
