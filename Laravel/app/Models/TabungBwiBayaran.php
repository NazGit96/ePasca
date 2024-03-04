<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBwiBayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tabung_bwi', 'id_tabung_bayaran_skb', 'id_tabung_bayaran_terus',
        'tarikh_cipta', 'id_pengguna_cipta', 'hapus', 'tarikh_hapus', 'id_pengguna_hapus', 'id_kelulusan'
    ];

    protected $table = 'tbl_tabung_bwi_bayaran';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
