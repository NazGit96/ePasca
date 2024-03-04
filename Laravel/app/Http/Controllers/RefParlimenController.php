<?php

namespace App\Http\Controllers;

use App\Models\RefParlimen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefParlimenController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'ref_parlimen.id', 'id_negeri', 'nama_parlimen', 'kod_parlimen', 'status_parlimen', 'nama_negeri'
        ];

        $data = DB::table('ref_parlimen')
            ->join('ref_negeri', 'ref_parlimen.id_negeri', 'ref_negeri.id')
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
                    return $query->where('status_parlimen', $filterStatus);
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

    public function getRefParlimenForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refParlimen = RefParlimen::where([['id', $request->id]])->first();
        return response()->json(['ref_parlimen'=> $refParlimen], 200);
    }

    public function getRefParlimenForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'id_negeri', 'nama_parlimen', 'kod_parlimen', 'status_parlimen'
        ];

        $data = DB::table('ref_parlimen')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_parlimen', '=', 1)
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refParlimen = $this->update($request);
        }else{
            $refParlimen = $this->create($request);
        }

        return $refParlimen;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $parlimen = DB::table('ref_parlimen')
            ->select('nama_parlimen', 'kod_parlimen')
            ->orderBy('nama_parlimen')
            ->get();

            foreach($parlimen as $item){
                if(strcasecmp($request->nama_parlimen, $item->nama_parlimen) == 0){
                    return response()->json(['message' => 'Nama Parlimen yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if(strcasecmp($request->kod_parlimen, $item->kod_parlimen) == 0){
                    return response()->json(['message' => 'Kod Parlimen yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refParlimen = RefParlimen::create([
                'id_negeri' => $request->id_negeri,
                'nama_parlimen' => $request->nama_parlimen,
                'kod_parlimen' => $request->kod_parlimen,
                'status_parlimen' => $request->status_parlimen,

            ]);

            $refParlimen->save();

            DB::commit();
            return response()->json($refParlimen);
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

            $parlimen = DB::table('ref_parlimen')
            ->select('nama_parlimen', 'kod_parlimen')
            ->orderBy('nama_parlimen')
            ->get();

            $refParlimen = RefParlimen::where([['id', $request->id]])->first();

            foreach($parlimen as $item){
                if((strcasecmp($request->nama_parlimen, $refParlimen->nama_parlimen) != 0) && (strcasecmp($request->nama_parlimen, $item->nama_parlimen) == 0)){
                    return response()->json(['message' => 'Nama Parlimen yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if((strcasecmp($request->kod_parlimen, $refParlimen->kod_parlimen) != 0) && (strcasecmp($request->kod_parlimen, $item->kod_parlimen) == 0)){
                    return response()->json(['message' => 'Kod Parlimen yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refParlimen->id = $request->id;
            $refParlimen->id_negeri = $request->id_negeri;
            $refParlimen->nama_parlimen = $request->nama_parlimen;
            $refParlimen->kod_parlimen = $request->kod_parlimen;
            $refParlimen->status_parlimen = $request->status_parlimen;

            $refParlimen->save();

            DB::commit();
            return response()->json($refParlimen, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
