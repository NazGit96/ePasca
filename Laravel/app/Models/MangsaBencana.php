<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaBencana extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_mangsa', 'id_pindah', 'nama_pusat_pemindahan', 'masalah', 'status_mangsa_bencana',
        'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_agensi', 'sebab_hapus',
    ];

    protected $table = 'tbl_mangsa_bencana';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
