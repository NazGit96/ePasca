<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaAntarabangsa extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_bencana', 'id_mangsa', 'nama_bantuan', 'negara', 'kos_bantuan', 'tarikh_bantuan', 'catatan',
        'sebab_hapus', 'status_mangsa_antarabangsa', 'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi',
        'id_pengguna_kemaskini', 'tarikh_kemaskini',
    ];

    protected $table = 'tbl_mangsa_antarabangsa';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
