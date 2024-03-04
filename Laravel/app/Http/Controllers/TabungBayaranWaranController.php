<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungBayaranWaran;
use App\Models\TabungBayaranWaranBulanan;
use App\Models\TabungBayaranWaranStatus;
use App\Models\TabungBwiBayaran;
use App\Models\TabungKelulusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;


class TabungBayaranWaranController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterAgensi = $request->filterAgensi;
        $filterTabung = $request->filterTabung;
        $filterYearTarikhWaran =  $request->filterYearTarikhWaran;
        $filterFromDate =  $request->filterFromDate;
        $filterToDate = $request->filterToDate;

        $columns = [
            'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran.no_rujukan_waran', 'tarikh_surat_waran',
            'tbl_tabung_bayaran_waran.tarikh_cipta', 'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_agensi', 'no_rujukan_kelulusan',
            'id_jenis_bayaran', 'id_kategori_bayaran', 'ref_jenis_bayaran.nama_jenis_bayaran',
            'ref_kategori_bayaran.nama_kategori_bayaran', 'ref_status_waran.nama_waran_status', 'rujukan_surat_waran', 'perihal'
        ];

        $data = DB::table('tbl_tabung_bayaran_waran')
            ->join('ref_agensi', 'tbl_tabung_bayaran_waran.id_agensi', '=', 'ref_agensi.id')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_waran.id_tabung_kelulusan', '=', 'tbl_tabung_kelulusan.id')
            ->join('ref_jenis_bayaran', 'tbl_tabung_bayaran_waran.id_jenis_bayaran', 'ref_jenis_bayaran.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_waran.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
            ->join('ref_status_waran', 'tbl_tabung_bayaran_waran_status.id_status_waran', 'ref_status_waran.id')
            ->select('tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran.no_rujukan_waran', 'tarikh_surat_waran',
            'tbl_tabung_bayaran_waran.tarikh_cipta', 'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_agensi', 'no_rujukan_kelulusan',
            'id_jenis_bayaran', 'id_kategori_bayaran', 'ref_jenis_bayaran.nama_jenis_bayaran', 'ref_kategori_bayaran.nama_kategori_bayaran',
            'ref_status_waran.nama_waran_status', 'rujukan_surat_waran', 'perihal',
            DB::raw('coalesce((select sum(jumlah) from tbl_tabung_bayaran_waran_bulanan where id_tabung_bayaran_waran = tbl_tabung_bayaran_waran.id), 0.00) as jumlah_belanja'))
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterAgensi){
                $query->when($filterAgensi, function($query, $filterAgensi){
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function($query) use ($filterTabung){
                $query->when($filterTabung, function($query, $filterTabung){
                    return $query->where('id_tabung', $filterTabung);
                });
            })
            ->where(function($query) use ($filterYearTarikhWaran){
                $query->when($filterYearTarikhWaran, function($query, $filterYearTarikhWaran){
                    return $query->where(DB::raw('EXTRACT(YEAR from tarikh_surat_waran)'), '=', $filterYearTarikhWaran);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tarikh_surat_waran', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tarikh_surat_waran', '<=', Carbon::parse($filterToDate)->endOfDay());
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

    public function getTabungBayaranWaranForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'tbl_tabung_bayaran_waran.id', 'tbl_tabung_bayaran_waran.no_rujukan_waran', 'rujukan_surat_waran', 'tarikh_surat_waran',
            'id_agensi', 'perihal', 'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'nama_agensi', 'id_tabung_kelulusan',
            'no_rujukan_kelulusan', 'tbl_tabung_kelulusan.id_tabung', 'ref_status_waran.nama_waran_status',
            'id_status_waran', 'tbl_tabung_bayaran_waran_status.catatan'
        ];

        $tabung_bayaran_waran = DB::table('tbl_tabung_bayaran_waran')
            ->join('ref_agensi', 'tbl_tabung_bayaran_waran.id_agensi', 'ref_agensi.id')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_waran.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran.id_tabung_bayaran_waran_status', 'tbl_tabung_bayaran_waran_status.id')
            ->join('ref_status_waran', 'tbl_tabung_bayaran_waran_status.id_status_waran', 'ref_status_waran.id')
            ->where('tbl_tabung_bayaran_waran.id', $request->id)
            ->select($columns)
            ->first();

        return response()->json([
            'tabung_bayaran_waran'=> $tabung_bayaran_waran,
        ], 200);
    }

    public function createOrEdit(Request $request){
        $waran = $request->waran;

        if($waran['id'] ?? false){
            $tabungBayaranWaran = $this->update($request);
        }else{
            $tabungBayaranWaran = $this->create($request);
        }

        return $tabungBayaranWaran;
    }

    private function create(Request $request){
        $validator = Validator::make($request->all(), [
            'waran.id_tabung_kelulusan' => 'required|numeric',
            'waran.id_agensi' => 'required|numeric',
            'waran.jumlah_siling_peruntukan' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBayaranWaran = $request->waran;
        $tabungBayaranWaranBulanan = $request->waranBulanan;

        $generate = new GenerateController;
        $running_no = $generate->getWaranRunningNo();

        $kelulusan = TabungKelulusan::where('id', $tabungBayaranWaran['id_tabung_kelulusan'])->first();
        $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

        try {
            DB::beginTransaction();

            if($tabungBayaranWaran['jumlah_siling_peruntukan'] <= $kelulusan->baki_jumlah_siling){

                $tabungBayaran = TabungBayaranWaran::create([
                    'no_rujukan_waran' => $running_no,
                    'rujukan_surat_waran' => $tabungBayaranWaran['rujukan_surat_waran'],
                    'tarikh_surat_waran' => $tabungBayaranWaran['tarikh_surat_waran'],
                    'id_tabung_kelulusan' => $tabungBayaranWaran['id_tabung_kelulusan'],
                    'id_jenis_bayaran' => 2,
                    'id_kategori_bayaran' => 1,
                    'id_agensi' => $tabungBayaranWaran['id_agensi'],
                    'perihal' => $tabungBayaranWaran['perihal'] ?? null,
                    'jumlah_siling_peruntukan' => $tabungBayaranWaran['jumlah_siling_peruntukan'],
                    'jumlah_baki_peruntukan' => $tabungBayaranWaran['jumlah_siling_peruntukan'],
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now(),
                ]);

                $tabungBayaran->save();

                $tabungBayaranWaranStatus = TabungBayaranWaranStatus::create([
                    'id_tabung_bayaran_waran' => $tabungBayaran->id,
                    'id_status_waran' => 1,
                    'catatan' => null,
                    'tarikh_cipta' => Carbon::now(),
                    'id_pengguna_cipta' => JWTAuth::user()->id
                ]);

                $tabungBayaranWaranStatus->save();

                $tabungBayaran->id_tabung_bayaran_waran_status = $tabungBayaranWaranStatus->id;
                $tabungBayaran->save();

                $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $tabungBayaran->jumlah_siling_peruntukan;
                $kelulusan->save();

                $jumlah_bayaran_waran = array_sum(array_column($tabungBayaranWaranBulanan, 'jumlah'));

                if($jumlah_bayaran_waran <= $tabungBayaran->jumlah_baki_peruntukan){

                    foreach($tabungBayaranWaranBulanan as $bulanan){
                        $tabungBayaranBulan = TabungBayaranWaranBulanan::create([
                            'id_tabung_bayaran_waran' => $tabungBayaran->id,
                            'bulan' => $bulanan['bulan'],
                            'tahun' => $bulanan['tahun'],
                            'jumlah' => $bulanan['jumlah'],
                            'id_bulan' => $bulanan['id_bulan'],
                            'id_pengguna_cipta' => JWTAuth::user()->id,
                            'tarikh_cipta' => Carbon::now()
                        ]);

                        $tabungBayaranBulan->save();
                    }

                    $tabungBayaran->jumlah_baki_peruntukan = $tabungBayaran->jumlah_baki_peruntukan - $jumlah_bayaran_waran;
                    $tabungBayaran->save();

                    $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $jumlah_bayaran_waran;
                    $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $jumlah_bayaran_waran;
                    $tabung->save();

                }else{
                    return response()->json(['message'=> 'Jumlah Belanja Bulanan Melebihi Jumlah Baki Siling Waran'], 200);
                }

            }else {
                return response()->json(['message'=> 'Jumlah Siling Waran Melebihi Jumlah Baki Kelulusan'], 200);
            }

            DB::commit();
        }

        catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message'=> 'Maklumat Berjaya Ditambah!'], 200);
    }

    private function update($request){
        $validator = Validator::make($request->all(), [
            'waran.id_tabung_kelulusan' => 'required|numeric',
            'waran.id_agensi' => 'required|numeric',
            'waran.jumlah_siling_peruntukan' => 'required',
            'waran.jumlah_baki_peruntukan' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBayaranWaran = $request->waran;

        try {
            DB::beginTransaction();

        $tabungBayaran = TabungBayaranWaran::where('id', $tabungBayaranWaran['id'])->first();

        if($tabungBayaran->jumlah_siling_peruntukan != $tabungBayaranWaran['jumlah_siling_peruntukan']){
            $kelulusan = TabungKelulusan::where('id', $tabungBayaran->id_tabung_kelulusan)->first();
            $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

            $waranBulanan = DB::table('tbl_tabung_bayaran_waran_bulanan')
            ->where('id_tabung_bayaran_waran', $tabungBayaranWaran['id'])
            ->select(DB::raw('sum(tbl_tabung_bayaran_waran_bulanan.jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

            if($tabungBayaranWaran['jumlah_siling_peruntukan'] < $waranBulanan){
                return response()->json(['message'=> 'Belanja Waran Bulanan Melebihi Jumlah Siling Peruntukan yang Dikemaskini'], 200);
            }

            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $tabungBayaran->jumlah_siling_peruntukan;
            if($tabungBayaranWaran['jumlah_siling_peruntukan'] > $kelulusan->baki_jumlah_siling){
                return response()->json(['message'=> 'Jumlah Siling Peruntukan yang Dikemaskini Melebihi jumlah Kelulusan'], 200);
            }
            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $tabungBayaranWaran['jumlah_siling_peruntukan'];
            $kelulusan->save();

            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $tabungBayaran->jumlah_siling_peruntukan;
            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $tabungBayaranWaran['jumlah_siling_peruntukan'];
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $tabungBayaran->jumlah_siling_peruntukan;
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $tabungBayaranWaran['jumlah_siling_peruntukan'];
            $tabung->save();

            $tabungBayaran->jumlah_siling_peruntukan = $tabungBayaranWaran['jumlah_siling_peruntukan'];
            $tabungBayaran->jumlah_baki_peruntukan = $tabungBayaran->jumlah_siling_peruntukan;
            $tabungBayaran->jumlah_baki_peruntukan = $tabungBayaran->jumlah_baki_peruntukan - $waranBulanan;

        }

        $tabungBayaran->no_rujukan_waran = $tabungBayaranWaran['no_rujukan_waran'];
        $tabungBayaran->rujukan_surat_waran = $tabungBayaranWaran['rujukan_surat_waran'];
        $tabungBayaran->tarikh_surat_waran = $tabungBayaranWaran['tarikh_surat_waran'];
        $tabungBayaran->id_tabung_kelulusan = $tabungBayaranWaran['id_tabung_kelulusan'];
        $tabungBayaran->id_agensi = $tabungBayaranWaran['id_agensi'];
        $tabungBayaran->perihal = $tabungBayaranWaran['perihal'];
        $tabungBayaran->id_pengguna_kemaskini = JWTAuth::user()->id;
        $tabungBayaran->tarikh_kemaskini = Carbon::now();

        $tabungBayaran->save();

        if($request->changeStatus){
            $kelulusan = TabungKelulusan::where('id', $tabungBayaran->id_tabung_kelulusan)->first();

            if($request->changeStatus == 2){
                $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $tabungBayaran->jumlah_baki_peruntukan;
            }else if($request->changeStatus == 1){
                if($kelulusan->baki_jumlah_siling >= $tabungBayaran->jumlah_baki_peruntukan){
                    $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $tabungBayaran->jumlah_baki_peruntukan;
                }else{
                    return response()->json(["message" => "Baki Jumlah Kelulusan Tidak Mencukupi"], 200);
                }
            }

            $kelulusan->save();

            $tabungBayaranWaranStatus = TabungBayaranWaranStatus::create([
                'id_tabung_bayaran_waran' => $tabungBayaran->id,
                'id_status_waran' => $request->changeStatus,
                'catatan' => $request->catatan ?? null,
                'tarikh_cipta' => Carbon::now(),
                'id_pengguna_cipta' => JWTAuth::user()->id
            ]);

            $tabungBayaranWaranStatus->save();

            $tabungBayaran->id_tabung_bayaran_waran_status = $tabungBayaranWaranStatus->id;
            $tabungBayaran->save();
        }

        DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(["message" => "Tabung Bayaran Waran Berjaya Dikemaskini"], 200);
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

        $bayaranWaran = TabungBayaranWaran::where('id', $request->id)->first();
        $bayaranWaranBulanan = TabungBayaranWaranBulanan::where('id_tabung_bayaran_waran', $bayaranWaran->id)->get();

        $kelulusan = TabungKelulusan::where('id', $bayaranWaran->id_tabung_kelulusan)->first();
        $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

        $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $bayaranWaran->jumlah_siling_peruntukan;
        $kelulusan->save();

        foreach($bayaranWaranBulanan as $waranBulan){
            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $waranBulan->jumlah;
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $waranBulan->jumlah;
            $tabung->save();

            $waranBulan->delete();
        }

        $bayaranWaran->delete();

        DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(["message" => "Waran Berjaya Dibuang"], 200);
    }
}
