<?php

namespace App\Http\Controllers;

use App\Models\RefAgensi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefAgensiController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'ref_agensi.id', 'id_kementerian', 'nama_agensi', 'kod_agensi', 'pemberi_bantuan', 'pemberi_pinjaman', 'pengguna_sistem',
            'status_agensi', 'nama_kementerian'
        ];

        $data = DB::table('ref_agensi')
            ->join('ref_kementerian', 'ref_agensi.id_kementerian', 'ref_kementerian.id')
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
                    return $query->where('status_agensi', $filterStatus);
                });
            });;

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

    public function getRefAgensiForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refAgensi = RefAgensi::where([['id', $request->id]])->first();
        return response()->json(['ref_agensi'=> $refAgensi], 200);
    }

    public function getRefAgensiForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'id_kementerian', 'nama_agensi', 'kod_agensi', 'pemberi_bantuan', 'pemberi_pinjaman', 'pengguna_sistem', 'status_agensi'
        ];

        $data = DB::table('ref_agensi')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_agensi', '=', 1)
            ->select($columns)
            ->orderBy('nama_agensi')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refAgensi = $this->update($request);
        }else{
            $refAgensi = $this->create($request);
        }

        return $refAgensi;
    }

    private function create($request){
        $request->validate([]);

            try{
            DB::beginTransaction();

            $agensi = DB::table('ref_agensi')
            ->select('nama_agensi', 'kod_agensi')
            ->orderBy('nama_agensi')
            ->get();

            foreach($agensi as $item){
                if(strcasecmp($request->nama_agensi, $item->nama_agensi) == 0){
                    return response()->json(['message' => 'Nama Agensi yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if(strcasecmp($request->kod_agensi, $item->kod_agensi) == 0){
                    return response()->json(['message' => 'Kod Agensi yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refAgensi = RefAgensi::create([
                'id_kementerian' => $request->id_kementerian,
                'nama_agensi' => $request->nama_agensi,
                'kod_agensi' => $request->kod_agensi,
                'pemberi_bantuan' => $request->pemberi_bantuan,
                'pemberi_pinjaman' => $request->pemberi_pinjaman,
                'pengguna_sistem' => $request->pengguna_sistem,
                'status_agensi' => $request->status_agensi,
          ]);

            $refAgensi->save();

            DB::commit();
            return response()->json($refAgensi);
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

            $agensi = DB::table('ref_agensi')
            ->select('nama_agensi', 'kod_agensi')
            ->orderBy('nama_agensi')
            ->get();

            $refAgensi = RefAgensi::where([['id', $request->id]])->first();

            foreach($agensi as $item){
                if((strcasecmp($request->nama_agensi, $refAgensi->nama_agensi) != 0) && (strcasecmp($request->nama_agensi, $item->nama_agensi) == 0)){
                    return response()->json(['message' => 'Nama Agensi yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
                else if((strcasecmp($request->kod_agensi, $refAgensi->kod_agensi) != 0) && (strcasecmp($request->kod_agensi, $item->kod_agensi) == 0)){
                    return response()->json(['message' => 'Kod Agensi yang Anda Masukkan Sudah Terdapat di Dalam Senarai'], 200);
                }
            }

            $refAgensi->id = $request->id;
            $refAgensi->id_kementerian = $request->id_kementerian;
            $refAgensi->nama_agensi = $request->nama_agensi;
            $refAgensi->kod_agensi = $request->kod_agensi;
            $refAgensi->pemberi_bantuan = $request->pemberi_bantuan;
            $refAgensi->pemberi_pinjaman = $request->pemberi_pinjaman;
            $refAgensi->pengguna_sistem = $request->pengguna_sistem;
            $refAgensi->status_agensi = $request->status_agensi;

            $refAgensi->save();

            DB::commit();
            return response()->json($refAgensi, 200);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
