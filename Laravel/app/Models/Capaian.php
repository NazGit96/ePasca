<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'pembeza', 'dibenarkan', 'id_peranan', 'id_pengguna', 'tarikh_cipta', 'tarikh_kemaskini'
    ];

    protected $table = 'tbl_capaian';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
