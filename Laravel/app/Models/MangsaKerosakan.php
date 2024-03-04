<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangsaKerosakan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_mangsa', 'id_mangsa_rumah', 'id_kerosakan', 'status_kerosakan', 'id_pengguna_cipta', 'tarikh_cipta',
        'id_agensi', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'sebab_hapus',
    ];

    protected $table = 'tbl_mangsa_kerosakan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
