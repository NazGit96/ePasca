<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRujukan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_rujukan', 'nama_dokumen', 'lokasi_dokumen', 'sambungan_fail',
        'catatan', 'status_rujukan', 'tarikh_cipta', 'id_pengguna_cipta',
        'tarikh_kemaskini', 'id_pengguna_kemaskini',
    ];

    protected $table = 'ref_rujukan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
