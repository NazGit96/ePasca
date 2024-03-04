<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefBencana extends Model
{
    use HasFactory;
    protected $fillable = [
        'tarikh_bencana', 'tahun_bencana', 'id_jenis_bencana', 'nama_bencana', 'catatan', 'status_bencana', 'no_rujukan_bencana'
    ];

    protected $table = 'ref_bencana';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
