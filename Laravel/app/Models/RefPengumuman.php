<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPengumuman extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pengumuman', 'tarikh_mula', 'tarikh_tamat', 'status_pengumuman', 'catatan'
    ];

    protected $table = 'ref_pengumuman';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
