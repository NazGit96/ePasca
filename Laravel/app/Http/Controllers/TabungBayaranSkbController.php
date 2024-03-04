<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungBayaranSkb;
use App\Models\TabungBayaranSkbBulanan;
use App\Models\TabungBayaranSkbStatus;
use App\Models\TabungBwiBayaran;
use App\Models\TabungKelulusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;


class TabungBayaranSkbController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterAgensi = $request->filterAgensi;
        $filterTabung = $request->filterTabung;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb.no_rujukan_skb', 'rujukan_surat_skb', 'tarikh_surat_skb', 'nama_pegawai',
            'tarikh_mula', 'tarikh_tamat', 'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan',
            'nama_agensi', 'no_rujukan_kelulusan', 'id_jenis_bayaran', 'id_kategori_bayaran',
            'ref_jenis_bayaran.nama_jenis_bayaran', 'ref_kategori_bayaran.nama_kategori_bayaran', 'ref_status_skb.nama_skb_status'
        ];

        $data = DB::table('tbl_tabung_bayaran_skb')
            ->join('ref_agensi', 'tbl_tabung_bayaran_skb.id_agensi', '=', 'ref_agensi.id')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', '=', 'tbl_tabung_kelulusan.id')
            ->join('ref_jenis_bayaran', 'tbl_tabung_bayaran_skb.id_jenis_bayaran', 'ref_jenis_bayaran.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_skb.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
            ->join('ref_status_skb', 'tbl_tabung_bayaran_skb_status.id_status_skb', 'ref_status_skb.id')
            ->select('tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb.no_rujukan_skb', 'nama_pegawai',
            'tarikh_mula', 'tarikh_tamat', 'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan',
            'nama_agensi', 'no_rujukan_kelulusan', 'id_jenis_bayaran', 'id_kategori_bayaran', 'ref_jenis_bayaran.nama_jenis_bayaran',
            'ref_kategori_bayaran.nama_kategori_bayaran', 'ref_status_skb.nama_skb_status', DB::raw('coalesce((select sum(jumlah) from tbl_tabung_bayaran_skb_bulanan where id_tabung_bayaran_skb = tbl_tabung_bayaran_skb.id), 0.00) as jumlah_belanja'))
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
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tarikh_mula', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tarikh_tamat', '<=', Carbon::parse($filterToDate)->endOfDay());
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

    public function getAllSkbForLookupTable(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bayaran_skb.id desc';
        $filter = $request->filter;
        $filterIdBencana = $request->filterIdBencana;
        $filterIdTabungKelulusan = $request->filterIdTabungKelulusan ?? null;

        $columns = [
            'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb.no_rujukan_skb', 'tbl_tabung_bayaran_skb.perihal', 'jumlah_siling_peruntukan', 'id_jenis_bayaran',
            'tbl_tabung_kelulusan.no_rujukan_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', 'nama_bencana'
        ];

        $data = DB::table('tbl_tabung_bayaran_skb')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', '=', 'tbl_tabung_kelulusan.id')
            ->join('ref_bencana', 'tbl_tabung_bayaran_skb.id_bencana', '=', 'ref_bencana.id')
            ->where('id_jenis_bayaran', 1)
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterIdTabungKelulusan){
                $query->when($filterIdTabungKelulusan, function($query, $filterIdTabungKelulusan){
                    return $query->where('tbl_tabung_bayaran_skb.id_tabung_kelulusan', $filterIdTabungKelulusan);
                });
            })
            ->where(function($query) use ($filterIdBencana){
                $query->when($filterIdBencana, function($query, $filterIdBencana){
                    return $query->where('tbl_tabung_bayaran_skb.id_bencana', $filterIdBencana);
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

    public function getTabungBayaranSkbForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'tbl_tabung_bayaran_skb.id', 'tbl_tabung_bayaran_skb.no_rujukan_skb', 'nama_pegawai', 'id_agensi', 'rujukan_surat_skb', 'tarikh_surat_skb',
            'perihal', 'tarikh_mula', 'tarikh_tamat', 'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan',
            'nama_agensi', 'id_tabung_kelulusan', 'no_rujukan_kelulusan', 'tbl_tabung_kelulusan.id_tabung', 'nama_bencana', 'tarikh_bencana',
            'id_jenis_bayaran', 'id_kategori_bayaran', 'id_bencana', 'ref_jenis_bayaran.nama_jenis_bayaran', 'ref_kategori_bayaran.nama_kategori_bayaran',
            'ref_status_skb.nama_skb_status', 'id_status_skb', 'tbl_tabung_bayaran_skb_status.catatan'
        ];

        $tabung_bayaran_skb = DB::table('tbl_tabung_bayaran_skb')
            ->join('ref_agensi', 'tbl_tabung_bayaran_skb.id_agensi', 'ref_agensi.id')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('ref_jenis_bayaran', 'tbl_tabung_bayaran_skb.id_jenis_bayaran', 'ref_jenis_bayaran.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_skb.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->join('tbl_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb.id_tabung_bayaran_skb_status', 'tbl_tabung_bayaran_skb_status.id')
            ->join('ref_status_skb', 'tbl_tabung_bayaran_skb_status.id_status_skb', 'ref_status_skb.id')
            ->leftJoin('ref_bencana','tbl_tabung_bayaran_skb.id_bencana','ref_bencana.id')
            ->where('tbl_tabung_bayaran_skb.id', $request->id)
            ->select($columns)
            ->first();

        return response()->json([
            'tabung_bayaran_skb'=> $tabung_bayaran_skb,
        ], 200);
    }

    public function createOrEdit(Request $request){
        $skb = $request->skb;

        if($skb['id'] ?? false){
            $tabungBayaranSkb = $this->update($request);
        }else{
            $tabungBayaranSkb = $this->create($request);
        }

        return $tabungBayaranSkb;
    }

    private function create(Request $request){
        $validator = Validator::make($request->all(), [
            'skb.id_tabung_kelulusan' => 'required|numeric',
            'skb.id_jenis_bayaran' => 'required|numeric',
            'skb.id_kategori_bayaran' => 'required|numeric',
            'skb.id_agensi' => 'required|numeric',
            'skb.jumlah_siling_peruntukan' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBayaranSkb = $request->skb;
        $tabungBayaranSkbBulanan = $request->skbBulanan;

        $generate = new GenerateController;
        $running_no = $generate->getSKBRunningNo();

        $kelulusan = TabungKelulusan::where('id', $tabungBayaranSkb['id_tabung_kelulusan'])->first();
        $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

        try {
            DB::beginTransaction();

            if($tabungBayaranSkb['jumlah_siling_peruntukan'] <= $kelulusan->baki_jumlah_siling){

                $tabungBayaran = TabungBayaranSkb::create([
                    'no_rujukan_skb' => $running_no,
                    'rujukan_surat_skb' => $tabungBayaranSkb['rujukan_surat_skb'],
                    'tarikh_surat_skb' => $tabungBayaranSkb['tarikh_surat_skb'],
                    'id_tabung_kelulusan' => $tabungBayaranSkb['id_tabung_kelulusan'],
                    'id_jenis_bayaran' => $tabungBayaranSkb['id_jenis_bayaran'],
                    'id_kategori_bayaran' => $tabungBayaranSkb['id_kategori_bayaran'],
                    'nama_pegawai' => $tabungBayaranSkb['nama_pegawai'] ?? null,
                    'id_agensi' => $tabungBayaranSkb['id_agensi'],
                    'perihal' => $tabungBayaranSkb['perihal'] ?? null,
                    'tarikh_mula' => $tabungBayaranSkb['tarikh_mula'],
                    'tarikh_tamat' => $tabungBayaranSkb['tarikh_tamat'],
                    'jumlah_siling_peruntukan' => $tabungBayaranSkb['jumlah_siling_peruntukan'],
                    'jumlah_baki_peruntukan' => $tabungBayaranSkb['jumlah_siling_peruntukan'],
                    'id_bencana' => $tabungBayaranSkb['id_bencana'] ?? null,
                    'id_pengguna_cipta' => JWTAuth::user()->id,
                    'tarikh_cipta' => Carbon::now(),
                ]);

                $tabungBayaran->save();

                $tabungBayaranSkbStatus = TabungBayaranSkbStatus::create([
                    'id_tabung_bayaran_skb' => $tabungBayaran->id,
                    'id_status_skb' => 1,
                    'catatan' => null,
                    'tarikh_cipta' => Carbon::now(),
                    'id_pengguna_cipta' => JWTAuth::user()->id
                ]);

                $tabungBayaranSkbStatus->save();

                $tabungBayaran->id_tabung_bayaran_skb_status = $tabungBayaranSkbStatus->id;
                $tabungBayaran->save();

                $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $tabungBayaran->jumlah_siling_peruntukan;
                $kelulusan->save();

                $jumlah_bayaran_skb = array_sum(array_column($tabungBayaranSkbBulanan, 'jumlah'));

                if($jumlah_bayaran_skb <= $tabungBayaran->jumlah_baki_peruntukan){

                    foreach($tabungBayaranSkbBulanan as $bulanan){
                        $tabungBayaranBulan = TabungBayaranSkbBulanan::create([
                            'id_tabung_bayaran_skb' => $tabungBayaran->id,
                            'bulan' => $bulanan['bulan'],
                            'tahun' => $bulanan['tahun'],
                            'jumlah' => $bulanan['jumlah'],
                            'id_bulan' => $bulanan['id_bulan'],
                            'id_pengguna_cipta' => JWTAuth::user()->id,
                            'tarikh_cipta' => Carbon::now()
                        ]);

                        $tabungBayaranBulan->save();
                    }

                    $tabungBayaran->jumlah_baki_peruntukan = $tabungBayaran->jumlah_baki_peruntukan - $jumlah_bayaran_skb;
                    $tabungBayaran->save();

                    $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $jumlah_bayaran_skb;
                    $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $jumlah_bayaran_skb;
                    $tabung->save();

                }else{
                    return response()->json(['message'=> 'Jumlah Belanja Bulanan Melebihi Jumlah Baki Siling SKB'], 200);
                }

            }else {
                return response()->json(['message'=> 'Jumlah Siling SKB Melebihi Jumlah Baki Kelulusan'], 200);
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
            'skb.id_tabung_kelulusan' => 'required|numeric',
            'skb.id_agensi' => 'required|numeric',
            'skb.jumlah_siling_peruntukan' => 'required',
            'skb.jumlah_baki_peruntukan' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $tabungBayaranSkb = $request->skb;

        try {
            DB::beginTransaction();

        $tabungBayaran = TabungBayaranSkb::where('id', $tabungBayaranSkb['id'])->first();

        if($tabungBayaran->jumlah_siling_peruntukan != $tabungBayaranSkb['jumlah_siling_peruntukan']){
            $kelulusan = TabungKelulusan::where('id', $tabungBayaran->id_tabung_kelulusan)->first();
            $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

            $skbBulanan = DB::table('tbl_tabung_bayaran_skb_bulanan')
            ->where('id_tabung_bayaran_skb', $tabungBayaranSkb['id'])
            ->select(DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as jumlah'))
            ->pluck('jumlah')
            ->first();

            if($tabungBayaranSkb['jumlah_siling_peruntukan'] < $skbBulanan){
                return response()->json(['message'=> 'Belanja Skb Bulanan Melebihi Jumlah Siling Peruntukan yang Dikemaskini'], 200);
            }

            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $tabungBayaran->jumlah_siling_peruntukan;
            if($tabungBayaranSkb['jumlah_siling_peruntukan'] > $kelulusan->baki_jumlah_siling){
                return response()->json(['message'=> 'Jumlah Siling Peruntukan yang Dikemaskini Melebihi jumlah Kelulusan'], 200);
            }
            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $tabungBayaranSkb['jumlah_siling_peruntukan'];
            $kelulusan->save();

            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $tabungBayaran->jumlah_siling_peruntukan;
            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $tabungBayaranSkb['jumlah_siling_peruntukan'];
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $tabungBayaran->jumlah_siling_peruntukan;
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $tabungBayaranSkb['jumlah_siling_peruntukan'];
            $tabung->save();

            $tabungBayaran->jumlah_siling_peruntukan = $tabungBayaranSkb['jumlah_siling_peruntukan'];
            $tabungBayaran->jumlah_baki_peruntukan = $tabungBayaran->jumlah_siling_peruntukan;
            $tabungBayaran->jumlah_baki_peruntukan = $tabungBayaran->jumlah_baki_peruntukan - $skbBulanan;
        }
        $tabungBayaran->no_rujukan_skb = $tabungBayaranSkb['no_rujukan_skb'];
        $tabungBayaran->rujukan_surat_skb = $tabungBayaranSkb['rujukan_surat_skb'];
        $tabungBayaran->tarikh_surat_skb = $tabungBayaranSkb['tarikh_surat_skb'];
        $tabungBayaran->id_tabung_kelulusan = $tabungBayaranSkb['id_tabung_kelulusan'];
        $tabungBayaran->id_jenis_bayaran = $tabungBayaranSkb['id_jenis_bayaran'];
        $tabungBayaran->id_kategori_bayaran = $tabungBayaranSkb['id_kategori_bayaran'];
        $tabungBayaran->id_agensi = $tabungBayaranSkb['id_agensi'];
        $tabungBayaran->perihal = $tabungBayaranSkb['perihal'];
        $tabungBayaran->tarikh_mula = $tabungBayaranSkb['tarikh_mula'];
        $tabungBayaran->tarikh_tamat = $tabungBayaranSkb['tarikh_tamat'];
        $tabungBayaran->id_pengguna_kemaskini = JWTAuth::user()->id;
        $tabungBayaran->tarikh_kemaskini = Carbon::now();

        $tabungBayaran->save();

        if($request->changeStatus){
            $tabungBayaranSkbStatus = TabungBayaranSkbStatus::create([
                'id_tabung_bayaran_skb' => $tabungBayaran->id,
                'id_status_skb' => $request->changeStatus,
                'catatan' => $request->catatan ?? null,
                'tarikh_cipta' => Carbon::now(),
                'id_pengguna_cipta' => JWTAuth::user()->id
            ]);

            $tabungBayaranSkbStatus->save();

            $tabungBayaran->id_tabung_bayaran_skb_status = $tabungBayaranSkbStatus->id;
            $tabungBayaran->save();
        }

        DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message'=> 'Maklumat Berjaya Dikemaskini!'], 200);
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

        $bayaranSkb = TabungBayaranSkb::where('id', $request->id)->first();
        $bayaranSkbBulanan = TabungBayaranSkbBulanan::where('id_tabung_bayaran_skb', $bayaranSkb->id)->get();
        $bwi = TabungBwiBayaran::where('id_tabung_bayaran_skb', $request->id)->first();

        $kelulusan = TabungKelulusan::where('id', $bayaranSkb->id_tabung_kelulusan)->first();
        $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

        if ($bwi) {
            return response()->json(["message" => "Pembayaran Surat Kuasa Belanja Terdapat di Dalam Bantuan Wang Ihsan"], 200);

        } else {
            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $bayaranSkb->jumlah_siling_peruntukan;
            $kelulusan->save();

            foreach($bayaranSkbBulanan as $skbBulan){

                $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $skbBulan->jumlah;
                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $skbBulan->jumlah;
                $tabung->save();

                $skbBulan->delete();
            }

            $bayaranSkb->delete();
        }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(["message" => "Surat Kuasa Belanja Berjaya Dibuang"], 200);
        }
}
