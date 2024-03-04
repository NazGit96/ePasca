<?php

namespace App\Http\Controllers;

use App\Models\TabungBwiBayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungBwiBayaranController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;

        $columns = [
            'id', 'id_tabung_bwi', 'id_tabung_bayaran_skb', 'id_tabung_bayaran_terus', 'tarikh_cipta', 'id_pengguna_cipta', 'hapus', 'tarikh_hapus', 'id_pengguna_hapus'
        ];

        $data = DB::table('tbl_tabung_bwi_bayaran')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
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
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getAllBwiBayaranTerus(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bwi_bayaran.id asc';
        $filter = $request->filter;
        $filterIdBwi = $request->filterIdBwi ?? null;

        $columns = [
            'tbl_tabung_bwi_bayaran.id', 'id_tabung_bwi', 'id_tabung_bayaran_skb', 'id_tabung_bayaran_terus', 'no_rujukan_terus', 'no_rujukan_kelulusan',
            'tbl_tabung_bayaran_terus.jumlah', 'tbl_tabung_bayaran_terus.perihal'
        ];

        $data = DB::table('tbl_tabung_bwi_bayaran')
            ->join('tbl_tabung_bayaran_terus', 'tbl_tabung_bwi_bayaran.id_tabung_bayaran_terus', 'tbl_tabung_bayaran_terus.id')
            ->leftJoin('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->select($columns)
            ->where('id_tabung_bwi', $filterIdBwi)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
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
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getAllBwiBayaranSkb(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bwi_bayaran.id asc';
        $filter = $request->filter;
        $filterIdBwi = $request->filterIdBwi ?? null;

        $columns = [
            'tbl_tabung_bwi_bayaran.id', 'id_tabung_bwi', 'id_tabung_bayaran_skb', 'id_tabung_bayaran_terus', 'no_rujukan_skb', 'no_rujukan_kelulusan',
            'tbl_tabung_bayaran_skb.jumlah_siling_peruntukan as jumlah', 'tbl_tabung_bayaran_skb.perihal'
        ];

        $data = DB::table('tbl_tabung_bwi_bayaran')
            ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_bwi_bayaran.id_tabung_bayaran_skb', 'tbl_tabung_bayaran_skb.id')
            ->leftJoin('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->select($columns)
            ->where('id_tabung_bwi', $filterIdBwi)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
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
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getAllBayaranSkbDanTerus(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bwi_bayaran.id desc';
        $filter = $request->filter;
        $filterBwi = $request->filterBwi;

        $columns = [
            'tbl_tabung_bwi_bayaran.id as id_tabung_bayaran', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan as id_tabung_kelulusan', 'tbl_tabung_bayaran_terus.id as id_bayaran_terus', 'no_rujukan_terus', 'perihal', 'no_rujukan_kelulusan', 'jumlah', 'id_tabung_bayaran_skb', 'id_tabung_bayaran_terus'
        ];

        $data = DB::table('tbl_tabung_bwi_bayaran')
            ->leftJoin('tbl_tabung_bayaran_terus', 'tbl_tabung_bwi_bayaran.id_tabung_bayaran_terus', 'tbl_tabung_bayaran_terus.id')
            ->leftJoin('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->where('tbl_tabung_bwi_bayaran.id_tabung_bwi', $filterBwi)
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            });

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $belanjaSkb = DB::Table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->whereIn('tbl_tabung_bayaran_skb.id', $result->unique('id_tabung_bayaran_skb')->pluck('id_tabung_bayaran_skb'))
            ->select(['tbl_tabung_bayaran_skb.id_tabung_kelulusan as id_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id as id_bayaran_skb', 'tbl_tabung_bayaran_skb.id', 'no_rujukan_skb', 'perihal', 'no_rujukan_kelulusan', 'jumlah_siling_peruntukan'])
            ->get();

        $data = array();
        $jumlah_keseluruhan_bayaran = 0;

        foreach ($result as $bwi) {
            $item = array();
            $item['id_tabung_bayaran'] = $bwi->id_tabung_bayaran;
            $item['id_tabung_kelulusan'] = $bwi->id_tabung_kelulusan;
            $item['id_bayaran_terus'] = $bwi->id_bayaran_terus;
            $item['no_rujukan_bayaran'] = $bwi->no_rujukan_terus;
            $item['perihal'] = $bwi->perihal;
            $item['no_rujukan_kelulusan'] = $bwi->no_rujukan_kelulusan;
            $item['jumlah'] = $bwi->jumlah;
            $jumlah_keseluruhan_bayaran = $jumlah_keseluruhan_bayaran + $bwi->jumlah;
            if($item['no_rujukan_bayaran']){
                $data[] = $item;
            }
        }

        foreach ($result as $bwi) {
            $item = array();
            $item['id_tabung_bayaran'] = $bwi->id_tabung_bayaran;
            $item['id_tabung_kelulusan'] = $belanjaSkb->where('id', $bwi->id_tabung_bayaran_skb)->pluck('id_tabung_kelulusan')->first();
            $item['id_bayaran_skb'] = $belanjaSkb->where('id', $bwi->id_tabung_bayaran_skb)->pluck('id_bayaran_skb')->first();
            $item['no_rujukan_bayaran'] = $belanjaSkb->where('id', $bwi->id_tabung_bayaran_skb)->pluck('no_rujukan_skb')->first();
            $item['perihal'] = $belanjaSkb->where('id', $bwi->id_tabung_bayaran_skb)->pluck('perihal')->first();
            $item['no_rujukan_kelulusan'] = $belanjaSkb->where('id', $bwi->id_tabung_bayaran_skb)->pluck('no_rujukan_kelulusan')->first();
            $item['jumlah'] = $belanjaSkb->where('id', $bwi->id_tabung_bayaran_skb)->pluck('jumlah_siling_peruntukan')->first();
            $jumlah_keseluruhan_bayaran = $jumlah_keseluruhan_bayaran + $belanjaSkb->where('id', $bwi->id_tabung_bayaran_skb)->pluck('jumlah_siling_peruntukan')->first();
            if($item['no_rujukan_bayaran']){
            $data[] = $item;
            }
        }


        $totalCount = count($data);

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $data,
            'jumlah_keseluruhan_bayaran' => $jumlah_keseluruhan_bayaran
        ], 200);
    }

    public function getTabungBwiBayaranForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBwiBayaran = TabungBwiBayaran::where('id', $request->id)->first();
        return response()->json(['tabung_bwi_bayaran' => $tabungBwiBayaran], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $tabungBwiBayaran = $this->update($request);
        } else {
            $tabungBwiBayaran = $this->create($request);
        }

        return $tabungBwiBayaran;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_tabung_bwi' => 'required|numeric',
            'bwi_bayaran' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bantuanWangIhsanBayaran = $request->bwi_bayaran;

        try {
            DB::beginTransaction();

            foreach($bantuanWangIhsanBayaran as $bwi_bayaran){
                $bwiBayaran = TabungBwiBayaran::create([
                    'id_tabung_bwi' => $request->id_tabung_bwi,
                    'id_tabung_bayaran_skb' =>  $bwi_bayaran['id_tabung_bayaran_skb'] ?? null,
                    'id_tabung_bayaran_terus' => $bwi_bayaran['id_tabung_bayaran_terus'] ?? null,
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now(),
                    'id_kelulusan' => $request->id_kelulusan
                ]);

                $bwiBayaran->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message' => 'Maklumat Berjaya Ditambah!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBwiBayaran = TabungBwiBayaran::where('id', $request->id)->first();

        $tabungBwiBayaran->id_tabung_bwi = $request->id_tabung_bwi;
        $tabungBwiBayaran->id_tabung_bayaran_skb = $request->id_tabung_bayaran_skb;
        $tabungBwiBayaran->id_tabung_bayaran_terus = $request->id_tabung_bayaran_terus;

        $tabungBwiBayaran->save();

        return response()->json($tabungBwiBayaran, 200);
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

        try {
            DB::beginTransaction();

            $bwiBayaran = TabungBwiBayaran::where('id', $request->id)->first();
            $bwiBayaran->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }
        return response()->json(["message" => "Pembayaran Wang Ihsan Berjaya Dibuang"], 200);
    }
}
