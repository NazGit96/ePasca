<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaAir extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_mangsa', 'nama', 'no_kp', 'id_hubungan', 'umur', 'pekerjaan', 'status_mangsa_air', 'catatan',
        'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini',
        'sebab_hapus', 'tarikh_lahir', 'id_umur'
    ];

    protected $table = 'tbl_mangsa_air';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
