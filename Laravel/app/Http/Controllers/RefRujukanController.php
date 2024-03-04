<?php

namespace App\Http\Controllers;

use App\Http\AppConst;
use App\Models\RefRujukan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefRujukanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterStatus = $request->filterStatus;

        $columns = [
            'id', 'nama_rujukan', 'nama_dokumen', 'lokasi_dokumen', 'sambungan_fail', 'catatan',
            'status_rujukan', 'tarikh_cipta', 'id_pengguna_cipta', 'tarikh_kemaskini', 'id_pengguna_kemaskini'
        ];

        $data = DB::table('ref_rujukan')
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
                    return $query->where('status_rujukan', $filterStatus);
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

    public function getRefRujukanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refRujukan = RefRujukan::where('id', $request->id)->first();
        return response()->json(['ref_rujukan'=> $refRujukan], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $refRujukan = $this->update($request);
        }else{
            $refRujukan = $this->create($request);
        }

        return $refRujukan;
    }

    private function create($request){
        $validator = Validator::make($request->all(), [
            //validation here
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        $refRujukan = RefRujukan::create([
            'nama_rujukan' => $request->nama_rujukan,
            'nama_dokumen' => $request->nama_dokumen,
            'lokasi_dokumen' => $request->lokasi_dokumen,
            'sambungan_fail' => $request->sambungan_fail,
            'catatan' => $request->catatan,
            'status_rujukan' => $request->status_rujukan,
            'tarikh_cipta' => Carbon::now(),
            'id_pengguna_cipta' => $user->id
        ]);

        $refRujukan->save();

        return response()->json($refRujukan, 200);
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

        $user = JWTAuth::user();

        $refRujukan = RefRujukan::where('id', $request->id)->first();

        $refRujukan->nama_rujukan = $request->nama_rujukan;
        $refRujukan->nama_dokumen = $request->nama_dokumen;
        $refRujukan->lokasi_dokumen = $request->lokasi_dokumen;
        $refRujukan->sambungan_fail = $request->sambungan_fail;
        $refRujukan->catatan = $request->catatan;
        $refRujukan->status_rujukan = $request->status_rujukan;
        $refRujukan->tarikh_kemaskini = Carbon::now();
        $refRujukan->id_pengguna_kemaskini = $user->id;

        $refRujukan->save();

        return response()->json($refRujukan, 200);
    }

    public function uploadFail(Request $request){
        $validator = Validator::make($request->all(), [
            'fail' => 'required|mimes:doc,docx,pdf,txt,jpg,jpeg,bmp,png,svg|max:5120',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $fileName = $request->file('fail')->getClientOriginalName();

        Storage::putFileAs(AppConst::RujukanStorage, $request->file('fail'), $fileName);

        $filePath = config('app.url').Storage::url(AppConst::RujukanStorage.$fileName);

        $user = JWTAuth::user();

        $explodedUrl = explode('.', $fileName);
        return response()->json([
            'file_extension' => end($explodedUrl),
            'file_location' => $filePath,
            'file_name' => $fileName,
            'user' => $user->id
        ]);
    }
}
