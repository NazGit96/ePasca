<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaBantuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_mangsa', 'nama_bantuan', 'id_sumber_dana', 'sumber_dana_lain', 'id_agensi_bantuan',
        'kos_bantuan', 'tarikh_bantuan', 'catatan', 'status_mangsa_bantuan', 'id_pengguna_cipta',
        'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus',
    ];

    protected $table = 'tbl_mangsa_bantuan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
