<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaWangIhsan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_mangsa', 'id_agensi_bantuan', 'tarikh_serahan', 'jumlah', 'jumlah_dipulangkan', 'tarikh_dipulangkan',
        'id_sumber_dana', 'status_mangsa_wang_ihsan', 'sebab_hapus', 'id_pengguna_cipta', 'id_dipulangkan',
        'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_jenis_bwi', 'id_negeri', 'id_daerah'
    ];

    protected $table = 'tbl_mangsa_wang_ihsan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
