<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mangsa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama', 'no_kp', 'telefon', 'alamat_1', 'alamat_2', 'id_daerah', 'id_parlimen', 'id_dun', 'id_negeri',
        'poskod', 'catatan', 'status_mangsa', 'status_verifikasi', 'gambar', 'id_pengguna_cipta', 'tarikh_cipta',
        'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus', 'id_agensi'
    ];

    protected $table = 'tbl_mangsa';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
