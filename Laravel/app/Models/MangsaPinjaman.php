<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaPinjaman extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_mangsa', 'catatan', 'id_sektor', 'sektor', 'jumlah_pinjaman',
        'tarikh_mula', 'tempoh_pinjaman', 'id_sumber_dana', 'id_agensi_bantuan',
        'status_mangsa_pinjaman', 'sebab_hapus', 'id_pengguna_cipta', 'tarikh_cipta',
        'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini',
    ];

    protected $table = 'tbl_mangsa_pinjaman';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
