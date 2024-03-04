<?php

namespace App\Http\Controllers;

use App\Models\MangsaWangIhsan;
use App\Models\Tabung;
use App\Models\TabungBwi;
use App\Models\TabungBwiBayaran;
use App\Models\TabungBwiKawasan;
use App\Models\TabungKelulusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;


class TabungBwiController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bwi.id desc';
        $filter = $request->filter;
        $filterJenisBwi = $request->filterJenisBwi;
        $filterBencana = $request->filterBencana;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'tbl_tabung_bwi.id', 'id_jenis_bwi', 'id_bencana',
            'no_rujukan_bwi', 'nama_jenis_bwi', 'nama_bencana', 'tarikh_bencana'
        ];

        $data = DB::table('tbl_tabung_bwi')
            ->join('ref_jenis_bwi', 'tbl_tabung_bwi.id_jenis_bwi', 'ref_jenis_bwi.id')
            ->leftJoin('ref_bencana', 'tbl_tabung_bwi.id_bencana', 'ref_bencana.id')
            ->select('tbl_tabung_bwi.id', 'id_jenis_bwi', 'id_bencana',
            'no_rujukan_bwi', 'nama_jenis_bwi', 'nama_bencana', 'tarikh_bencana',
            DB::raw('coalesce((select count(distinct id_negeri) from tbl_tabung_bwi_kawasan where id_tabung_bwi = tbl_tabung_bwi.id), 0.00) as jumlah_negeri'),
            DB::raw('coalesce((select sum(jumlah_bwi) from tbl_tabung_bwi_kawasan where id_tabung_bwi = tbl_tabung_bwi.id), 0.00) as jumlah_bayaran_bwi') )
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterJenisBwi) {
                $query->when($filterJenisBwi, function ($query, $filterJenisBwi) {
                    return $query->where('tbl_tabung_bwi.id_jenis_bwi', $filterJenisBwi);
                });
            })
            ->where(function ($query) use ($filterBencana) {
                $query->when($filterBencana, function ($query, $filterBencana) {
                    return $query->where('tbl_tabung_bwi.id_bencana', $filterBencana);
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


    public function getTabungBwiForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bwi = TabungBwi::where('id', $request->id)->first();

        $columns = [
            'tbl_tabung_bwi.id', 'id_jenis_bwi', 'id_bencana',
            'no_rujukan_bwi', 'nama_jenis_bwi', 'nama_bencana', 'tarikh_bencana'
        ];

        $tabung_bwi = DB::table('tbl_tabung_bwi')
        ->join('ref_jenis_bwi', 'tbl_tabung_bwi.id_jenis_bwi', 'ref_jenis_bwi.id')
        ->leftJoin('ref_bencana', 'tbl_tabung_bwi.id_bencana', 'ref_bencana.id')
        ->where('tbl_tabung_bwi.id', $request->id)
        ->select($columns)
        ->first();

        $jumlah_keseluruhan = DB::table('tbl_tabung_bwi_kawasan')
        ->where('tbl_tabung_bwi_kawasan.id_tabung_bwi', $request->id)
        ->select(DB::raw('sum(tbl_tabung_bwi_kawasan.jumlah_bwi) as jumlah'))
        ->pluck('jumlah')
        ->first();

        $jumlah_dipulangkan = DB::table('tbl_mangsa_wang_ihsan')
        ->where('tbl_mangsa_wang_ihsan.id_bencana', $bwi->id_bencana)
        ->select(DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah_dipulangkan) as jumlah'))
        ->pluck('jumlah')
        ->first();


        return response()->json([
            'tabung_bwi' => $tabung_bwi,
            'jumlah_keseluruhan' => $jumlah_keseluruhan ?? '0.00',
            'jumlah_dipulangkan' => $jumlah_dipulangkan ?? '0.00'
        ], 200);
    }

    public function createOrEdit(Request $request)
    {
        $bwi = $request->bwi;

        if ($bwi['id'] ?? false) {
            $bantuanWangIhsan = $this->update($request);
        } else {
            $bantuanWangIhsan = $this->create($request);
        }

        return $bantuanWangIhsan;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'bwi.id_jenis_bwi' => 'required|numeric',
            'bwi.id_bencana' => 'required|numeric',
            'bwi_kawasan' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bantuanWangIhsan = $request->bwi;
        $bantuanWangIhsanBayaran = $request->bwi_bayaran;
        $bantuanWangIhsanKawasan = $request->bwi_kawasan;

        $generate = new GenerateController;
        $running_no = $generate->getBantuanWangIhsanRunningNo();
        try {
            DB::beginTransaction();

            $tabungBwi = TabungBwi::create([
                'no_rujukan_bwi' => $running_no,
                'id_jenis_bwi' => $bantuanWangIhsan['id_jenis_bwi'],
                'id_bencana' => $bantuanWangIhsan['id_bencana'],
                'id_pengguna_cipta' => JWTAuth::user()->id,
                'tarikh_cipta' => Carbon::now()
            ]);

            $tabungBwi->save();

            if($bantuanWangIhsanBayaran){
                foreach($bantuanWangIhsanBayaran as $bwi_bayaran){
                    $bwiBayaran = TabungBwiBayaran::create([
                        'id_tabung_bwi' => $tabungBwi->id,
                        'id_tabung_bayaran_skb' =>  $bwi_bayaran['id_skb'] ?? null,
                        'id_tabung_bayaran_terus' => $bwi_bayaran['id_terus'] ?? null,
                        'id_pengguna_cipta' => JWTAuth::user()->id,
                        'tarikh_cipta' => Carbon::now(),
                        'id_kelulusan' => $request->id_kelulusan
                    ]);
                    $bwiBayaran->save();
                }
            }

            foreach($bantuanWangIhsanKawasan as $bwi_kawasan){
                $bwiKawasan = TabungBwiKawasan::create([
                    'id_tabung_bwi' => $tabungBwi->id,
                    'id_daerah' =>  $bwi_kawasan['id_daerah'],
                    'id_negeri' => $bwi_kawasan['id_negeri'],
                    'jumlah_bwi' => $bwi_kawasan['jumlah_bwi'],
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now()
                ]);

                $bwiKawasan->save();

                $mangsaBwi = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', $tabungBwi->id_bencana)
                ->where('id_jenis_bwi', $tabungBwi->id_jenis_bwi)
                ->where('id_daerah', $bwi_kawasan['id_daerah'])
                ->where('status_mangsa_wang_ihsan', 3)
                ->where('id_dipulangkan', 2)
                ->get();


                if($bantuanWangIhsanBayaran){
                    if($mangsaBwi != []){
                        $tabungKelulusan = TabungKelulusan::where('id', $request->id_kelulusan)->first();
                        $tabung = Tabung::where('id', $tabungKelulusan->id_tabung)->first();

                        foreach($mangsaBwi as $mangsa){
                            $mangsaWangIhsan = MangsaWangIhsan::where('id', $mangsa->id)->first();
                            $mangsaWangIhsan->id_dipulangkan = 1;
                            $mangsaWangIhsan->save();
                        }

                        $totalBwi = $mangsaBwi->toArray();
                        $jumlahPulang = array_sum(array_column($totalBwi, 'jumlah_dipulangkan'));
                        $tabungKelulusan->baki_jumlah_siling = $tabungKelulusan->baki_jumlah_siling + $jumlahPulang;
                        $tabungKelulusan->jumlah_dipulangkan = $tabungKelulusan->jumlah_dipulangkan + $jumlahPulang;
                        $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $jumlahPulang;
                        $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $jumlahPulang;

                        $tabungKelulusan->save();
                        $tabung->save();
                    }
                }
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
            'bwi.id_jenis_bwi' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $bantuanWangIhsan = $request->bwi;

        $tabungBwi = TabungBwi::where('id', $bantuanWangIhsan['id'])->first();
        $tabungBwi->id_jenis_bwi = $bantuanWangIhsan['id_jenis_bwi'];
        $tabungBwi->id_bencana = $bantuanWangIhsan['id_bencana'];
        $tabungBwi->id_pengguna_kemaskini = JWTAuth::user()->id;
        $tabungBwi->tarikh_kemaskini = Carbon::now();

        $tabungBwi->save();


        return response()->json($tabungBwi, 200);
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

        $bwi = TabungBwi::where('id', $request->id)->first();

        $mangsa = DB::Table('tbl_tabung_bwi')
        ->where('tbl_tabung_bwi.id', $request->id)
        ->join('tbl_tabung_bwi_kawasan', 'tbl_tabung_bwi.id', 'tbl_tabung_bwi_kawasan.id_tabung_bwi')
        ->join('tbl_mangsa_wang_ihsan', function ($join) {
            $join->on('tbl_mangsa_wang_ihsan.id_bencana', '=', 'tbl_tabung_bwi.id_bencana');
            $join->on('tbl_mangsa_wang_ihsan.id_jenis_bwi', '=', 'tbl_tabung_bwi.id_jenis_bwi');
            $join->on('tbl_mangsa_wang_ihsan.id_daerah', '=', 'tbl_tabung_bwi_kawasan.id_daerah');
        })
        ->select('id_mangsa')
        ->get();

        $mangsa->toArray();
        $mangsaCount =  count($mangsa);

        if ($mangsaCount > 0) {
            return response()->json(["message" => "Terdapat Bil. Kir di Dalam Bantuan Wang Ihsan"], 200);

        } else {

            $bwi->delete();
            return response()->json(["message" => "Bantuan Wang Ihsan Berjaya Dibuang"], 200);
        }
    }
}
