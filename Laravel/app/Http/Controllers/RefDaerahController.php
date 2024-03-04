<?php

namespace App\Http\Controllers;

use App\Models\RefDaerah;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefDaerahController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'ref_daerah.id', 'id_negeri', 'nama_daerah', 'status_daerah', 'nama_negeri'
        ];

        $data = DB::table('ref_daerah')
            ->join('ref_negeri', 'ref_daerah.id_negeri', 'ref_negeri.id')
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
                    return $query->where('status_daerah', $filterStatus);
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

    public function getRefDaerahForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refDaerah = RefDaerah::where([['id', $request->id]])->first();
        return response()->json(['ref_daerah'=> $refDaerah], 200);
    }

    public function getRefDaerahForDropdown(Request $request)
    {
        $filter = $request->filter;
        $id_negeri = $request->id_negeri;

        $columns = [
            'ref_daerah.id', 'id_negeri', 'nama_daerah', 'status_daerah'
        ];

        $data = DB::table('ref_daerah')
            ->join('ref_negeri', 'ref_daerah.id_negeri', '=', 'ref_negeri.id')
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
            ->where('status_daerah', '=', 1)
            ->select($columns)
            ->orderBy('nama_daerah')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refDaerah = $this->update($request);
        }else{
            $refDaerah = $this->create($request);
        }

        return $refDaerah;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $daerah = DB::table('ref_daerah')
            ->select('nama_daerah')
            ->orderBy('nama_daerah')
            ->get();

            foreach($daerah as $item){
                if(strcasecmp($request->nama_daerah, $item->nama_daerah) == 0){
                    return response()->json(['message' => 'Nama Daerah yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refDaerah = RefDaerah::create([
                'id_negeri' => $request->id_negeri,
                'nama_daerah' => $request->nama_daerah,
                'status_daerah' => $request->status_daerah,

            ]);

            $refDaerah->save();


            DB::commit();
            return response()->json($refDaerah);
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

            $daerah = DB::table('ref_daerah')
            ->select('nama_daerah')
            ->orderBy('nama_daerah')
            ->get();

            $refDaerah = RefDaerah::where([['id', $request->id]])->first();

            foreach($daerah as $item){
                if((strcasecmp($request->nama_daerah, $refDaerah->nama_daerah) != 0) && (strcasecmp($request->nama_daerah, $item->nama_daerah) == 0)){
                    return response()->json(['message' => 'Nama Daerah yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refDaerah->id = $request->id;
            $refDaerah->id_negeri = $request->id_negeri;
            $refDaerah->nama_daerah = $request->nama_daerah;
            $refDaerah->status_daerah = $request->status_daerah;

            $refDaerah->save();

            DB::commit();
            return response()->json($refDaerah, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
