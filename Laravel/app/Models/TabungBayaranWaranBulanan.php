<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBayaranWaranBulanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tabung_bayaran_waran', 'bulan', 'tahun', 'jumlah', 'id_pengguna_cipta',
        'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_bulan'
    ];

    protected $table = 'tbl_tabung_bayaran_waran_bulanan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
