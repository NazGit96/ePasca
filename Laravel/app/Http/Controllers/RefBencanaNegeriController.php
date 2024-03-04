<?php

namespace App\Http\Controllers;

use App\Models\RefBencanaNegeri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefBencanaNegeriController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'id', 'id_bencana', 'id_negeri', 'status_bencana_negeri', 'tarikh_cipta', 'id_pengguna_cipta', 'tarikh_kemaskini', 'id_pengguna_kemaskini'
        ];

        $data = DB::table('ref_bencana_negeri')
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

    public function getRefBencanaNegeriForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refBencanaNegeri = RefBencanaNegeri::where('id', $request->id)->first();
        return response()->json(['ref_bencana_negeri'=> $refBencanaNegeri], 200);
    }

    public function getRefBencanaNegeriForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'id_bencana', 'id_negeri', 'status_bencana_negeri', 'tarikh_cipta', 'id_pengguna_cipta', 'tarikh_kemaskini', 'id_pengguna_kemaskini'
        ];

        $data = DB::table('ref_bencana_negeri')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_bencana_negeri', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function getRefBencanaNegeriForDropdownByIdBencana(Request $request)
    {
        $filter = $request->filter;
        $filterIdBencana = $request->filterIdBencana;

        $columns = [
           'id_negeri', 'nama_negeri'
        ];

        $data = DB::table('ref_bencana_negeri')
            ->join('ref_negeri', 'ref_bencana_negeri.id_negeri', 'ref_negeri.id')
            ->where('status_bencana_negeri', 1)
            ->where('id_bencana', $filterIdBencana)
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->select($columns)
            ->orderBy('id_negeri')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refBencanaNegeri = $this->update($request);
        }else{
            $refBencanaNegeri = $this->create($request);
        }

        return $refBencanaNegeri;
    }

    private function create($request){
        $request->validate([]);

        $refBencanaNegeri = RefBencanaNegeri::create([
            'id_bencana' => $request->id_bencana,
            'id_negeri' => $request->id_negeri,
            'status_bencana_negeri' => $request->status_bencana_negeri,
            'tarikh_cipta' => Carbon::now(),
            'id_pengguna_cipta' => JWTAuth::user()->id

        ]);

        $refBencanaNegeri->save();

        return response()->json($refBencanaNegeri, 200);
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

        $refBencanaNegeri = RefBencanaNegeri::where('id', $request->id)->first();

        $refBencanaNegeri->id_bencana = $request->id_bencana;
        $refBencanaNegeri->id_negeri = $request->id_negeri;
        $refBencanaNegeri->status_bencana_negeri = $request->status_bencana_negeri;
        $refBencanaNegeri->id_pengguna_kemaskini = JWTAuth::user()->id;
        $refBencanaNegeri->tarikh_kemaskini = Carbon::now();

        $refBencanaNegeri->save();

        return response()->json($refBencanaNegeri, 200);
    }
}
