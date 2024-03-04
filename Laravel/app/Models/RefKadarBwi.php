<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKadarBwi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nilai', 'status_bencana_bwi', 'tarikh_cipta', 'id_pengguna_cipta',
    ];

    protected $table = 'ref_kadar_bwi';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
