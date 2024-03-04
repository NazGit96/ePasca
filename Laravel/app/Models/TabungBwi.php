<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBwi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_jenis_bwi', 'id_bencana', 'nama_kejadian', 'tarikh_kejadian', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini',
        'id_pengguna_hapus', 'tarikh_hapus', 'sebab_hapus', 'hapus', 'no_rujukan_bwi'

    ];

    protected $table = 'tbl_tabung_bwi';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
