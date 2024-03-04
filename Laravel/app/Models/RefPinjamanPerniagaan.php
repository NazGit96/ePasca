<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPinjamanPerniagaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_agensi_pinjaman', 'status_agensi_pinjaman', 
    ];

    protected $table = 'ref_pinjaman_perniagaan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
