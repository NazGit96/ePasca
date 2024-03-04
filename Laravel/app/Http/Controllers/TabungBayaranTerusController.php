<?php

namespace App\Http\Controllers;

use App\Models\Tabung;
use App\Models\TabungBayaranSkb;
use App\Models\TabungBayaranTerus;
use App\Models\TabungBwi;
use App\Models\TabungBwiBayaran;
use App\Models\TabungKelulusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
class TabungBayaranTerusController extends Controller
{
    public function getAll(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bayaran_terus.id desc';
        $filter = $request->filter;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'tbl_tabung_bayaran_terus.id', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan', 'tbl_tabung_bayaran_terus.no_baucar',
            'tbl_tabung_bayaran_terus.penerima', 'tbl_tabung_bayaran_terus.tarikh', 'tbl_tabung_bayaran_terus.perihal', 'tbl_tabung_bayaran_terus.jumlah',
            'tbl_tabung_bayaran_terus.id_pengguna_cipta', 'tbl_tabung_bayaran_terus.tarikh_cipta', 'tbl_tabung_bayaran_terus.id_pengguna_kemaskini',
            'tbl_tabung_bayaran_terus.tarikh_kemaskini', 'tbl_tabung_bayaran_terus.hapus', 'tbl_tabung_kelulusan.id_pengguna_hapus', 'tbl_tabung_kelulusan.tarikh_hapus',
            'tbl_tabung_kelulusan.sebab_hapus', 'tbl_tabung_bayaran_terus.no_rujukan_terus', 'no_rujukan_kelulusan', 'ref_bencana.nama_bencana', 'id_jenis_bayaran', 'id_kategori_bayaran',
            'ref_jenis_bayaran.nama_jenis_bayaran', 'ref_kategori_bayaran.nama_kategori_bayaran'
        ];

        $data = DB::table('tbl_tabung_bayaran_terus')
            ->join('tbl_tabung_kelulusan','tbl_tabung_bayaran_terus.id_tabung_kelulusan','=','tbl_tabung_kelulusan.id')
            ->leftJoin('ref_bencana','tbl_tabung_bayaran_terus.id_bencana','=','ref_bencana.id')
            ->join('ref_jenis_bayaran', 'tbl_tabung_bayaran_terus.id_jenis_bayaran', 'ref_jenis_bayaran.id')
            ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_terus.id_kategori_bayaran', 'ref_kategori_bayaran.id')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_tabung_bayaran_terus.tarikh', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_tabung_bayaran_terus.tarikh', '<=', Carbon::parse($filterToDate)->endOfDay());
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

    public function getAllBayaranTerusLookupTable(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'tbl_tabung_bayaran_terus.id desc';
        $filter = $request->filter;
        $filterIdBencana = $request->filterIdBencana;
        $filterIdTabungKelulusan = $request->filterIdTabungKelulusan ?? null;

        $columns = [
            'tbl_tabung_bayaran_terus.id', 'no_rujukan_terus', 'tbl_tabung_bayaran_terus.perihal', 'tbl_tabung_bayaran_terus.jumlah',
            'tbl_tabung_bayaran_terus.id_tabung_kelulusan',   'tbl_tabung_kelulusan.no_rujukan_kelulusan', 'nama_bencana'
        ];

        $data = DB::table('tbl_tabung_bayaran_terus')
            ->join('tbl_tabung_kelulusan','tbl_tabung_bayaran_terus.id_tabung_kelulusan','=','tbl_tabung_kelulusan.id')
            ->join('ref_bencana','tbl_tabung_bayaran_terus.id_bencana','=','ref_bencana.id')
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
                    return $query->where('tbl_tabung_bayaran_terus.id_tabung_kelulusan', $filterIdTabungKelulusan);
                });
            })
            ->where(function($query) use ($filterIdBencana){
                $query->when($filterIdBencana, function($query, $filterIdBencana){
                    return $query->where('tbl_tabung_bayaran_terus.id_bencana', $filterIdBencana);
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

    public function getTabungBayaranTerusForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'tbl_tabung_bayaran_terus.id', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan', 'tbl_tabung_bayaran_terus.no_baucar',
            'tbl_tabung_bayaran_terus.penerima', 'tbl_tabung_bayaran_terus.tarikh', 'tbl_tabung_bayaran_terus.perihal', 'tbl_tabung_bayaran_terus.jumlah',
            'tbl_tabung_bayaran_terus.id_pengguna_cipta', 'tbl_tabung_bayaran_terus.tarikh_cipta', 'tbl_tabung_bayaran_terus.id_pengguna_kemaskini',
            'tbl_tabung_bayaran_terus.tarikh_kemaskini', 'tbl_tabung_bayaran_terus.hapus', 'tbl_tabung_kelulusan.id_pengguna_hapus', 'tbl_tabung_kelulusan.tarikh_hapus',
            'tbl_tabung_kelulusan.sebab_hapus', 'tbl_tabung_bayaran_terus.no_rujukan_terus', 'no_rujukan_kelulusan', 'ref_bencana.tarikh_bencana', 'ref_bencana.nama_bencana', 'id_jenis_bayaran', 'id_kategori_bayaran',
            'ref_jenis_bayaran.nama_jenis_bayaran', 'ref_kategori_bayaran.nama_kategori_bayaran', 'tbl_tabung_bayaran_terus.id_negeri', 'tbl_tabung_bayaran_terus.id_agensi',
            'tbl_tabung_bayaran_terus.id_kementerian'
        ];

        $tabungBayaranTerus = DB::table('tbl_tabung_bayaran_terus')
        ->join('tbl_tabung_kelulusan','tbl_tabung_bayaran_terus.id_tabung_kelulusan','=','tbl_tabung_kelulusan.id')
        ->leftJoin('ref_bencana','tbl_tabung_bayaran_terus.id_bencana','=','ref_bencana.id')
        ->join('ref_jenis_bayaran', 'tbl_tabung_bayaran_terus.id_jenis_bayaran', 'ref_jenis_bayaran.id')
        ->join('ref_kategori_bayaran', 'tbl_tabung_bayaran_terus.id_kategori_bayaran', 'ref_kategori_bayaran.id')
        ->where('tbl_tabung_bayaran_terus.id', $request->id)
        ->select($columns)
        ->first();

        $bayaranBwi = DB::Table('tbl_tabung_bwi_bayaran')
        ->where('id_tabung_bayaran_terus', $request->id)
        ->get();

        $bwiCount = $bayaranBwi->count();

        return response()->json([
            'bwiCount'=> $bwiCount,
            'tabung_bayaran_terus'=> $tabungBayaranTerus
        ], 200);
    }

    public function createOrEdit(Request $request){
        if($request->id){
            $tabungBayaranTerus = $this->update($request);
        }else{
            $tabungBayaranTerus = $this->create($request);
        }

        return $tabungBayaranTerus;
    }

    private function create($request){
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required',
            'id_tabung_kelulusan' => 'required',
            'id_jenis_bayaran' => 'required',
            'id_kategori_bayaran' => 'required',
            'penerima' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $generate = new GenerateController;
        $running_no = $generate->getBayaranTerusRunningNo();

        $kelulusan = TabungKelulusan::where('id', $request->id_tabung_kelulusan)->first();
        $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

        try {
        DB::beginTransaction();

        if($request->jumlah <= $kelulusan->baki_jumlah_siling){

            $checkNoBaucar = TabungBayaranTerus::where('no_baucar', 'ILIKE', '%' . $request->no_baucar . '%')->first();

            if($checkNoBaucar && ($request->no_baucar != null)){
                return response()->json(['message' => 'No. Baucer yang Anda Masukkan Telah Wujud.'], 200);
            }

            $tabungBayaranTerus = TabungBayaranTerus::create([
                'no_rujukan_terus' => $running_no,
                'id_tabung_kelulusan' => $request->id_tabung_kelulusan,
                'id_jenis_bayaran' => $request->id_jenis_bayaran,
                'id_kategori_bayaran' => $request->id_kategori_bayaran,
                'no_baucar' => $request->no_baucar ?? null,
                'penerima' => $request->penerima,
                'tarikh' => $request->tarikh ?? null,
                'perihal' => $request->perihal ?? null,
                'jumlah' => $request->jumlah,
                'id_bencana' => $request->id_bencana ?? null,
                'id_negeri' => $request->id_negeri ?? null,
                'id_agensi' => $request->id_agensi ?? null,
                'id_kementerian' => $request->id_kementerian ?? null,
                'id_pengguna_cipta' => JWTAuth::user()->id,
                'tarikh_cipta' => Carbon::now(),
                'hapus' => false
            ]);

            $tabungBayaranTerus->save();

            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $tabungBayaranTerus->jumlah;
            $kelulusan->save();

            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $tabungBayaranTerus->jumlah;
            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $tabungBayaranTerus->jumlah;
            $tabung->save();

        }else {
            return response()->json(['message' => 'Jumlah Bayaran Terus Melebihi Jumlah Baki Kelulusan'], 200);
        }

           DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Tabung Bayaran Terus Berjaya Ditambah'], 200);
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


            $tabungBayaranTerus = TabungBayaranTerus::where('id', $request->id)->first();
            $checkNoBaucar = TabungBayaranTerus::where('no_baucar', 'ILIKE', '%' . $request->no_baucar . '%')->first();

            if((strcasecmp($request->no_baucar, $tabungBayaranTerus->no_baucar) != 0) && $checkNoBaucar && ($request->no_baucar != null)){
                return response()->json(['message' => 'No. Baucer yang Anda Masukkan Telah Wujud.'], 200);
            }

            if($tabungBayaranTerus->jumlah != $request->jumlah){
                $kelulusan = TabungKelulusan::where('id', $tabungBayaranTerus->id_tabung_kelulusan)->first();
                $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

                $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $tabungBayaranTerus->jumlah;
                if($request->jumlah > $kelulusan->baki_jumlah_siling){
                    return response()->json(['message' => 'Jumlah Bayaran Terus yang Dikemaskini Melebihi Jumlah Kelulusan'], 200);
                }
                $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling - $request->jumlah;
                $kelulusan->save();

                $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $tabungBayaranTerus->jumlah;
                $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa + $request->jumlah;
                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $tabungBayaranTerus->jumlah;
                $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa - $request->jumlah;
                $tabung->save();

                $tabungBayaranTerus->jumlah = $request->jumlah;
            }

            $tabungBayaranTerus->id_jenis_bayaran = $request->id_jenis_bayaran;
            $tabungBayaranTerus->id_kategori_bayaran = $request->id_kategori_bayaran;
            $tabungBayaranTerus->id_negeri = $request->id_negeri ?? null;
            $tabungBayaranTerus->id_agensi = $request->id_agensi ?? null;
            $tabungBayaranTerus->id_kementerian = $request->id_kementerian ?? null;
            $tabungBayaranTerus->no_baucar = $request->no_baucar ?? null;
            $tabungBayaranTerus->penerima = $request->penerima;
            $tabungBayaranTerus->tarikh = $request->tarikh;
            $tabungBayaranTerus->perihal = $request->perihal;
            $tabungBayaranTerus->id_pengguna_kemaskini = JWTAuth::user()->id;
            $tabungBayaranTerus->tarikh_kemaskini = Carbon::now();

            $tabungBayaranTerus->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Tabung Bayaran Terus Berjaya Dikemaskini'], 200);
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

        $bayaranTerus = TabungBayaranTerus::where('id', $request->id)->first();
        $bwi = TabungBwiBayaran::where('id_tabung_bayaran_terus', $request->id)->first();

        $kelulusan = TabungKelulusan::where('id', $bayaranTerus->id_tabung_kelulusan)->first();
        $tabung = Tabung::where('id', $kelulusan->id_tabung)->first();

        if ($bwi) {
            return response()->json(["message" => "Pembayaran Secara Terus Terdapat di Dalam Bantuan Wang Ihsan"], 200);

        } else {
            $kelulusan->baki_jumlah_siling = $kelulusan->baki_jumlah_siling + $bayaranTerus->jumlah;
            $kelulusan->save();

            $tabung->jumlah_perbelanjaan_semasa = $tabung->jumlah_perbelanjaan_semasa - $bayaranTerus->jumlah;
            $tabung->jumlah_baki_semasa = $tabung->jumlah_baki_semasa + $bayaranTerus->jumlah;
            $tabung->save();

            $bayaranTerus->delete();
        }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(["message" => "Bayaran Terus Berjaya Dibuang"], 200);
    }
}
