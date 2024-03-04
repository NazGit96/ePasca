<?php

namespace App\Http\Controllers;

use App\Http\AppConst;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateController extends Controller
{

    public function getBencanaRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $rujukan_bencana = DB::table('ref_bencana')->where('no_rujukan_bencana', 'ILIKE', AppConst::NoRujukanBencana.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan_bencana')
            ->first();

        if($rujukan_bencana){
            $running_no = (int)substr($rujukan_bencana, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanBencana.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getKelulusanRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $rujukan_kelulusan = DB::table('tbl_tabung_kelulusan')->where('no_rujukan_kelulusan', 'ILIKE', AppConst::NoRujukanKelulusan.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan_kelulusan')
            ->first();

        if($rujukan_kelulusan){
            $running_no = (int)substr($rujukan_kelulusan, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanKelulusan.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getSKBRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $rujukan_skb = DB::table('tbl_tabung_bayaran_skb')->where('no_rujukan_skb', 'ILIKE', AppConst::NoRujukanSKB.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan_skb')
            ->first();

        if($rujukan_skb){
            $running_no = (int)substr($rujukan_skb, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanSKB.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getWaranRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $rujukan_waran = DB::table('tbl_tabung_bayaran_waran')->where('no_rujukan_waran', 'ILIKE', AppConst::NoRujukanWaran.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan_waran')
            ->first();

        if($rujukan_waran){
            $running_no = (int)substr($rujukan_waran, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanWaran.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getBayaranTerusRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $rujukan_terus = DB::table('tbl_tabung_bayaran_terus')->where('no_rujukan_terus', 'ILIKE', AppConst::NoRujukanBayaranTerus.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan_terus')
            ->first();

        if($rujukan_terus){
            $running_no = (int)substr($rujukan_terus, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanBayaranTerus.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getDanaAwalRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $dana_awal = DB::table('tbl_tabung_peruntukan')->where('no_rujukan', 'ILIKE', AppConst::NoRujukanDanaAwal.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan')
            ->first();

        if($dana_awal){
            $running_no = (int)substr($dana_awal, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanDanaAwal.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getDanaTambahanRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $dana_awal = DB::table('tbl_tabung_peruntukan')->where('no_rujukan', 'ILIKE', AppConst::NoRujukanDanaTambahan.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan')
            ->first();

        if($dana_awal){
            $running_no = (int)substr($dana_awal, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanDanaTambahan.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getBakiBawaanRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $baki_bawaan = DB::table('tbl_tabung_peruntukan')->where('no_rujukan', 'ILIKE', AppConst::NoRujukanBakiBawaan.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan')
            ->first();

        if($baki_bawaan){
            $running_no = (int)substr($baki_bawaan, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanBakiBawaan.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getBantuanWangIhsanRunningNo(){
        $mmyy = Carbon::now()->format('ym');
        $bwi = DB::table('tbl_tabung_bwi')->where('no_rujukan_bwi', 'ILIKE', AppConst::NoRujukanBantuanWangIhsan.'-'.$mmyy.'-'.'%')
            ->orderByDesc('id')
            ->pluck('no_rujukan_bwi')
            ->first();

        if($bwi){
            $running_no = (int)substr($bwi, -5) + 1;
            $new_running_no = str_pad($running_no, 5, '0', STR_PAD_LEFT);
        }else{
            $running_no = 1;
            $new_running_no = str_pad((string)$running_no, 5, '0', STR_PAD_LEFT);
        }

        return AppConst::NoRujukanBantuanWangIhsan.'-'.$mmyy.'-'.$new_running_no;
    }

    public function getRandomPassword(){
        return Str::random(10);
    }
}
