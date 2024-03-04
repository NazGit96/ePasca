<?php

namespace App\Http\Controllers;

use App\Models\RefDun;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefDunController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'ref_dun.id', 'ref_dun.id_negeri', 'id_parlimen', 'kod_dun', 'nama_dun', 'status_dun', 'nama_negeri', 'nama_parlimen'
        ];

        $data = DB::table('ref_dun')
            ->join('ref_negeri', 'ref_dun.id_negeri', 'ref_negeri.id')
            ->join('ref_parlimen', 'ref_dun.id_parlimen', 'ref_parlimen.id')
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
                    return $query->where('status_dun', $filterStatus);
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

    public function getRefDunForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refDun = RefDun::where([['id', $request->id]])->first();
        return response()->json(['ref_dun'=> $refDun], 200);
    }

    public function getRefDunForDropdown(Request $request)
    {
        $filter = $request->filter;
        $id_negeri = $request->id_negeri;

        $columns = [
            'ref_dun.id', 'id_negeri', 'id_parlimen', 'kod_dun', 'nama_dun', 'status_dun'
        ];

        $data = DB::table('ref_dun')
            ->join('ref_negeri', 'ref_dun.id_negeri', '=', 'ref_negeri.id')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($id_negeri){
                $query->when($id_negeri, function ($query, $id_negeri) {
                    $query->where('id_negeri', $id_negeri);
                    return $query;
                });
            })
            ->where('status_dun', '=', 1)
            ->select($columns)
            ->orderBy('nama_dun')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refDun = $this->update($request);
        }else{
            $refDun = $this->create($request);
        }

        return $refDun;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $dun = DB::table('ref_dun')
            ->select('nama_dun', 'kod_dun')
            ->orderBy('nama_dun')
            ->get();

            foreach($dun as $item){
                if(strcasecmp($request->nama_dun, $item->nama_dun) == 0){
                    return response()->json(['message' => 'Nama Dun yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if(strcasecmp($request->kod_dun, $item->kod_dun) == 0){
                    return response()->json(['message' => 'Kod Dun yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refDun = RefDun::create([
                'id_negeri' => $request->id_negeri,
                'id_parlimen' => $request->id_parlimen,
                'kod_dun' => $request->kod_dun,
                'nama_dun' => $request->nama_dun,
                'status_dun' => $request->status_dun,

            ]);

            $refDun->save();

            DB::commit();
            return response()->json($refDun, 200);
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

            $dun = DB::table('ref_dun')
            ->select('nama_dun', 'kod_dun')
            ->orderBy('nama_dun')
            ->get();

            $refDun = RefDun::where([['id', $request->id]])->first();

            foreach($dun as $item){
                if((strcasecmp($request->nama_dun, $refDun->nama_dun) != 0) && (strcasecmp($request->nama_dun, $item->nama_dun) == 0)){
                    return response()->json(['message' => 'Nama Dun yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if((strcasecmp($request->kod_dun, $refDun->kod_dun) != 0) && (strcasecmp($request->kod_dun, $item->kod_dun) == 0)){
                    return response()->json(['message' => 'Kod Dun yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refDun->id = $request->id;
            $refDun->id_negeri = $request->id_negeri;
            $refDun->id_parlimen = $request->id_parlimen;
            $refDun->kod_dun = $request->kod_dun;
            $refDun->nama_dun = $request->nama_dun;
            $refDun->status_dun = $request->status_dun;

            $refDun->save();

            DB::commit();
            return response()->json($refDun, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
