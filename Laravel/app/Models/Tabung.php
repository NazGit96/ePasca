<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabung extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_tabung', 'kategori_tabung', 'tarikh_baki', 'baki_bawaan', 'tarikh_akhir_peruntukan', 'peruntukan',
        'jumlah_keseluruhan', 'jumlah_perbelanjaan_semasa', 'jumlah_baki_semasa', 'status_tabung',
        'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini',
    ];

    protected $table = 'tbl_tabung';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
