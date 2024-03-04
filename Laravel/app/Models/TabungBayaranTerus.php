<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBayaranTerus extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_rujukan_terus', 'id_tabung_kelulusan', 'id_jenis_bayaran', 'id_kategori_bayaran', 'id_bencana',
        'no_baucar', 'penerima', 'tarikh', 'perihal', 'jumlah',
        'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini',
        'hapus', 'id_pengguna_hapus', 'tarikh_hapus', 'sebab_hapus', 'id_negeri', 'id_agensi', 'id_kementerian'
    ];

    protected $table = 'tbl_tabung_bayaran_terus';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
