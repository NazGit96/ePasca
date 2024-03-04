<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisBencana extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jenis_bencana', 'catatan', 'status_bencana', 'id_pengguna', 
    ];

    protected $table = 'ref_jenis_bencana';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
