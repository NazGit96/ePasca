<?php

namespace App\Http\Controllers;

use App\Models\RefNegeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardTabungController extends Controller
{

    public function getTotalTabungCard(Request $request){
        $id_tabung = $request->id_tabung ?? 1;
        $filterYear = $request->filterYear ?? Carbon::now()->year;
        $filterFromDate =  $request->filterFromDate;
        $filterToDate = $request->filterToDate;

            $nama_tabung = DB::table('tbl_tabung')
            ->where('id', $id_tabung)
            ->pluck('nama_tabung')
            ->first();

            $jumlah_keseluruhan = DB::table('tbl_tabung')
            ->where('id', $id_tabung)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung.tarikh_cipta)'), '=', $filterYear)
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_tabung.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_tabung.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->pluck('jumlah_keseluruhan',)
            ->first();

            $jumlah_perbelanjaan_semasa = DB::table('tbl_tabung')
            ->where('id', $id_tabung)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung.tarikh_cipta)'), '=', $filterYear)
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_tabung.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_tabung.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->pluck('jumlah_perbelanjaan_semasa')
            ->first();

            $jumlah_tanggungan = DB::table('tbl_tabung_kelulusan')
            ->where('id_tabung', $id_tabung)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_kelulusan.tarikh_cipta)'), '=', $filterYear)
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select(DB::raw('sum(baki_jumlah_siling) as jumlah_tanggungan'))
            ->pluck('jumlah_tanggungan')
            ->first();

            $jumlah_bersih = $jumlah_keseluruhan - $jumlah_perbelanjaan_semasa - $jumlah_tanggungan;


        return response()->json([
            'id_tabung'=>$id_tabung,
            'nama_tabung'=>$nama_tabung,
            'jumlah_keseluruhan'=>$jumlah_keseluruhan ?? 0,
            'jumlah_perbelanjaan_semasa'=>$jumlah_perbelanjaan_semasa ?? 0,
            'jumlah_tanggungan'=>$jumlah_tanggungan ?? 0,
            'jumlah_bersih'=>$jumlah_bersih ?? 0
        ], 200);
    }

    public function getTotalBayaranTerusByMonth(Request $request){
        $filterYear = $request->filterYear ?? Carbon::now()->year;
        $filterTabung = $request->filterTabung;

        $data = DB::table('tbl_tabung_bayaran_terus')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_terus.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung', 'tbl_tabung_kelulusan.id_tabung', 'tbl_tabung.id')
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh_cipta)'), '=', $filterYear)
            ->select(
                DB::raw('sum(tbl_tabung_bayaran_terus.jumlah) as bayaran_terus'),
                DB::raw('CAST (EXTRACT(MONTH from tbl_tabung_bayaran_terus.tarikh) AS INTEGER) as numeral_month'),
                DB::raw("TO_CHAR(TO_DATE(EXTRACT(MONTH from tbl_tabung_bayaran_terus.tarikh)::text, 'MM'), 'Mon') as month"),
                DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh) as year')
                )
            ->where(function($query) use ($filterTabung){
                $query->when($filterTabung, function($query, $filterTabung){
                    return $query->where('tbl_tabung_kelulusan.id_tabung', $filterTabung);
                });
            })
            ->groupBy(
                DB::raw('EXTRACT(MONTH from tbl_tabung_bayaran_terus.tarikh)'),
                DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_terus.tarikh)')
                )
            ->orderBy('numeral_month')
            ->get();

        $bayaran_terus = $data;

        $data = array();
        $monthLimit = $filterYear == Carbon::now()->year ? Carbon::now()->month : 12;
        for($i = 1; $i <= $monthLimit; $i++){
            $result = array();
            $result['numeral_month'] = $i;
            $result['month'] = date('M', mktime(0, 0, 0, $i, 1));
            $result['year'] = $filterYear;

            $item = $bayaran_terus->where('numeral_month', $i)->first();
            if($item){
                $result['bayaran_terus'] = $item->bayaran_terus ?? 0;
            }

            $data[] = $result;
        }

        return response()->json([
            'items'=>$data,
        ], 200);
    }

    public function getTotalSkbByMonth(Request $request){
        $filterYear = $request->filterYear ?? Carbon::now()->year;
        $filterTabung = $request->filterTabung;
        $filterFromDate =  $request->filterFromDate;
        $filterToDate = $request->filterToDate;

        $data = DB::table('tbl_tabung_bayaran_skb_bulanan')
            ->join('tbl_tabung_bayaran_skb', 'tbl_tabung_bayaran_skb_bulanan.id_tabung_bayaran_skb', 'tbl_tabung_bayaran_skb.id')
            ->join('tbl_tabung_kelulusan', 'tbl_tabung_bayaran_skb.id_tabung_kelulusan', 'tbl_tabung_kelulusan.id')
            ->join('tbl_tabung', 'tbl_tabung_kelulusan.id_tabung', 'tbl_tabung.id')
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_skb_bulanan.tarikh_cipta)'), '=', $filterYear)
            ->where(function($query) use ($filterTabung){
                $query->when($filterTabung, function($query, $filterTabung){
                    return $query->where('tbl_tabung_kelulusan.id_tabung', $filterTabung);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->where('tbl_tabung_bayaran_skb_bulanan.id_bulan', '>=', $filterFromDate);
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->where('tbl_tabung_bayaran_skb_bulanan.id_bulan', '<=', $filterToDate);
                });
            })
            ->select(
                'bulan', 'id_bulan',
                DB::raw('sum(tbl_tabung_bayaran_skb_bulanan.jumlah) as bayaran_skb'),
                DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_skb_bulanan.tarikh_cipta) as year')
                )
            ->groupBy(
                'bulan', 'id_bulan',
                DB::raw('EXTRACT(YEAR from tbl_tabung_bayaran_skb_bulanan.tarikh_cipta)')
                )
            ->orderBy('id_bulan')
            ->get();

        return response()->json([
            'items'=>$data,
        ], 200);
    }

    public function getBelanjaTanggunganByTabung(Request $request){
        $id_tabung = $request->id_tabung ?? 1;
        $filterYear = $request->filterYear ?? Carbon::now()->year;
        $filterFromDate =  $request->filterFromDate;
        $filterToDate = $request->filterToDate;

        $jumlah_perbelanjaan_semasa = DB::table('tbl_tabung')
            ->where('id', $id_tabung)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung.tarikh_cipta)'), '=', $filterYear)
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_tabung.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_tabung.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select(DB::raw('sum(jumlah_perbelanjaan_semasa) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $jumlah_tanggungan = DB::table('tbl_tabung_kelulusan')
            ->where('id_tabung', $id_tabung)
            ->where(DB::raw('EXTRACT(YEAR from tbl_tabung_kelulusan.tarikh_cipta)'), '=', $filterYear)
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_tabung_kelulusan.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select(DB::raw('sum(baki_jumlah_siling) as jumlah'))
            ->pluck('jumlah')
            ->first();

        $data = array();
        $result = array();
        $item = array();

        $result = array("kategori" => "Belanja", "jumlah" => $jumlah_perbelanjaan_semasa ?? 0);
        $data[] = $result;

        $result = array("kategori" => "Tanggungan", "jumlah" => $jumlah_tanggungan ?? 0);
        $data[] = $result;

        $item['tabung'] = $data;

        return response()->json([
            'tabung'=> $data
        ], 200);
    }

}
