<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabungBayaranSkbStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_tabung_bayaran_skb', 'id_status_skb', 'catatan',
        'tarikh_cipta', 'id_pengguna_cipta'
    ];

    protected $table = 'tbl_tabung_bayaran_skb_status';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
