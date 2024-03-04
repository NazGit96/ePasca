<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungKelulusanAmbilan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tabung_kelulusan', 'id_tabung', 'jenis_transaksi', 'jumlah', 'catatan', 'tarikh_cipta', 'id_pengguna_cipta', 'baki_jumlah_siling_semasa', 'baki_jumlah_siling_baharu'
    ];

    protected $table = 'tbl_tabung_kelulusan_ambilan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
