<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaRumah extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_mangsa', 'id_jenis_bantuan', 'naik_taraf', 'id_jenis_rumah',
        'id_jenis_penempatan', 'id_status_kerosakan', 'id_pemilik', 'id_sumber_dana',
        'sumber_dana_lain', 'id_pelaksana', 'pelaksana_lain', 'kontraktor', 'no_pkk',
        'kos_anggaran', 'kos_sebenar', 'tarikh_mula', 'tarikh_siap', 'peratus_kemajuan',
        'id_status_kemajuan', 'catatan', 'geran_rumah', 'pemilik_tanah', 'id_tapak_rumah',
        'status_mangsa_rumah', 'sebab_hapus', 'id_pengguna_cipta', 'tarikh_cipta',
        'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini',
    ];

    protected $table = 'tbl_mangsa_rumah';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
