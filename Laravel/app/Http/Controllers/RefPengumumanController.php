<?php

namespace App\Http\Controllers;

use App\Models\RefPengumuman;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefPengumumanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_pengumuman', 'tarikh_mula', 'tarikh_tamat', 'status_pengumuman', 'catatan'
        ];

        $data = DB::table('ref_pengumuman')
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
                    return $query->where('ref_pengumuman.status_pengumuman', $filterStatus);
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

    public function getAllPengumumanForView(){
        $pengumuman = DB::Table('ref_pengumuman')
        ->where('status_pengumuman', 1)
        ->orderBy('ref_pengumuman.id', 'DESC')
        ->get();

        $pengumuman->toArray();
        $totalCount = count($pengumuman);

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $pengumuman
        ], 200);
    }

    public function getRefPengumumanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refPengumuman = RefPengumuman::where([['id', $request->id]])->first();
        return response()->json(['ref_pengumuman'=> $refPengumuman], 200);
    }

    public function getRefPengumumanForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_pengumuman', 'status_pengumuman', 'catatan'
        ];

        $data = DB::table('ref_pengumuman')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_pengumuman', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refPengumuman = $this->update($request);
        }else{
            $refPengumuman = $this->create($request);
        }

        return $refPengumuman;
    }

    private function create($request){
        $validator = Validator::make($request->all(), [
            'nama_pengumuman' => 'required',
            'status_pengumuman' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

        $refPengumuman = RefPengumuman::create([
            'nama_pengumuman' => $request->nama_pengumuman,
            'tarikh_mula' => $request->tarikh_mula,
            'tarikh_tamat' => $request->tarikh_tamat,
            'status_pengumuman' => $request->status_pengumuman,
            'catatan' => $request->catatan,
        ]);

        $refPengumuman->save();

        DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($refPengumuman, 200);
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

        $refPengumuman = RefPengumuman::where([['id', $request->id]])->first();

        $refPengumuman->id = $request->id;
        $refPengumuman->nama_pengumuman = $request->nama_pengumuman;
        $refPengumuman->tarikh_mula = $request->tarikh_mula;
        $refPengumuman->tarikh_tamat = $request->tarikh_tamat;
        $refPengumuman->status_pengumuman = $request->status_pengumuman;
        $refPengumuman->catatan = $request->catatan;

        $refPengumuman->save();

        return response()->json($refPengumuman, 200);
    }
}
