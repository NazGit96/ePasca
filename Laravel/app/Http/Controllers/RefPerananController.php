<?php

namespace App\Http\Controllers;

use App\Models\Capaian;
use App\Models\RefPeranan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefPerananController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'peranan', 'status_peranan'
        ];

        $data = DB::table('ref_peranan')
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
                    return $query->where('status_peranan', $filterStatus);
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

    public function getRefPerananForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refPeranan = RefPeranan::where([['id', $request->id]])->first();

        $capaianPeranan = $this->getCapaianPeranan($refPeranan->id);
        $refPeranan->capaian_dibenarkan = $capaianPeranan;

        return response()->json([
            'ref_peranan'=> $refPeranan
        ], 200);
    }

    public function getRefPerananForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'peranan'
        ];

        $data = DB::table('ref_peranan')
            ->select($columns)
            ->where('status_peranan', 1)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refPeranan = $this->update($request);
        }else{
            $refPeranan = $this->create($request);
        }

        return $refPeranan;
    }

    public function getAllRefCapaian(){
        $ref_permissions = DB::table('ref_capaian')
        ->orderBy('id')
        ->get();

        return response()->json([
            'ref_capaian'=> $ref_permissions
        ], 200);
    }

    private function create($request){
        $request->validate([]);

        $refPeranan = RefPeranan::create([
            'peranan' => $request->peranan,
            'status_peranan' => $request->status_peranan
        ]);

        $refPeranan->save();

        $this->updateCapaianPeranan($refPeranan->id, $request->capaian_dibenarkan);

        return response()->json($refPeranan, 200);
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

        $refPeranan = RefPeranan::where([['id', $request->id]])->first();
        if($refPeranan->status_peranan != $request->status_peranan && $request->status_peranan == 2){
            $pengguna = User::where([['id_peranan', $request->id]])->first();
            if($pengguna){
                return response()->json(['message' => "Peranan $refPeranan->peranan Sudah Berdaftar di Dalam Pengguna"], 200);
            }
        }
        $refPeranan->peranan = $request->peranan;
        $refPeranan->status_peranan = $request->status_peranan;

        $refPeranan->save();

        $this->updateCapaianPeranan($refPeranan->id, $request->capaian_dibenarkan);

        return response()->json(['message' => "Peranan Berjaya Dikemaskini"], 200);
    }

    private function updateCapaianPeranan($id_peranan, $capaian_dibenarkan = []){

        $new_permissions = array();
        $exist = DB::table('tbl_capaian')
            ->where('id_peranan', $id_peranan)
            ->whereIn('nama', $capaian_dibenarkan)
            ->get()
            ->toArray();

        foreach($capaian_dibenarkan as $capaian){
            if(!in_array($capaian, array_column($exist, 'nama'))){
                array_push($new_permissions, $capaian);
            }
        }

        foreach($new_permissions as $np){
            $capaian = Capaian::create([
                'nama' => $np,
                'pembeza' => 'CapaianPeranan',
                'dibenarkan' => true,
                'id_peranan' => $id_peranan,
                'tarikh_cipta' => Carbon::now()
            ]);
            $capaian->save();
        }

        DB::table('tbl_capaian')
            ->join('ref_peranan','tbl_capaian.id_peranan','=','ref_peranan.id')
            ->whereIn('tbl_capaian.nama', $capaian_dibenarkan)
            ->where('ref_peranan.id', $id_peranan)
            ->where('dibenarkan', false)
            ->update(['dibenarkan' => true, 'tarikh_kemaskini' => Carbon::now()]);

        DB::table('tbl_capaian')
            ->join('ref_peranan','tbl_capaian.id_peranan','=','ref_peranan.id')
            ->whereNotIn('tbl_capaian.nama', $capaian_dibenarkan)
            ->where('ref_peranan.id', $id_peranan)
            ->update(['dibenarkan' => false, 'tarikh_kemaskini' => Carbon::now()]);
    }

    private function getCapaianPeranan($id_peranan){
        $permissions = DB::table('ref_peranan')
        ->join('tbl_capaian','ref_peranan.id','=','tbl_capaian.id_peranan')
        ->where('ref_peranan.id', $id_peranan)
        ->where('dibenarkan', true)
        ->select(['tbl_capaian.nama'])
        ->get()
        ->pluck('nama');

        return $permissions;
    }

}
