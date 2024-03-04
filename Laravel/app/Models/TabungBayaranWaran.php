<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBayaranWaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_rujukan_waran', 'rujukan_surat_waran', 'tarikh_surat_waran', 'id_tabung_kelulusan', 'id_jenis_bayaran',
        'id_kategori_bayaran', 'id_bencana', 'nama_pegawai', 'id_agensi', 'perihal', 'tarikh_mula', 'tarikh_tamat',
        'jumlah_siling_peruntukan', 'jumlah_baki_peruntukan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini',
        'tarikh_kemaskini', 'hapus', 'id_pengguna_hapus', 'tarikh_hapus', 'sebab_hapus'
    ];

    protected $table = 'tbl_tabung_bayaran_waran';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
