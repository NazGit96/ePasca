<?php

namespace App\Http\Controllers;

use App\Models\RefHubungan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefHubunganController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;


        $columns = [
            'id', 'nama_hubungan', 'status_hubungan'
        ];

        $data = DB::table('ref_hubungan')
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
                    return $query->where('status_hubungan', $filterStatus);
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

    public function getRefHubunganForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refHubungan = RefHubungan::where('id', $request->id)->first();
        return response()->json(['ref_hubungan'=> $refHubungan], 200);
    }

    public function getRefHubunganForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_hubungan', 'status_hubungan'
        ];

        $data = DB::table('ref_hubungan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_hubungan', '=', 1)
            ->select($columns)
            ->orderBy('nama_hubungan')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refHubungan = $this->update($request);
        }else{
            $refHubungan = $this->create($request);
        }

        return $refHubungan;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $hubungan = DB::table('ref_hubungan')
            ->select('nama_hubungan')
            ->orderBy('nama_hubungan')
            ->get();

            foreach($hubungan as $item){
                if(strcasecmp($request->nama_hubungan, $item->nama_hubungan) == 0){
                    return response()->json(['message' => 'Nama Hubungan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refHubungan = RefHubungan::create([
                'nama_hubungan' => $request->nama_hubungan,
                'status_hubungan' => $request->status_hubungan,

            ]);

            $refHubungan->save();


            DB::commit();
            return response()->json($refHubungan);
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

            $hubungan = DB::table('ref_hubungan')
            ->select('nama_hubungan')
            ->orderBy('nama_hubungan')
            ->get();

            $refHubungan = RefHubungan::where([['id', $request->id]])->first();

            foreach($hubungan as $item){
                if((strcasecmp($request->nama_hubungan, $refHubungan->nama_hubungan) != 0) && (strcasecmp($request->nama_hubungan, $item->nama_hubungan) == 0)){
                    return response()->json(['message' => 'Nama Hubungan yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refHubungan->id = $request->id;
            $refHubungan->nama_hubungan = $request->nama_hubungan;
            $refHubungan->status_hubungan = $request->status_hubungan;

            $refHubungan->save();

            DB::commit();
            return response()->json($refHubungan, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
