<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungBayaranSkb;
use App\Models\TabungBayaranTerus;
use App\Models\TabungKelulusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungKelulusanController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterTabung = $request->filterTabung;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'tbl_tabung_kelulusan.id', 'no_rujukan_kelulusan', 'id_tabung', 'nama_tabung', 'rujukan_surat',
            'tarikh_surat', 'jumlah_siling', 'tarikh_mula_kelulusan', 'tarikh_tamat_kelulusan', 'peruntukan', 'status_tabung',
            'perihal_surat', 'status_tabung_kelulusan', 'baki_jumlah_siling', 'jumlah_dipulangkan', 'kategori_tabung'
        ];

        $data = DB::table('tbl_tabung_kelulusan')
            ->select($columns)
            ->leftJoin('tbl_tabung','tbl_tabung_kelulusan.id_tabung','=','tbl_tabung.id')
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterTabung){
                $query->when($filterTabung, function($query, $filterTabung){
                    return $query->where('tbl_tabung_kelulusan.id_tabung', $filterTabung);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tarikh_mula_kelulusan', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tarikh_tamat_kelulusan', '<=', Carbon::parse($filterToDate)->endOfDay());
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

        $belanjaTerus = DB::Table('tbl_tabung_bayaran_terus')
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $belanjaSkb = DB::Table('tbl_tabung_bayaran_skb')
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah_siling_peruntukan) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $belanjaWaran = DB::Table('tbl_tabung_bayaran_waran')
            ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
            ->where('id_status_waran', 1)
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(jumlah_siling_peruntukan) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $belanjaWaranTidakAktif = DB::Table('tbl_tabung_bayaran_waran')
            ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
            ->join('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
            ->where('id_status_waran', 2)
            ->whereIn('id_tabung_kelulusan', $result->unique('id')->pluck('id'))
            ->select(['id_tabung_kelulusan', DB::raw('sum(tbl_tabung_bayaran_waran_bulanan.jumlah) as jumlah')])
            ->groupBy('id_tabung_kelulusan')
            ->get();

        $data = array();
        foreach ($result as $kelulusan) {
            $item = array();
            $item['kelulusan'] = $kelulusan;
            $item['belanja'] = $belanjaTerus->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $belanjaSkb->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() +
            $belanjaWaran->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first() + $belanjaWaranTidakAktif->where('id_tabung_kelulusan', $kelulusan->id)->pluck('jumlah')->first();
            $data[] = $item;
        }

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $data,
        ], 200);
    }

    public function getKategoriTabungBayaranTerusByKelulusan(Request $request){
        $filterIdKelulusan = $request->filterIdKelulusan;

        $terusCovid = DB::table('tbl_tabung_kelulusan')
        ->where('tbl_tabung_kelulusan.id', $filterIdKelulusan)
        ->select(
            DB::raw('coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 1), 0.00) as jumlah_covid'),
            DB::raw('coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 2), 0.00) as jumlah_bukan_covid')
            )
        ->first();

        $data = array();
        $result = array();
        $item = array();

        $result = array("kategori" => "Covid", "jumlah" => $terusCovid->jumlah_covid);
        $data[] = $result;

        $result = array("kategori" => "Bukan Covid", "jumlah" => $terusCovid->jumlah_bukan_covid);
        $data[] = $result;

        $item['tabung'] = $data;

        $totalCount = count($data);

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $data
        ], 200);
    }

    public function getKategoriTabungSkbByKelulusan(Request $request){
        $filterIdKelulusan = $request->filterIdKelulusan;

        $skbCovid = DB::table('tbl_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_kelulusan.id', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
        ->where('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $filterIdKelulusan)
        ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 1)
        ->select(DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        $skbBukanCovid = DB::table('tbl_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_kelulusan.id', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
        ->where('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $filterIdKelulusan)
        ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 2)
        ->select(DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        $data = array();
        $result = array();
        $item = array();

        $result = array("kategori" => "Covid", "jumlah" => $skbCovid);
        $data[] = $result;

        $result = array("kategori" => "Bukan Covid", "jumlah" => $skbBukanCovid);
        $data[] = $result;

        $item['tabung'] = $data;

        $totalCount = count($data);

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $data
        ], 200);
    }

    public function getKategoriTabungWaranByKelulusan(Request $request){
        $filterIdKelulusan = $request->filterIdKelulusan;

        $waranCovid = DB::table('tbl_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_waran', 'tbl_tabung_kelulusan.id', 'tbl_tabung_bayaran_waran.id_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
        ->where('tbl_tabung_bayaran_waran.id_tabung_kelulusan', $filterIdKelulusan)
        ->where('tbl_tabung_bayaran_waran.id_kategori_bayaran', 1)
        ->select(DB::raw('sum(tbl_tabung_bayaran_waran_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        $waranBukanCovid = DB::table('tbl_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_waran', 'tbl_tabung_kelulusan.id', 'tbl_tabung_bayaran_waran.id_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
        ->where('tbl_tabung_bayaran_waran.id_tabung_kelulusan', $filterIdKelulusan)
        ->where('tbl_tabung_bayaran_waran.id_kategori_bayaran', 2)
        ->select(DB::raw('sum(tbl_tabung_bayaran_waran_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        $data = array();
        $result = array();
        $item = array();

        $result = array("kategori" => "Covid", "jumlah" => $waranCovid);
        $data[] = $result;

        $result = array("kategori" => "Bukan Covid", "jumlah" => $waranBukanCovid);
        $data[] = $result;

        $item['tabung'] = $data;

        $totalCount = count($data);

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $data
        ], 200);
    }

    public function getKategoriTabungByKelulusan(Request $request){
        $filterIdKelulusan = $request->filterIdKelulusan;

        $terusCovid = DB::table('tbl_tabung_kelulusan')
        ->where('tbl_tabung_kelulusan.id', $filterIdKelulusan)
        ->select(
            DB::raw('coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 1), 0.00) as jumlah_covid'),
            DB::raw('coalesce((select sum(jumlah) from tbl_tabung_bayaran_terus where id_tabung_kelulusan = tbl_tabung_kelulusan.id and id_kategori_bayaran = 2), 0.00) as jumlah_bukan_covid')
            )
        ->first();

        $skbCovid = DB::table('tbl_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_kelulusan.id', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
        ->where('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $filterIdKelulusan)
        ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 1)
        ->select(DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        $skbBukanCovid = DB::table('tbl_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_kelulusan.id', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan')
        ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
        ->where('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $filterIdKelulusan)
        ->where('tbl_tabung_bayaran_skb.id_kategori_bayaran', 2)
        ->select(DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        $data = array();
        $result = array();
        $item = array();

        $result = array("kategori" => "Covid", "jumlah" => $terusCovid->jumlah_covid + $skbCovid);
        $data[] = $result;

        $result = array("kategori" => "Bukan Covid", "jumlah" => $terusCovid->jumlah_bukan_covid + $skbBukanCovid);
        $data[] = $result;

        $item['tabung'] = $data;

        $totalCount = count($data);

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $data
        ], 200);
    }

    public function getAllKelulusanForLookupTable(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_kelulusan.id desc';
        $filter = $request->filter;
        $filterTabung = $request->filterTabung;
        $filterKategori = $request->filterKategori;

        $columns = [
            'tbl_tabung_kelulusan.id', 'no_rujukan_kelulusan', 'nama_tabung', 'jumlah_siling', 'baki_jumlah_siling', 'perihal_surat'
        ];

        $data = DB::table('tbl_tabung_kelulusan')
            ->join('tbl_tabung','tbl_tabung_kelulusan.id_tabung','=','tbl_tabung.id')
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterTabung){
                $query->when($filterTabung, function($query, $filterTabung){
                    return $query->where('tbl_tabung_kelulusan.id_tabung', $filterTabung);
                });
            })
            ->where(function($query) use ($filterKategori){
                $query->when($filterKategori, function($query, $filterKategori){
                    return $query->where('tbl_tabung.kategori_tabung', $filterKategori);
                });
            })
            ->select($columns);

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

    public function getTabungKelulusanForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungKelulusan = TabungKelulusan::where('id', $request->id)->first();
        $tabung = Tabung::where('id', $tabungKelulusan->id_tabung)->first();

        return response()->json([
            'tabung_kelulusan'=> $tabungKelulusan,
            'kategori_tabung' => $tabung->kategori_tabung
        ], 200);
    }

    public function getBelanjaByKelulusan(Request $request)
    {
        $filterYear = $request->filterYear ?? Carbon::now()->year;
        $filterPastYear = $request->filterPastYear ?? Carbon::now()->year - 1;

        $belanjaTerusSemasa = DB::table('tbl_tabung_bayaran_terus')
            ->where('id_tabung_kelulusan', $request->id)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh_cipta)'), '=', $filterYear)
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $belanjaSkbSemasa = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('id_tabung_kelulusan', $request->id)
            ->where('tbl_tabung_bayaran_skb_bulanan.tahun', $filterYear)
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $belanjaTerusSebelum = DB::table('tbl_tabung_bayaran_terus')
            ->where('id_tabung_kelulusan', $request->id)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh_cipta)'), '=', $filterPastYear)
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $belanjaSkbSebelum = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('id_tabung_kelulusan', $request->id)
            ->where('tbl_tabung_bayaran_skb_bulanan.tahun', $filterPastYear)
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $totalBelanjaTerus = DB::table('tbl_tabung_bayaran_terus')
            ->where('id_tabung_kelulusan', $request->id)
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $totalBelanjaSkb = DB::table('tbl_tabung_bayaran_skb')
            ->where('id_tabung_kelulusan', $request->id)
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

            return response()->json([
                'belanjaSemasa' => $belanjaTerusSemasa + $belanjaSkbSemasa,
                'belanjaSebelum' => $belanjaTerusSebelum + $belanjaSkbSebelum,
                'jumlahBelanja' => $totalBelanjaTerus + $totalBelanjaSkb
            ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $tabungKelulusan = $this->update($request);
        }else{
            $tabungKelulusan = $this->create($request);
        }

        return $tabungKelulusan;
    }

    private function create($request){
        $validator = Validator::make($request->all(), [
            'jumlah_siling' => 'required',
            'tarikh_mula_kelulusan' => 'required',
            'tarikh_surat' => 'required',
            'rujukan_surat' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $generate = new GenerateController;
        $running_no = $generate->getKelulusanRunningNo();

        try {
            DB::beginTransaction();

            $tabung = Tabung::where('id', $request->id_tabung)->first();
            $tabung->peruntukan = $tabung->peruntukan + $request->jumlah_siling;

            if($tabung->peruntukan <= $tabung->jumlah_keseluruhan){

                $tabungKelulusan = TabungKelulusan::create([
                    'no_rujukan_kelulusan' => $running_no,
                    'id_tabung' => $request->id_tabung,
                    'id_bantuan' => $request->id_bantuan ?? null,
                    'id_komitmen' => $request->id_komitmen ?? null,
                    'rujukan_surat' => $request->rujukan_surat,
                    'tarikh_surat' => $request->tarikh_surat,
                    'tarikh_mula_kelulusan' => $request->tarikh_mula_kelulusan,
                    'tarikh_tamat_kelulusan' => $request->tarikh_tamat_kelulusan ?? null,
                    'jumlah_siling' => $request->jumlah_siling,
                    'baki_jumlah_siling' => $request->jumlah_siling,
                    'status_tabung_kelulusan' => 1,
                    'perihal_surat' => $request->perihal_surat ?? null,
                    'rujukan' => $request->rujukan ?? null,
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now(),
                    'hapus' => false
                ]);

                $tabungKelulusan->save();
                $tabung->save();

            }else{
                return response()->json(['message' => 'Jumlah Peruntukan Melebihi Jumlah Keseluruhan Tabung'], 200);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message'=> 'Maklumat Kelulusan Berjaya Ditambah!'], 200);
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

        try {
        DB::beginTransaction();

        $tabungKelulusan = TabungKelulusan::where('id', $request->id)->first();

        if($tabungKelulusan->jumlah_siling != $request->jumlah_siling){
            $tabung = Tabung::where('id', $tabungKelulusan->id_tabung)->first();

            $terus = DB::Table('tbl_tabung_bayaran_terus')
            ->where('id_tabung_kelulusan', $tabungKelulusan->id)
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

            $skb = DB::Table('tbl_tabung_bayaran_skb')
            ->where('id_tabung_kelulusan', $tabungKelulusan->id)
            ->select(DB::raw('sum(jumlah_siling_peruntukan) as jumlah'))
            ->pluck('jumlah')
            ->first();

            $waran = DB::Table('tbl_tabung_bayaran_waran')
            ->where('id_tabung_kelulusan', $tabungKelulusan->id)
            ->select(DB::raw('sum(jumlah_siling_peruntukan) as jumlah'))
            ->pluck('jumlah')
            ->first();

            $belanja = $terus + $skb + $waran;

            if($request->jumlah_siling < $belanja){
                return response()->json(['message'=> 'Jumlah Belanja Melebihi Jumlah Kelulusan yang Dikemaskini'], 200);
            }else{
                $tabung->peruntukan = $tabung->peruntukan - $tabungKelulusan->jumlah_siling;
                $tabung->peruntukan = $tabung->peruntukan + $request->jumlah_siling;

                if($tabung->peruntukan > $tabung->jumlah_keseluruhan){
                    return response()->json(['message'=> 'Jumlah Kelulusan yang Dikemaskini Melebihi Jumlah Keseluruhan Tabung'], 200);
                }else{
                    $tabung->save();
                    $tabungKelulusan->baki_jumlah_siling = $request->jumlah_siling;
                    $tabungKelulusan->baki_jumlah_siling = $tabungKelulusan->baki_jumlah_siling - $belanja;
                }

            }
        }

        $tabungKelulusan->no_rujukan_kelulusan = $request->no_rujukan_kelulusan;
        $tabungKelulusan->id_bantuan = $request->id_bantuan;
        $tabungKelulusan->id_tabung = $request->id_tabung;
        $tabungKelulusan->id_komitmen = $request->id_komitmen;
        $tabungKelulusan->rujukan_surat = $request->rujukan_surat;
        $tabungKelulusan->tarikh_surat = $request->tarikh_surat;
        $tabungKelulusan->jumlah_siling = $request->jumlah_siling;
        $tabungKelulusan->tarikh_mula_kelulusan = $request->tarikh_mula_kelulusan;
        $tabungKelulusan->tarikh_tamat_kelulusan = $request->tarikh_tamat_kelulusan;
        $tabungKelulusan->perihal_surat = $request->perihal_surat;
        $tabungKelulusan->rujukan = $request->rujukan;
        $tabungKelulusan->status_tabung_kelulusan = $request->status_tabung_kelulusan;
        $tabungKelulusan->id_pengguna_kemaskini = JWTAuth::user()->id;
        $tabungKelulusan->tarikh_kemaskini = Carbon::now();

        $tabungKelulusan->save();

        DB::commit();
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json(['message' => $e->getMessage()], 500);
    }

    return response()->json(['message'=> 'Maklumat Kelulusan Berjaya Dikemaskini'], 200);
}

    public function getSkbByIdKelulusan(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterKelulusan = $request->filterKelulusan;

        $columns = [
            'tbl_tabung_bayaran_skb.id','no_rujukan_skb', 'jumlah_siling_peruntukan'
        ];

        $data = DB::table('tbl_tabung_bayaran_skb')
            ->where('id_tabung_kelulusan', $filterKelulusan)
            ->select('tbl_tabung_bayaran_skb.id','tbl_tabung_bayaran_skb.no_rujukan_skb', 'tbl_tabung_bayaran_skb.jumlah_siling_peruntukan', DB::raw("
            (coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id), 0.00))
            as jumlah"))
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
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

        $total_skb = DB::table('tbl_tabung_bayaran_skb')
        ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
        ->where('id_tabung_kelulusan', $filterKelulusan)
        ->select(DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        return response()->json([
            'total_count'=>$totalCount,
            'total_skb'=>$total_skb,
            'items'=> $result
        ], 200);
    }

    public function getWaranByIdKelulusan(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterKelulusan = $request->filterKelulusan;

        $columns = [
            'id','no_rujukan_waran', 'jumlah_siling_peruntukan'
        ];

        $data = DB::table('tbl_tabung_bayaran_waran')
            ->where('id_tabung_kelulusan', $filterKelulusan)
            ->select('tbl_tabung_bayaran_waran.id','tbl_tabung_bayaran_waran.no_rujukan_waran', 'tbl_tabung_bayaran_waran.jumlah_siling_peruntukan', DB::raw("
            (coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id), 0.00))
            as jumlah"))
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
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

        $total_skb = DB::table('tbl_tabung_bayaran_waran')
        ->join('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
        ->where('id_tabung_kelulusan', $filterKelulusan)
        ->select(DB::raw('sum(tbl_tabung_bayaran_waran_bulanan.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        return response()->json([
            'total_count'=>$totalCount,
            'total_waran'=>$total_skb,
            'items'=> $result
        ], 200);
    }

    public function getBayaranTerusByIdKelulusan(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id asc';
        $filter = $request->filter;
        $filterKelulusan = $request->filterKelulusan;

        $columns = [
            'id','no_rujukan_terus', 'jumlah'
        ];

        $data = DB::table('tbl_tabung_bayaran_terus')
            ->where('id_tabung_kelulusan', $filterKelulusan)
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
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

        $total_terus = DB::table('tbl_tabung_bayaran_terus')
        ->where('id_tabung_kelulusan', $filterKelulusan)
        ->select(DB::raw('sum(tbl_tabung_bayaran_terus.jumlah) as jumlah'))
        ->pluck('jumlah')
        ->first();

        return response()->json([
            'total_count'=>$totalCount,
            'total_terus'=>$total_terus,
            'items'=> $result
        ], 200);
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

        $kelulusan = TabungKelulusan::where('id', $request->id)->first();
        $bayaranTerus = TabungBayaranTerus::where('id_tabung_kelulusan', $request->id)->first();
        $bayaranSkb = TabungBayaranSkb::where('id_tabung_kelulusan', $request->id)->first();
        $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

        if ($bayaranTerus || $bayaranSkb) {
            return response()->json(["message" => "Kelulusan Sudah Mempunyai Pembayaran"], 200);

        } else {
            $tabung->peruntukan = $tabung->peruntukan - $kelulusan->baki_jumlah_siling;
            $tabung->save();

            $kelulusan->delete();

            return response()->json(["message" => "Kelulusan Berjaya Dibuang"], 200);
        }
    }

}
