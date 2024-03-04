<?php

namespace App\Http\Controllers;

use App\Models\MangsaBencana;
use App\Models\RefBencana;
use App\Models\RefBencanaNegeri;
use App\Models\TabungBayaranSkb;
use App\Models\TabungBayaranTerus;
use App\Models\TabungBwi;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefBencanaController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'ref_bencana.id desc';
        $filter = $request->filter;
        $filterTahun = $request->filterTahun;
        $filterBencana = $request->filterBencana;
        $filterJenis = $request->filterJenis;
        $filterNegeri = $request->filterNegeri;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'ref_bencana.id', 'tarikh_bencana', 'tahun_bencana', 'ref_bencana.id_jenis_bencana', 'nama_bencana', 'ref_bencana.catatan', 'ref_bencana.status_bencana',
            'nama_jenis_bencana', 'no_rujukan_bencana'
        ];

        $data = DB::table('ref_bencana')
            ->join('ref_jenis_bencana', 'ref_bencana.id_jenis_bencana', 'ref_jenis_bencana.id')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterTahun) {
                $query->when($filterTahun, function ($query, $filterTahun) {
                    return $query->where('tahun_bencana', $filterTahun);
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('nama_bencana', $filterBencana);
                });
            })
            ->where(function ($query) use ($filterJenis) {
                $query->when($filterJenis, function ($query, $filterJenis) {
                    return $query->where('id_jenis_bencana', $filterJenis);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select($columns);

            if($filterNegeri){
                $data->join('ref_bencana_negeri', 'ref_bencana.id', '=', 'ref_bencana_negeri.id_bencana')
                    ->where('ref_bencana_negeri.id_negeri',$filterNegeri);
            }

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

        $bencanaNegeri = DB::Table('ref_bencana_negeri')
        ->join('ref_negeri', 'ref_bencana_negeri.id_negeri', 'ref_negeri.id')
        ->whereIn('id_bencana', $result->unique('id')->pluck('id'))
        ->select(['ref_bencana_negeri.id_bencana', 'nama_negeri'])
        ->get();

        $data = array();
        foreach ($result as $bencana) {
            $item = array();
            $item['bencana'] = $bencana;
            $item['bencanaNegeri'] = $bencanaNegeri->where('id_bencana', $bencana->id)->pluck('nama_negeri');
            $data[] = $item;
        }

        return response()->json([
            'total_count' => $totalCount,
            'items' => $data
        ], 200);
    }

    public function getRefBencanaForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $refBencana = RefBencana::where([['id', $request->id]])->first();

        $bencanaNegeri = DB::Table('ref_bencana_negeri')
        ->where('id_bencana', $request->id)
        ->select('id_negeri')
        ->get();

        return response()->json([
            'ref_bencana' => $refBencana,
            'bencanaNegeri' => $bencanaNegeri->pluck('id_negeri')
        ], 200);
    }

    public function getRefBencanaForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'tarikh_bencana', 'tahun_bencana', 'id_jenis_bencana', 'nama_bencana', 'catatan', 'status_bencana'
        ];

        $data = DB::table('ref_bencana')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where('status_bencana', '=', 1)
            ->select($columns)
            ->orderByDesc('tarikh_bencana')
            ->get();

        return response()->json([
            'items' => $data
        ], 200);
    }

    public function createOrEdit(Request $request)
    {
        $bencana = $request->bencana;

        if ($bencana['id'] ?? false) {
            $refBencana = $this->update($request);
        } else {
            $refBencana = $this->create($request);
        }

        return $refBencana;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'bencana.tarikh_bencana' => 'required',
            'bencana.id_jenis_bencana' => 'required|numeric',
            'bencana.nama_bencana' => 'required|string',
            'id_negeri' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bencana = $request->bencana;
        $bencanaNegeri = $request->id_negeri;

        $generate = new GenerateController;
        $running_no = $generate->getBencanaRunningNo();

        try {
            DB::beginTransaction();

            $refBencana = RefBencana::create([
                'no_rujukan_bencana' => $running_no,
                'tarikh_bencana' => $bencana['tarikh_bencana'],
                'id_jenis_bencana' => $bencana['id_jenis_bencana'],
                'nama_bencana' => $bencana['nama_bencana'],
                'catatan' => $bencana['catatan'] ?? null,
                'status_bencana' =>  1,
            ]);

            $refBencana->save();

            foreach ($bencanaNegeri as $bencana_negeri) {
                $refBencanaNegeri = RefBencanaNegeri::create([
                    'id_bencana' => $refBencana->id,
                    'id_negeri' => $bencana_negeri,
                    'status_bencana_negeri' => 1,
                    'tarikh_cipta' => Carbon::now(),
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                ]);

                $refBencanaNegeri->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json($refBencana, 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'bencana.id' => 'required',
            'bencana.tarikh_bencana' => 'required',
            'bencana.tahun_bencana' => 'required',
            'bencana.id_jenis_bencana' => 'required|numeric',
            'bencana.nama_bencana' => 'required|string',
            'bencana.status_bencana' => 'required|numeric',
            'id_negeri' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();
        $bencana = $request->bencana;
        $bencanaNegeri = $request->id_negeri;

        try {
            DB::beginTransaction();

            $refBencana = RefBencana::where([['id', $bencana['id']]])->first();

            $refBencana->tarikh_bencana =  $bencana['tarikh_bencana'];
            $refBencana->tahun_bencana = $bencana['tahun_bencana'];
            $refBencana->id_jenis_bencana = $bencana['id_jenis_bencana'];
            $refBencana->nama_bencana = $bencana['nama_bencana'];
            $refBencana->catatan = $bencana['catatan'];
            $refBencana->status_bencana = $bencana['status_bencana'];

            $refBencana->save();

            if ($bencanaNegeri != []) {
                if (is_array($request->id_negeri)) {
                    $negeri = RefBencanaNegeri::where('id_bencana', $refBencana->id)->get()->pluck('id_negeri')->toArray();
                    $add = array_unique(array_diff($request->id_negeri, $negeri));
                    $remove = array_unique(array_diff($negeri, $request->id_negeri));

                    if ($remove != []) {
                        $bencanaBwi = TabungBwi::where([['id_bencana', $refBencana->id]])->first();
                        if ($bencanaBwi) {
                            return response()->json(['message' => 'Bencana Terdapat di Dalam Tabung Bantuan Wang Ihsan'], 200);
                        }
                    }

                    foreach ($add as $a) {
                        $refBencanaNegeri = RefBencanaNegeri::create([
                            'id_bencana' => $refBencana->id,
                            'id_negeri' => $a,
                            'status_bencana_negeri' => 1,
                            'tarikh_cipta' => Carbon::now(),
                            'id_pengguna_cipta' => $user->id,
                        ]);

                        $refBencanaNegeri->save();
                    }

                    foreach ($remove as $r) {
                        RefBencanaNegeri::where('id_bencana', $refBencana->id)->where('id_negeri', $r)->delete();
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message' => 'Bencana Berjaya Dikemaskini'], 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bencana = RefBencana::where('id', $request->id)->first();
        $mangsaBencana = MangsaBencana::where('id_bencana', $bencana->id)->first();
        $bayaranTerus = TabungBayaranTerus::where('id_bencana', $bencana->id)->first();
        $bayaranSkb = TabungBayaranSkb::where('id_bencana', $bencana->id)->first();
        $bayaranBwi = TabungBwi::where('id_bencana', $bencana->id)->first();

        if ($mangsaBencana) {
            return response()->json(["message" => "Bencana $bencana->nama_bencana - $bencana->tarikh_bencana Sudah Mempunyai Mangsa"], 200);

        }else if($bayaranTerus){
            return response()->json(["message" => "Bencana $bencana->nama_bencana - $bencana->tarikh_bencana Sudah Mempunyai Bayaran Terus"], 200);

        }else if($bayaranSkb){
            return response()->json(["message" => "Bencana $bencana->nama_bencana - $bencana->tarikh_bencana Sudah Mempunyai Bayaran SKB"], 200);

        }else if($bayaranBwi){
            return response()->json(["message" => "Bencana $bencana->nama_bencana - $bencana->tarikh_bencana Sudah Mempunyai Bantuan Wang Ihsan"], 200);

        }
         else {
            $bencana->delete();

            return response()->json(["message" => "Bencana Berjaya Dibuang"], 200);
        }
    }
}
