<?php

namespace App\Http\Controllers;

use App\Models\RefPindah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefPindahController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'pindah', 'status_pindah'
        ];

        $data = DB::table('ref_pindah')
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
                    return $query->where('status_pindah', $filterStatus);
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

    public function getRefPindahForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refPindah = RefPindah::where([['id', $request->id]])->first();
        return response()->json(['ref_pindah'=> $refPindah], 200);
    }

    public function getRefPindahForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'pindah', 'status_pindah'
        ];

        $data = DB::table('ref_pindah')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_pindah', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refPindah = $this->update($request);
        }else{
            $refPindah = $this->create($request);
        }

        return $refPindah;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $pindah = DB::table('ref_pindah')
            ->select('pindah')
            ->orderBy('pindah')
            ->get();

            foreach($pindah as $item){
                if(strcasecmp($request->pindah, $item->pindah) == 0){
                    return response()->json(['message' => 'Maklumat Perpindahan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPindah = RefPindah::create([
                'pindah' => $request->pindah,
                'status_pindah' => $request->status_pindah,

            ]);

            $refPindah->save();

            DB::commit();
            return response()->json($refPindah);
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

            $pindah = DB::table('ref_pindah')
            ->select('pindah')
            ->orderBy('pindah')
            ->get();

            $refPindah = RefPindah::where([['id', $request->id]])->first();

            foreach($pindah as $item){
                if((strcasecmp($request->pindah, $refPindah->pindah) != 0) && (strcasecmp($request->pindah, $item->pindah) == 0)){
                    return response()->json(['message' => 'Maklumat Perpindahan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refPindah->id = $request->id;
            $refPindah->pindah = $request->pindah;
            $refPindah->status_pindah = $request->status_pindah;

            $refPindah->save();

            DB::commit();
            return response()->json($refPindah, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
