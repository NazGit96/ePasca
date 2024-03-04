<?php

namespace App\Http\Controllers;

use App\Models\MangsaKerosakan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class MangsaKerosakanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'id_mangsa', 'id_mangsa_rumah', 'id_kerosakan', 'status_kerosakan',
            'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini',
            'tarikh_kemaskini', 'sebab_hapus'
        ];

        $data = DB::table('tbl_mangsa_kerosakan')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
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

    public function getAllByIdMangsa(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $validator = Validator::make($request->all(), [
            'idMangsa' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'id', 'id_mangsa', 'id_mangsa_rumah', 'id_kerosakan', 'status_kerosakan',
            'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini',
            'tarikh_kemaskini', 'sebab_hapus'
        ];

        $data = DB::table('tbl_mangsa_kerosakan')
            ->select($columns)
            ->where('id_mangsa', $request->idMangsa)
            ->where('status_kerosakan', 1)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
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

    public function getMangsaKerosakanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaKerosakan = MangsaKerosakan::where('id', $request->id)->first();
        return response()->json(['mangsa_kerosakan'=> $mangsaKerosakan], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $mangsaKerosakan = $this->update($request);
        }else{
            $mangsaKerosakan = $this->create($request);
        }

        return $mangsaKerosakan;
    }

    private function create($request){
        $request->validate([]);
        $user = JWTAuth::user();

        $mangsaKerosakan = MangsaKerosakan::create([
            'id_mangsa' => $request->id_mangsa,
            'id_mangsa_rumah' => $request->id_mangsa_rumah,
            'id_kerosakan' => $request->id_kerosakan,
            'status_kerosakan' => $request->status_kerosakan,
            'id_pengguna_cipta' => $user->id,
            'tarikh_cipta' => Carbon::now(),
            'id_agensi' => $user->id_agensi
        ]);

        $mangsaKerosakan->save();

        return response()->json($mangsaKerosakan, 200);
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

        $mangsaKerosakan = MangsaKerosakan::where('id', $request->id)->first();

        $mangsaKerosakan->id_mangsa = $request->id_mangsa;
        $mangsaKerosakan->id_mangsa_rumah = $request->id_mangsa_rumah;
        $mangsaKerosakan->id_kerosakan = $request->id_kerosakan;
        $mangsaKerosakan->status_kerosakan = $request->status_kerosakan;
        $mangsaKerosakan->id_pengguna_kemaskini = JWTAuth::user()->id;
        $mangsaKerosakan->tarikh_kemaskini = Carbon::now();

        $mangsaKerosakan->save();

        return response()->json($mangsaKerosakan, 200);
    }
}
