<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaPertanian extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'id_jenis_pertanian', 'luas', 'luas_musnah',
        'bilangan', 'bilangan_rosak', 'anggaran_nilai_rosak', 'anggaran_nilai_bantuan', 'kos_bantuan',
        'tarikh_bantuan', 'catatan', 'status_mangsa_pertanian', 'sebab_hapus', 'id_pengguna_cipta',
        'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini',
    ];

    protected $table = 'tbl_mangsa_pertanian';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
