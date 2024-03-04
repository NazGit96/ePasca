<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBayaranWaranStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tabung_bayaran_waran', 'id_status_waran', 'catatan',
        'tarikh_cipta', 'id_pengguna_cipta'
    ];

    protected $table = 'tbl_tabung_bayaran_waran_status';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
