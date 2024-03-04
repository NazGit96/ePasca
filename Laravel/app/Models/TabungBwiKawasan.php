<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBwiKawasan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tabung_bwi', 'id_daerah', 'id_negeri', 'jumlah_bwi', 'jumlah_kir',
        'jumlah_kembali', 'tarikh_eft', 'catatan', 'no_rujukan_akuan_kp', 'tarikh_akuan_kp',
        'no_rujukan_saluran_kpd_bkp', 'tarikh_saluran_kpd_bkp', 'no_rujukan_laporan_kpd_bkp',
        'tarikh_laporan_kpd_bkp', 'no_rujukan_makluman_majlis', 'tarikh_makluman_majlis',
        'tarikh_majlis_makluman_majlis', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini',
        'tarikh_kemaskini', 'id_pengguna_hapus', 'tarikh_hapus', 'sebab_hapus', 'due_report', 'no_rujukan_majlis_drp_apm', 'tarikh_majlis_drp_apm'
    ];

    protected $table = 'tbl_tabung_bwi_kawasan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
