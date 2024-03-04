<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungKelulusan extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_rujukan_kelulusan', 'id_tabung', 'id_bencana', 'id_bantuan', 'id_komitmen', 'rujukan_surat',
        'tarikh_surat', 'tarikh_mula_kelulusan', 'tarikh_tamat_kelulusan', 'jumlah_siling', 'baki_jumlah_siling', 'status_tabung_kelulusan',
        'perihal_surat', 'rujukan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini',
        'tarikh_kemaskini', 'hapus', 'id_pengguna_hapus', 'tarikh_hapus', 'sebab_hapus', 'jumlah_dipulangkan'
    ];

    protected $table = 'tbl_tabung_kelulusan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
