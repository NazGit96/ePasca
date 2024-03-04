<?php

namespace App\Http\Controllers;

use App\Models\RefTapakRumah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefTapakRumahController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_tapak_rumah', 'status_tapak_rumah'
        ];

        $data = DB::table('ref_tapak_rumah')
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
                    return $query->where('status_tapak_rumah', $filterStatus);
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

    public function getRefTapakRumahForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refTapakRumah = RefTapakRumah::where([['id', $request->id]])->first();
        return response()->json(['ref_tapak_rumah'=> $refTapakRumah], 200);
    }

    public function getRefTapakRumahForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_tapak_rumah', 'status_tapak_rumah'
        ];

        $data = DB::table('ref_tapak_rumah')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_tapak_rumah', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refTapakRumah = $this->update($request);
        }else{
            $refTapakRumah = $this->create($request);
        }

        return $refTapakRumah;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $tapak_rumah = DB::table('ref_tapak_rumah')
            ->select('nama_tapak_rumah')
            ->orderBy('nama_tapak_rumah')
            ->get();

            foreach($tapak_rumah as $item){
                if(strcasecmp($request->nama_tapak_rumah, $item->nama_tapak_rumah) == 0){
                    return response()->json(['message' => 'Nama Pemilik Projek Rumah yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refTapakRumah = RefTapakRumah::create([
                'nama_tapak_rumah' => $request->nama_tapak_rumah,
                'status_tapak_rumah' => $request->status_tapak_rumah,

            ]);

            $refTapakRumah->save();


            DB::commit();
            return response()->json($refTapakRumah);
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

            $tapak_rumah = DB::table('ref_tapak_rumah')
            ->select('nama_tapak_rumah')
            ->orderBy('nama_tapak_rumah')
            ->get();

            $refTapakRumah = RefTapakRumah::where([['id', $request->id]])->first();

            foreach($tapak_rumah as $item){
                if((strcasecmp($request->nama_tapak_rumah, $refTapakRumah->nama_tapak_rumah) != 0) && (strcasecmp($request->nama_tapak_rumah, $item->nama_tapak_rumah) == 0)){
                    return response()->json(['message' => 'Nama Pemilik yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refTapakRumah->id = $request->id;
            $refTapakRumah->nama_tapak_rumah = $request->nama_tapak_rumah;
            $refTapakRumah->status_tapak_rumah = $request->status_tapak_rumah;

            $refTapakRumah->save();

            DB::commit();
            return response()->json($refTapakRumah, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
