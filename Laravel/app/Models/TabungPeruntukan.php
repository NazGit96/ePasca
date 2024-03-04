<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungPeruntukan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tabung', 'nama_peruntukan', 'tarikh_peruntukan', 'no_rujukan',
        'id_sumber_peruntukan', 'id_jenis_peruntukan', 'sumber_peruntukan_lain', 'jumlah', 'catatan', 'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini'
    ];

    protected $table = 'tbl_tabung_peruntukan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
