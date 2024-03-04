<?php

namespace App\Http\Controllers;

use App\Models\RefNegeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
{

    public function getJumlahBantuan(Request $request){
        // $filterYear = $request->filterYear ?? Carbon::now()->year;
        // $filterIdBencana = $request->filterIdBencana ?? null;
        // $filterFromDate =  $request->filterFromDate;
        // $filterToDate = $request->filterToDate;

        // $jumlahMangsa = DB::table('tbl_mangsa')
        // ->leftJoin('tbl_mangsa_bencana', 'tbl_mangsa.id', 'tbl_mangsa_bencana.id_mangsa')
        // ->leftJoin('ref_bencana', 'tbl_mangsa_bencana.id_bencana','ref_bencana.id')
        // ->where(DB::raw('EXTRACT(YEAR from tbl_mangsa.tarikh_cipta)'), '=', $filterYear)
        // ->where(function($query) use ($filterIdBencana){
        //     $query->when($filterIdBencana, function($query, $filterIdBencana){
        //         return $query->where('tbl_mangsa_bencana.id_bencana', $filterIdBencana);
        //     });
        // })
        // ->where(function($query) use ($filterFromDate){
        //     $query->when($filterFromDate, function($query, $filterFromDate){
        //         return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        //     });
        // })
        // ->where(function($query) use ($filterToDate){
        //     $query->when($filterToDate, function($query, $filterToDate){
        //         return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        //     });
        // })
        // ->select(DB::raw('count(distinct tbl_mangsa.id) as penerima'),
        // DB::raw("
        // (coalesce((select sum(kos_sebenar) from tbl_mangsa_rumah where EXTRACT(YEAR from tbl_mangsa_rumah.tarikh_cipta) = $filterYear), 0.00) +
        // coalesce((select sum(kos_bantuan) from tbl_mangsa_bantuan where EXTRACT(YEAR from tbl_mangsa_bantuan.tarikh_cipta) = $filterYear), 0.00) +
        // coalesce((select sum(jumlah_pinjaman) from tbl_mangsa_pinjaman where EXTRACT(YEAR from tbl_mangsa_pinjaman.tarikh_cipta) = $filterYear), 0.00) +
        // coalesce((select sum(kos_bantuan) from tbl_mangsa_pertanian where EXTRACT(YEAR from tbl_mangsa_pertanian.tarikh_cipta) = $filterYear), 0.00) +
        // coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where EXTRACT(YEAR from tbl_mangsa_wang_ihsan.tarikh_cipta) = $filterYear and status_mangsa_wang_ihsan != 3), 0.00) +
        // coalesce((select sum(kos_bantuan) from tbl_mangsa_antarabangsa where EXTRACT(YEAR from tbl_mangsa_antarabangsa.tarikh_cipta) = $filterYear), 0.00))
        // as jumlah"))
        // ->first();

        $filterYear = $request->filterYear ?? null; // Remove the default to current year
        $filterIdBencana = $request->filterIdBencana ?? null;
        $filterFromDate =  $request->filterFromDate;
        $filterToDate = $request->filterToDate;

        $jumlahMangsa = DB::table('tbl_mangsa')
        ->leftJoin('tbl_mangsa_bencana', 'tbl_mangsa.id', 'tbl_mangsa_bencana.id_mangsa')
        ->leftJoin('ref_bencana', 'tbl_mangsa_bencana.id_bencana','ref_bencana.id')
        ->when($filterYear, function($query) use ($filterYear) {
            // Apply year filter only if $filterYear is not null
            return $query->where(DB::raw('EXTRACT(YEAR from tbl_mangsa.tarikh_cipta)'), '=', $filterYear);
        })
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_bencana.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(distinct tbl_mangsa.id) as penerima'),
        DB::raw("
        (coalesce((select sum(kos_sebenar) from tbl_mangsa_rumah where ".($filterYear ? "EXTRACT(YEAR from tbl_mangsa_rumah.tarikh_cipta) = $filterYear" : "1=1")."), 0.00) +
        coalesce((select sum(kos_bantuan) from tbl_mangsa_bantuan where ".($filterYear ? "EXTRACT(YEAR from tbl_mangsa_bantuan.tarikh_cipta) = $filterYear" : "1=1")."), 0.00) +
        coalesce((select sum(jumlah_pinjaman) from tbl_mangsa_pinjaman where ".($filterYear ? "EXTRACT(YEAR from tbl_mangsa_pinjaman.tarikh_cipta) = $filterYear" : "1=1")."), 0.00) +
        coalesce((select sum(kos_bantuan) from tbl_mangsa_pertanian where ".($filterYear ? "EXTRACT(YEAR from tbl_mangsa_pertanian.tarikh_cipta) = $filterYear" : "1=1")."), 0.00) +
        coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where ".($filterYear ? "EXTRACT(YEAR from tbl_mangsa_wang_ihsan.tarikh_cipta) = $filterYear" : "1=1")." and status_mangsa_wang_ihsan != 3), 0.00) +
        coalesce((select sum(kos_bantuan) from tbl_mangsa_antarabangsa where ".($filterYear ? "EXTRACT(YEAR from tbl_mangsa_antarabangsa.tarikh_cipta) = $filterYear" : "1=1")."), 0.00))
        as jumlah"))
        ->first();


    


        $bantuanWangIhsan = DB::table('tbl_mangsa_wang_ihsan')
        ->join('tbl_mangsa', 'tbl_mangsa_wang_ihsan.id_mangsa', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_wang_ihsan.id_bencana','ref_bencana.id')
        ->where('status_mangsa_wang_ihsan', '!=', 3)
        ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_wang_ihsan.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(distinct tbl_mangsa_wang_ihsan.id_mangsa) as penerima'), DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah'))
        ->first();

        $bantuanPinjamanKhas = DB::table('tbl_mangsa_pinjaman')
        ->join('tbl_mangsa', 'tbl_mangsa_pinjaman.id_mangsa', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_pinjaman.id_bencana','ref_bencana.id')
        ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_pinjaman.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(distinct tbl_mangsa_pinjaman.id_mangsa) as penerima'), DB::raw('sum(tbl_mangsa_pinjaman.jumlah_pinjaman) as jumlah'))
        ->first();

        $bantuanAntarabangsa = DB::table('tbl_mangsa_antarabangsa')
        ->join('tbl_mangsa', 'tbl_mangsa_antarabangsa.id_mangsa', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_antarabangsa.id_bencana','ref_bencana.id')
        ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_antarabangsa.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(distinct tbl_mangsa_antarabangsa.id_mangsa) as penerima'), DB::raw('sum(tbl_mangsa_antarabangsa.kos_bantuan) as jumlah'))
        ->first();

        $bantuanPertanian = DB::table('tbl_mangsa_pertanian')
        ->join('tbl_mangsa', 'tbl_mangsa_pertanian.id_mangsa', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_pertanian.id_bencana','ref_bencana.id')
        ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_pertanian.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(distinct tbl_mangsa_pertanian.id_mangsa) as penerima'), DB::raw('sum(tbl_mangsa_pertanian.kos_bantuan) as jumlah'))
        ->first();

        $bantuanLain = DB::table('tbl_mangsa_bantuan')
        ->join('tbl_mangsa', 'tbl_mangsa_bantuan.id_mangsa', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_bantuan.id_bencana','ref_bencana.id')
        ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_bantuan.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(distinct tbl_mangsa_bantuan.id_mangsa) as penerima'), DB::raw('sum(tbl_mangsa_bantuan.kos_bantuan) as jumlah'))
        ->first();

        $bantuanRumahBaikPulih = DB::table('tbl_mangsa_rumah')
        ->join('tbl_mangsa', 'tbl_mangsa_rumah.id_mangsa', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_rumah.id_bencana','ref_bencana.id')
        ->where('id_jenis_bantuan', 3)
        ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_rumah.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(distinct tbl_mangsa_rumah.id_mangsa) as penerima'), DB::raw('sum(tbl_mangsa_rumah.kos_sebenar) as jumlah'))
        ->first();

        $bantuanRumahKekal = DB::table('tbl_mangsa_rumah')
        ->join('tbl_mangsa', 'tbl_mangsa_rumah.id_mangsa', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_rumah.id_bencana','ref_bencana.id')
        ->where('id_jenis_bantuan', 2)
        ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        ->where(function($query) use ($filterIdBencana){
            $query->when($filterIdBencana, function($query, $filterIdBencana){
                return $query->where('tbl_mangsa_rumah.id_bencana', $filterIdBencana);
            });
        })
        ->where(function($query) use ($filterFromDate){
            $query->when($filterFromDate, function($query, $filterFromDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
            });
        })
        ->where(function($query) use ($filterToDate){
            $query->when($filterToDate, function($query, $filterToDate){
                return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
            });
        })
        ->select(DB::raw('count(tbl_mangsa_rumah.id_mangsa) as penerima'), DB::raw('sum(tbl_mangsa_rumah.kos_sebenar) as jumlah'))
        ->first();
    
        // Covid Kematian & Covid RM100
        $jumlahKematianCovid19 = DB::table('tbl_mangsa')
            ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa')
            ->where('tbl_mangsa_bencana.id_bencana', '=', 37)
            ->count();

        $jumlahBantuanKematian = DB::table('tbl_mangsa_wang_ihsan')
            ->where('id_bencana', '=', 37)
            ->sum('jumlah');

        $CovidKematian = [
            'penerima' => $jumlahKematianCovid19,
            'jumlah' => $jumlahBantuanKematian,
        ];

        $jumlahRM100Covid19 = DB::table('tbl_mangsa')
            ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa')
            ->where('tbl_mangsa_bencana.id_bencana', '=', 38)
            ->count();

        $jumlahBantuanRM100 = DB::table('tbl_mangsa_wang_ihsan')
            ->where('id_bencana', '=', 38)
            ->sum('jumlah');

        $CovidRM100 = [
            'penerima' => $jumlahRM100Covid19,
            'jumlah' => $jumlahBantuanRM100,
        ];

        return response()->json([
            'jumlahMangsa'=>$jumlahMangsa,
            'bantuanCovidKematian'=>$CovidKematian,
            'bantuanCovid100'=>$CovidRM100,
            'bantuanBwi'=>$bantuanWangIhsan,
            'bantuanPinjaman'=>$bantuanPinjamanKhas,
            'bantuanAntarabangsa'=>$bantuanAntarabangsa,
            'bantuanPertanian'=>$bantuanPertanian,
            'bantuanLain'=>$bantuanLain,
            'bantuanRumahBaikPulih'=>$bantuanRumahBaikPulih,
            'bantuanRumahKekal'=>$bantuanRumahKekal,
        ], 200);
    }

    public function getJumlahBantuanByNegeri(Request $request){
        // $filterYear = $request->filterYear ?? Carbon::now()->year;
        $filterYear = $request->filterYear ?? null; // Set to null to search across all years by default
        $filterIdBencana = $request->filterIdBencana ?? null;
        $filterFromDate =  $request->filterFromDate;
        $filterToDate = $request->filterToDate;


        $data = DB::table('tbl_mangsa')
        ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
        ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa')
        ->join('ref_bencana', 'tbl_mangsa_bencana.id_bencana', '=', 'ref_bencana.id')
        ->when($filterYear, function ($query) use ($filterYear) {
            // Only apply the year filter if $filterYear is not null
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_bencana.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('count(distinct tbl_mangsa.id) as bil'))
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id');

        $bwi = DB::table('tbl_mangsa_wang_ihsan')
        ->join('tbl_mangsa', 'tbl_mangsa_wang_ihsan.id_mangsa', '=', 'tbl_mangsa.id')
        ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
        ->join('ref_bencana', 'tbl_mangsa_wang_ihsan.id_bencana', '=', 'ref_bencana.id')
        ->where('status_mangsa_wang_ihsan', '!=', 3)
        ->when($filterYear, function ($query) use ($filterYear) {
            // Apply year filter only if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_wang_ihsan.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('sum(tbl_mangsa_wang_ihsan.jumlah) as jumlah'))
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id')
        ->get();

        $antarabangsa = DB::table('tbl_mangsa_antarabangsa')
        ->join('tbl_mangsa', 'tbl_mangsa_antarabangsa.id_mangsa', '=', 'tbl_mangsa.id')
        ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
        ->join('ref_bencana', 'tbl_mangsa_antarabangsa.id_bencana', '=', 'ref_bencana.id')
        ->when($filterYear, function ($query) use ($filterYear) {
            // Only apply the year filter if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_antarabangsa.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('sum(tbl_mangsa_antarabangsa.kos_bantuan) as jumlah'))
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id')
        ->get();


        $pinjamanKhas = DB::table('tbl_mangsa_pinjaman')
        ->join('tbl_mangsa', 'tbl_mangsa_pinjaman.id_mangsa', '=', 'tbl_mangsa.id')
        ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
        ->join('ref_bencana', 'tbl_mangsa_pinjaman.id_bencana', '=', 'ref_bencana.id')
        ->when($filterYear, function ($query) use ($filterYear) {
            // Apply year filter only if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_pinjaman.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('sum(tbl_mangsa_pinjaman.jumlah_pinjaman) as jumlah'))
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id')
        ->get();
        


        $pertanian = DB::table('tbl_mangsa_pertanian')
        ->join('tbl_mangsa', 'tbl_mangsa_pertanian.id_mangsa', '=', 'tbl_mangsa.id')
        ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
        ->join('ref_bencana', 'tbl_mangsa_pertanian.id_bencana', '=', 'ref_bencana.id')
        ->when($filterYear, function ($query) use ($filterYear) {
            // Apply year filter only if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_pertanian.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('sum(tbl_mangsa_pertanian.kos_bantuan) as jumlah'))
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id')
        ->get();


        $bantuan = DB::table('tbl_mangsa_bantuan')
        ->join('tbl_mangsa', 'tbl_mangsa_bantuan.id_mangsa', '=', 'tbl_mangsa.id')
        ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
        ->join('ref_bencana', 'tbl_mangsa_bantuan.id_bencana', '=', 'ref_bencana.id')
        ->when($filterYear, function ($query) use ($filterYear) {
            // Apply year filter only if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_bantuan.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('sum(tbl_mangsa_bantuan.kos_bantuan) as jumlah'))
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id')
        ->get();


        $rumah = DB::table('tbl_mangsa_rumah')
        ->join('tbl_mangsa', 'tbl_mangsa_rumah.id_mangsa', '=', 'tbl_mangsa.id')
        ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
        ->join('ref_bencana', 'tbl_mangsa_rumah.id_bencana', '=', 'ref_bencana.id')
        ->when($filterYear, function ($query) use ($filterYear) {
            // Apply year filter only if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_rumah.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('sum(tbl_mangsa_rumah.kos_sebenar) as jumlah'))
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id')
        ->get();


        $mangsa = $data->get();


    

        $data = array();
        
        for($i = 1; $i <= 14; $i++){
            $result = array();
            $result['id'] = 'MY-' . sprintf("%02d", $i);
            $result['bilMangsa'] = 0;
            $result['jumlahBantuan'] = 0;
            $result['year'] = $filterYear;

            $negeri = RefNegeri::where('id', $i)->pluck('nama_negeri')->first();
            $result['nama_negeri'] = $negeri;

            $item = $mangsa->where('id_negeri', $i)->first();
            $jumlahBwi = $bwi->where('id_negeri', $i)->pluck('jumlah')->first();
            $jumlahAntarabangsa = $antarabangsa->where('id_negeri', $i)->pluck('jumlah')->first();
            $jumlahPinjaman = $pinjamanKhas->where('id_negeri', $i)->pluck('jumlah')->first();
            $jumlahPertanian = $pertanian->where('id_negeri', $i)->pluck('jumlah')->first();
            $jumlahBantuan = $bantuan->where('id_negeri', $i)->pluck('jumlah')->first();
            $jumlahRumah = $rumah->where('id_negeri', $i)->pluck('jumlah')->first();

            $jumlahCovidKematian = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 37)
                ->where('id_negeri', $i)
                ->sum('jumlah');

            $jumlahMangsaCovidKematian = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 37)
                ->where('id_negeri', $i)
                ->count(DB::raw('DISTINCT id_mangsa'));

            $jumlahCovidRM100 = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 38)
                ->where('id_negeri', $i)
                ->sum('jumlah');

            $jumlahMangsaCovidRM100 = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 38)
                ->where('id_negeri', $i)
                ->count(DB::raw('DISTINCT id_mangsa'));

            $jumlahBWI = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 39)
                ->where('id_negeri', $i)
                ->sum('jumlah');

            $jumlahMangsaBWI = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 39)
                ->where('id_negeri', $i)
                ->count(DB::raw('DISTINCT id_mangsa'));

            $jumlahBWIKematian = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 40)
                ->where('id_negeri', $i)
                ->sum('jumlah');

            $jumlahMangsaBWIKematian = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 40)
                ->where('id_negeri', $i)
                ->count(DB::raw('DISTINCT id_mangsa'));

            $result['bilMangsa'] = $item->bil ?? 0;
            $result['jumlahBantuan'] = $jumlahBwi + $jumlahAntarabangsa + $jumlahPinjaman + $jumlahPertanian + $jumlahBantuan + $jumlahRumah;
            $result['jumlahMangsaCovidKematian'] = $jumlahMangsaCovidKematian;
            $result['jumlahBantuanKematianCovid'] = $jumlahCovidKematian;
            $result['jumlahMangsaCovidRM100'] = $jumlahMangsaCovidRM100;
            $result['jumlahCovidRM100'] = $jumlahCovidRM100;
            $result['jumlahBWI'] = $jumlahBWI;
            $result['jumlahMangsaBWI'] = $jumlahMangsaBWI;
            $result['jumlahBWIKematian'] = $jumlahBWIKematian;
            $result['jumlahMangsaBWIKematian'] = $jumlahMangsaBWIKematian;

            $data[] = $result;

            // dd($data);
        }


        return $e = response()->json([
            'items'=>$data,
        ], 200);

    }

    public function getJumlahMangsaBencanaByNegeri(Request $request){
        $filterIdNegeri = $request->filterIdNegeri ?? null;
        $filterIdBencana = $request->filterIdBencana ?? null;
        // $filterYear = $request->filterYear ?? Carbon::now()->year;
        $filterYear = null; // Allow $filterYear to be null for all years
        $filterFromDate =  $request->filterFromDate;
        $filterToDate = $request->filterToDate;


        // $data = DB::table('ref_bencana_negeri')
        // ->join('ref_negeri', 'ref_bencana_negeri.id_negeri', 'ref_negeri.id')
        // ->join('ref_bencana', 'ref_bencana_negeri.id_bencana', 'ref_bencana.id')
        // ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('count(distinct ref_bencana_negeri.id) as bil_bencana'))
        // ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        // ->where(function($query) use ($filterIdNegeri){
        //     $query->when($filterIdNegeri, function($query, $filterIdNegeri){
        //         return $query->where('ref_bencana_negeri.id_negeri', $filterIdNegeri);
        //     });
        // })
        // ->where(function($query) use ($filterIdBencana){
        //     $query->when($filterIdBencana, function($query, $filterIdBencana){
        //         return $query->where('ref_bencana_negeri.id_bencana', $filterIdBencana);
        //     });
        // })
        // ->where(function($query) use ($filterFromDate){
        //     $query->when($filterFromDate, function($query, $filterFromDate){
        //         return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        //     });
        // })
        // ->where(function($query) use ($filterToDate){
        //     $query->when($filterToDate, function($query, $filterToDate){
        //         return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        //     });
        // })
        // ->groupBy('nama_negeri', 'ref_negeri.id')
        // ->orderBy('ref_negeri.id');

        $data = DB::table('ref_bencana_negeri')
        ->join('ref_negeri', 'ref_bencana_negeri.id_negeri', '=', 'ref_negeri.id')
        ->join('ref_bencana', 'ref_bencana_negeri.id_bencana', '=', 'ref_bencana.id')
        ->select('nama_negeri', 'ref_negeri.id as id_negeri', DB::raw('count(distinct ref_bencana_negeri.id) as bil_bencana'))
        ->when($filterYear, function ($query) use ($filterYear) {
            // Apply year filter only if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdNegeri, function($query) use ($filterIdNegeri) {
            return $query->where('ref_bencana_negeri.id_negeri', '=', $filterIdNegeri);
        })
        ->when($filterIdBencana, function($query) use ($filterIdBencana) {
            return $query->where('ref_bencana_negeri.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->groupBy('nama_negeri', 'ref_negeri.id')
        ->orderBy('ref_negeri.id');
        

        // $mangsaBencana = DB::table('tbl_mangsa_bencana')
        // ->join('tbl_mangsa', 'tbl_mangsa_bencana.id_mangsa', 'tbl_mangsa.id')
        // ->join('ref_bencana', 'tbl_mangsa_bencana.id_bencana','ref_bencana.id')
        // ->select('tbl_mangsa.id_negeri as id_negeri_mangsa', DB::raw('count(distinct tbl_mangsa_bencana.id_mangsa) as bil_mangsa'))
        // ->where(DB::raw('EXTRACT(YEAR from ref_bencana.tarikh_bencana)'), '=', $filterYear)
        // ->where(function($query) use ($filterIdNegeri){
        //     $query->when($filterIdNegeri, function($query, $filterIdNegeri){
        //         return $query->where('tbl_mangsa.id_negeri', $filterIdNegeri);
        //     });
        // })
        // ->where(function($query) use ($filterIdBencana){
        //     $query->when($filterIdBencana, function($query, $filterIdBencana){
        //         return $query->where('tbl_mangsa_bencana.id_bencana', $filterIdBencana);
        //     });
        // })
        // ->where(function($query) use ($filterFromDate){
        //     $query->when($filterFromDate, function($query, $filterFromDate){
        //         return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        //     });
        // })
        // ->where(function($query) use ($filterToDate){
        //     $query->when($filterToDate, function($query, $filterToDate){
        //         return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        //     });
        // })
        // ->groupBy('tbl_mangsa.id_negeri');

        $mangsaBencana = DB::table('tbl_mangsa_bencana')
        ->join('tbl_mangsa', 'tbl_mangsa_bencana.id_mangsa', '=', 'tbl_mangsa.id')
        ->join('ref_bencana', 'tbl_mangsa_bencana.id_bencana', '=', 'ref_bencana.id')
        ->whereIn('id_bencana', [37,38]) //Exclude BWI daripada map
        ->select('tbl_mangsa.id_negeri as id_negeri_mangsa', DB::raw('count(distinct tbl_mangsa_bencana.id_mangsa) as bil_mangsa'))
        
        ->when($filterYear, function ($query) use ($filterYear) {
            // Apply year filter only if $filterYear is provided
            return $query->whereRaw('EXTRACT(YEAR FROM ref_bencana.tarikh_bencana) = ?', [$filterYear]);
        })
        ->when($filterIdNegeri, function ($query) use ($filterIdNegeri) {
            return $query->where('tbl_mangsa.id_negeri', '=', $filterIdNegeri);
        })
        ->when($filterIdBencana, function ($query) use ($filterIdBencana) {
            return $query->where('tbl_mangsa_bencana.id_bencana', '=', $filterIdBencana);
        })
        ->when($filterFromDate, function ($query) use ($filterFromDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '>=', Carbon::parse($filterFromDate)->startOfDay());
        })
        ->when($filterToDate, function ($query) use ($filterToDate) {
            return $query->whereDate('ref_bencana.tarikh_bencana', '<=', Carbon::parse($filterToDate)->endOfDay());
        })
        ->groupBy('tbl_mangsa.id_negeri');

        $mangsa_bencana = $mangsaBencana->get();
        $mangsa = $data->get();


        $data = array();
        for($i = 1; $i <= 14; $i++){
            $result = array();
            $result['id'] = 'MY-' . sprintf("%02d", $i);
            $result['bilBencana'] = 0;
            $result['value'] = 0;

            $negeri = RefNegeri::where('id', $i)->pluck('nama_negeri')->first();
            $result['nama_negeri'] = $negeri;

            $item = $mangsa->where('id_negeri', $i)->first();
            $bilMangsaBencana = $mangsa_bencana->where('id_negeri_mangsa', $i)->pluck('bil_mangsa')->first();

            /////////////////////////////////////////////////////// 
            $jumlahCovidKematian = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 37)
                ->where('id_negeri', $i)
                ->sum('jumlah');

                // Convert to integer
                $jumlahCovidKematian = intval($jumlahCovidKematian);

            $jumlahMangsaCovidKematian = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 37)
                ->where('id_negeri', $i)
                ->count(DB::raw('DISTINCT id_mangsa'));


            $jumlahCovidRM100 = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 38)
                ->where('id_negeri', $i)
                ->sum('jumlah');

                // Convert to integer
                $jumlahCovidRM100 = intval($jumlahCovidRM100);

            $jumlahMangsaCovidRM100 = DB::table('tbl_mangsa_wang_ihsan')
                ->where('id_bencana', 38)
                ->where('id_negeri', $i)
                ->count(DB::raw('DISTINCT id_mangsa'));
            //////////////////////////////////////////////////////
            /////////////////////////////////////////////////////
            $result['jumlahMangsaCovidKematian'] = $jumlahMangsaCovidKematian;
            $result['jumlahBantuanKematianCovid'] = $jumlahCovidKematian;
            $result['jumlahMangsaCovidRM100'] = $jumlahMangsaCovidRM100;
            $result['jumlahCovidRM100'] = $jumlahCovidRM100;
            ////////////////////////////////////////////////////
            $result['bilBencana'] = $item->bil_bencana ?? 0;
            $result['value'] = $bilMangsaBencana ?? 0;

            $data[] = $result;

            // dd($jumlahCovidKematian,$jumlahMangsaCovidKematian);
        }

        return response()->json([
            'items'=>$data,
        ], 200);
    }

    public function getJumlahKematianCovid19()
    {
        $jumlahKematianCovid19 = DB::table('tbl_mangsa')
            ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa')
            ->where('tbl_mangsa_bencana.id_bencana', '=', 37)
            ->count();

        $jumlahBantuanKematian = DB::table('tbl_mangsa_wang_ihsan')
            ->where('id_bencana', '=', 37)
            ->sum('jumlah');

        return response()->json([
            'jumlahKematianCovid19' => $jumlahKematianCovid19,
            'jumlahBantuanKematian' => $jumlahBantuanKematian
        ], 200);
    }

    public function getJumlahRM100Covid19()
    {
        $jumlahRM100Covid19 = DB::table('tbl_mangsa')
            ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa')
            ->where('tbl_mangsa_bencana.id_bencana', '=', 38)
            ->count();

        $jumlahBantuanRM100 = DB::table('tbl_mangsa_wang_ihsan')
            ->where('id_bencana', '=', 38)
            ->sum('jumlah');

        return response()->json([
            'jumlahRM100Covid19' => $jumlahRM100Covid19,
            'jumlahBantuanRM100' => $jumlahBantuanRM100
        ], 200);
    }

}
