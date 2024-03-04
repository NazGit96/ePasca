<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungKelulusan;
use App\Models\TabungPeruntukan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TabungController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterYear = $request->filterYear;

        $columns = [
            'id', 'nama_tabung', 'kategori_tabung', 'tarikh_baki', 'baki_bawaan', 'tarikh_akhir_peruntukan', 'peruntukan',
            'jumlah_keseluruhan', 'jumlah_perbelanjaan_semasa', 'jumlah_baki_semasa', 'status_tabung',
            'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini'
        ];

        $data = DB::table('tbl_tabung')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function ($query) use ($filterYear) {
                $query->when($filterYear, function ($query, $filterYear) {
                    return $query->where(DB::raw('EXTRACT(YEAR from tbl_tabung.tarikh_cipta)'), '=', $filterYear);
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

    public function getAllTabungForLookupTable(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'id', 'nama_tabung', 'tarikh_baki', 'baki_bawaan', 'tarikh_akhir_peruntukan', 'peruntukan',
            'jumlah_keseluruhan', 'jumlah_perbelanjaan_semasa', 'jumlah_baki_semasa', 'status_tabung',
            'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini'
        ];

        $data = DB::table('tbl_tabung')
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

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $result
        ], 200);
    }

    public function getTotalTabungCard(){

        $jumlah_keseluruhan = DB::table('tbl_tabung')
        ->select(DB::raw('sum(tbl_tabung.jumlah_keseluruhan) as jumlah_keseluruhan'))
        ->pluck('jumlah_keseluruhan')
        ->first();

        $jumlah_perbelanjaan_semasa = DB::table('tbl_tabung')
        ->select(DB::raw('sum(tbl_tabung.jumlah_perbelanjaan_semasa) as jumlah_perbelanjaan_semasa'))
        ->pluck('jumlah_perbelanjaan_semasa')
        ->first();

        $jumlah_tanggungan = DB::table('tbl_tabung_kelulusan')
        ->select(DB::raw('sum(tbl_tabung_kelulusan.baki_jumlah_siling) as jumlah_tanggungan'))
        ->pluck('jumlah_tanggungan')
        ->first();

        return response()->json([
            'jumlah_keseluruhan'=>$jumlah_keseluruhan,
            'jumlah_perbelanjaan_semasa'=>$jumlah_perbelanjaan_semasa,
            'jumlah_tanggungan'=>$jumlah_tanggungan,
        ], 200);
    }

    public function getSejarahTransaksi(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung.id desc';
        $filter = $request->filter;
        $filterTabung = $request->filterTabung;

        $columns = [
            'tbl_tabung_kelulusan.id as id_kelulusan', 'no_rujukan_kelulusan', 'jumlah_siling', 'tbl_tabung_kelulusan.tarikh_cipta', 'nama'
        ];

        $data = DB::table('tbl_tabung')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung.id', 'tbl_tabung_kelulusan.id_tabung')
            ->join('tbl_pengguna', 'tbl_tabung_kelulusan.id_pengguna_cipta', 'tbl_pengguna.id')
            ->where('tbl_tabung.id', $filterTabung)
            ->select($columns)
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

        $belanjaTerus = DB::Table('tbl_tabung_bayaran_terus')
            ->join('tbl_pengguna', 'tbl_tabung_bayaran_terus.id_pengguna_cipta', 'tbl_pengguna.id')
            ->whereIn('id_tabung_kelulusan', $result->unique('id_kelulusan')->pluck('id_kelulusan'))
            ->select(['id_tabung_kelulusan', 'no_rujukan_terus', 'tbl_pengguna.nama', 'tbl_tabung_bayaran_terus.tarikh_cipta', 'jumlah'])
            ->get();

        $belanjaSkb = DB::Table('tbl_tabung_bayaran_skb')
            ->join('tbl_pengguna', 'tbl_tabung_bayaran_skb.id_pengguna_cipta', 'tbl_pengguna.id')
            ->whereIn('id_tabung_kelulusan', $result->unique('id_kelulusan')->pluck('id_kelulusan'))
            ->select(['id_tabung_kelulusan', 'no_rujukan_skb', 'tbl_pengguna.nama', 'tbl_tabung_bayaran_skb.tarikh_cipta', 'jumlah_siling_peruntukan'])
            ->get();

        $belanjaWaran = DB::Table('tbl_tabung_bayaran_waran')
            ->join('tbl_pengguna', 'tbl_tabung_bayaran_waran.id_pengguna_cipta', 'tbl_pengguna.id')
            ->whereIn('id_tabung_kelulusan', $result->unique('id_kelulusan')->pluck('id_kelulusan'))
            ->select(['id_tabung_kelulusan', 'no_rujukan_waran', 'tbl_pengguna.nama', 'tbl_tabung_bayaran_waran.tarikh_cipta', 'jumlah_siling_peruntukan'])
            ->get();

        $baki_bawaan = DB::table('tbl_tabung_peruntukan')
            ->where('id_tabung', $filterTabung)
            ->where('id_jenis_peruntukan', 3)
            ->get();

        $data = array();

        foreach ($result as $kelulusan) {
            $item = array();
            $item['tarikh'] = $kelulusan->tarikh_cipta;
            $item['no_ruj'] = $kelulusan->no_rujukan_kelulusan;
            $item['aktiviti'] = "Kelulusan";
            $item['jumlah'] = $kelulusan->jumlah_siling;
            $item['nama'] = $kelulusan->nama;
            $data[] = $item;
        }
        if($belanjaTerus != []){
            foreach ($result as $kelulusan) {
                $item = array();
                $item['tarikh'] = $belanjaTerus->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('tarikh_cipta')->first();
                $item['no_ruj'] = $belanjaTerus->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('no_rujukan_terus')->first();
                $item['aktiviti'] = "Bayaran Terus";
                $item['jumlah'] = $belanjaTerus->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('jumlah')->first();
                $item['nama'] = $belanjaTerus->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('nama')->first();
                if($item['no_ruj']){
                    $data[] = $item;
                }
            }
        }

        if($belanjaSkb != []){
            foreach ($result as $kelulusan) {
                $item = array();
                $item['tarikh'] = $belanjaSkb->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('tarikh_cipta')->first();
                $item['no_ruj'] = $belanjaSkb->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('no_rujukan_skb')->first();
                $item['aktiviti'] = "Bayaran SKB";
                $item['jumlah'] = $belanjaSkb->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('jumlah_siling_peruntukan')->first();
                $item['nama'] = $belanjaSkb->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('nama')->first();
                if($item['no_ruj']){
                    $data[] = $item;
                }            }
        }

        if($belanjaWaran != []){
            foreach ($result as $kelulusan) {
                $item = array();
                $item['tarikh'] = $belanjaWaran->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('tarikh_cipta')->first();
                $item['no_ruj'] = $belanjaWaran->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('no_rujukan_waran')->first();
                $item['aktiviti'] = "Bayaran Waran";
                $item['jumlah'] = $belanjaWaran->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('jumlah_siling_peruntukan')->first();
                $item['nama'] = $belanjaWaran->where('id_tabung_kelulusan', $kelulusan->id_kelulusan)->pluck('nama')->first();
                if($item['no_ruj']){
                    $data[] = $item;
                }            }
        }

        if($baki_bawaan != []){
            foreach($baki_bawaan as $bb){
                $item = array();
                $item['tarikh'] = $bb->tarikh_cipta;
                $item['no_ruj'] = $bb->no_rujukan;
                $item['aktiviti'] = "Baki Bawaan";
                $item['jumlah'] = $bb->jumlah;
                $item['nama'] = "Sistem";
                $data[] = $item;
            }
        }

        $totalCount = count($data);

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $data
        ], 200);
    }

    public function getTabungByYear(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $filterYear = $request->filterYear ?? Carbon::now()->year;

        $dana_tambahan = DB::table('tbl_tabung_peruntukan')
        ->where('id_tabung', $request->id)
        ->where('id_jenis_peruntukan', 2)
        ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_peruntukan.tarikh_cipta)'), '=', $filterYear)
        ->select(DB::raw('sum(jumlah) as dana_tambahan'))
        ->pluck('dana_tambahan')
        ->first();

        $baki_bawaan = DB::table('tbl_tabung_peruntukan')
        ->where('id_tabung', $request->id)
        ->where('id_jenis_peruntukan', 3)
        ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_peruntukan.tarikh_cipta)'), '=', $filterYear)
        ->select(DB::raw('sum(jumlah) as baki_bawaan'))
        ->pluck('baki_bawaan')
        ->first();

        $peruntukan_diambil = DB::table('tbl_tabung_kelulusan_ambilan')
        ->where('id_tabung', $request->id)
        ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_kelulusan_ambilan.tarikh_cipta)'), '=', $filterYear)
        ->select(DB::raw('sum(jumlah) as peruntukan_diambil'))
        ->pluck('peruntukan_diambil')
        ->first();

        $jumlah_kelulusan = DB::table('tbl_tabung_kelulusan')
        ->where('id_tabung', $request->id)
        ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_kelulusan.tarikh_cipta)'), '=', $filterYear)
        ->select(DB::raw('sum(jumlah_siling) as jumlah_siling'))
        ->pluck('jumlah_siling')
        ->first();

        $jumlah_tanggungan = DB::table('tbl_tabung_kelulusan')
        ->where('id_tabung', $request->id)
        ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_kelulusan.tarikh_cipta)'), '=', $filterYear)
        ->select(DB::raw('sum(baki_jumlah_siling) as jumlah_tanggungan'))
        ->pluck('jumlah_tanggungan')
        ->first();

        $kelulusan = DB::table('tbl_tabung_kelulusan')
        ->where('id_tabung', $request->id)
        ->get();

        $jumlah_belanja = 0;

        foreach($kelulusan as $k){
            $terus = DB::table('tbl_tabung_bayaran_terus')
            ->where('id_tabung_kelulusan', $k->id)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh_cipta)'), '=', $filterYear)
            ->select(DB::raw('sum(jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

            $skb = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_bayaran_skb_bulanan', 'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb')
            ->where('id_tabung_kelulusan', $k->id)
            ->where('tbl_tabung_bayaran_skb_bulanan.tahun', $filterYear)
            ->select(DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

            $waran = DB::table('tbl_tabung_bayaran_waran')
            ->join('tbl_tabung_bayaran_waran_bulanan', 'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran_bulanan.id_tabung_bayaran_waran')
            ->where('id_tabung_kelulusan', $k->id)
            ->where('tbl_tabung_bayaran_waran_bulanan.tahun', $filterYear)
            ->select(DB::raw('sum(tbl_tabung_bayaran_waran_bulanan.jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

            $jumlah_belanja = $jumlah_belanja + $terus + $skb + $waran;
        }

        return response()->json([
            'dana_tambahan' => $dana_tambahan ?? 0,
            'baki_bawaan' => $baki_bawaan ?? 0,
            'jumlah_kelulusan' => $jumlah_kelulusan ?? 0,
            'peruntukan_diambil' => $peruntukan_diambil ?? 0,
            'jumlah_tanggungan' => $jumlah_tanggungan ?? 0,
            'jumlah_belanja' => $jumlah_belanja ?? 0,
        ], 200);
    }

    public function getTabungForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabung = Tabung::where('id', $request->id)->first();

        $dana_awal = DB::table('tbl_tabung_peruntukan')
        ->where('id_tabung', $request->id)
        ->where('id_jenis_peruntukan', 1)
        ->select(DB::raw('sum(jumlah) as dana_awal'))
        ->pluck('dana_awal')
        ->first();

        $dana_tambahan = DB::table('tbl_tabung_peruntukan')
        ->where('id_tabung', $request->id)
        ->where('id_jenis_peruntukan', 2)
        ->select(DB::raw('sum(jumlah) as dana_tambahan'))
        ->pluck('dana_tambahan')
        ->first();

        $peruntukan_diambil = DB::table('tbl_tabung_kelulusan_ambilan')
        ->where('id_tabung', $request->id)
        ->select(DB::raw('sum(jumlah) as peruntukan_diambil'))
        ->pluck('peruntukan_diambil')
        ->first();

        $jumlah_tanggungan = DB::table('tbl_tabung_kelulusan')
        ->where('id_tabung', $request->id)
        ->select(DB::raw('sum(baki_jumlah_siling) as jumlah_tanggungan'))
        ->pluck('jumlah_tanggungan')
        ->first();

        return response()->json([
            'tabung'=> $tabung,
            'dana_awal' => $dana_awal,
            'dana_tambahan' => $dana_tambahan,
            'peruntukan_diambil' => $peruntukan_diambil,
            'jumlah_tanggungan' => $jumlah_tanggungan
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $tabung = $this->update($request);
        }else{
            $tabung = $this->create($request);
        }

        return $tabung;
    }

    public function getTabungForDropdown(Request $request)
    {
        $filter = $request->filter;

        $columns = [
            'id', 'nama_tabung', 'tarikh_baki', 'baki_bawaan', 'tarikh_akhir_peruntukan', 'peruntukan',
            'jumlah_keseluruhan', 'jumlah_perbelanjaan_semasa', 'jumlah_baki_semasa', 'status_tabung',
            'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini'
        ];

        $data = DB::table('tbl_tabung')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->select($columns)
            ->orderBy('nama_tabung')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function getTabungByYearForDropdown(Request $request)
    {
        $filter = $request->filter;
        $filterYear = $request->filterYear;

        $columns = [
            'id', 'nama_tabung', 'tarikh_baki', 'baki_bawaan', 'tarikh_akhir_peruntukan', 'peruntukan',
            'jumlah_keseluruhan', 'jumlah_perbelanjaan_semasa', 'jumlah_baki_semasa', 'status_tabung',
            'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini'
        ];

        $data = DB::table('tbl_tabung')
            ->select($columns)
            ->where(DB::raw('EXTRACT(YEAR from tarikh_baki)'), '=', $filterYear)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->select($columns)
            ->orderBy('nama_tabung')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    private function create($request){
        $validator = Validator::make($request->all(), [
            'nama_tabung' => 'required',
            'kategori_tabung' => 'required',
            'dana_awal' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $generate = new GenerateController;
        $running_no = $generate->getDanaAwalRunningNo();

        try {
        DB::beginTransaction();

        $tabung = Tabung::create([
            'nama_tabung' => $request->nama_tabung,
            'kategori_tabung' => $request->kategori_tabung,
            'tarikh_baki' => Carbon::now(),
            'baki_bawaan' => 0,
            'jumlah_keseluruhan' => $request->dana_awal,
            'jumlah_baki_semasa' => $request->dana_awal,
            'tarikh_akhir_peruntukan' => $request->tarikh_akhir_peruntukan,
            'status_tabung' => 1,
            'catatan' => $request->catatan,
            'id_pengguna_cipta' => JWTAuth::user()->id,
            'tarikh_cipta' => Carbon::now()
        ]);

        $tabung->save();

        $tabungPeruntukan = TabungPeruntukan::create([
            'id_tabung' => $tabung->id,
            'nama_peruntukan' => "Dana Awal",
            'tarikh_peruntukan' => Carbon::now(),
            'no_rujukan' => $running_no,
            'jumlah' => $request->dana_awal,
            'catatan' => $tabung->catatan,
            'id_jenis_peruntukan' => 1,
            'id_pengguna_cipta' => JWTAuth::user()->id,
            'tarikh_cipta' => Carbon::now()
        ]);

        $tabungPeruntukan->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($tabung, 200);
    }

    private function update($request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_tabung' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

        $tabung = Tabung::where('id', $request->id)->first();
        $tabung->nama_tabung = $request->nama_tabung;
        $tabung->kategori_tabung = $request->kategori_tabung;
        $tabung->catatan = $request->catatan;
        $tabung->id_pengguna_kemaskini = JWTAuth::user()->id;
        $tabung->tarikh_kemaskini = Carbon::now();

        $tabung->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($tabung, 200);
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

        $tabung = Tabung::where('id', $request->id)->first();
        $kelulusan = TabungKelulusan::where('id_tabung', $tabung->id)->first();

        if ($kelulusan) {
            return response()->json(["message" => "Tabung Sudah Mempunyai Kelulusan"], 200);

        } else {
            $tabungPeruntukan = TabungPeruntukan::where('id_tabung', $tabung->id)->get();

            foreach($tabungPeruntukan as $tp){
                $peruntukan = TabungPeruntukan::where('id', $tp->id)->first();
                $peruntukan->delete();
            }
            $tabung->delete();
        }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    return response()->json(["message" => "Tabung Berjaya Dibuang"], 200);
    }
}
