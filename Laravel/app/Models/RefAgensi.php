<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefAgensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kementerian', 'nama_agensi', 'kod_agensi', 'pemberi_bantuan', 'pemberi_pinjaman', 'pengguna_sistem', 'status_agensi', 
    ];

    protected $table = 'ref_agensi';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
