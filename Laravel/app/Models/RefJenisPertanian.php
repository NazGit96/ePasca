<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisPertanian extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jenis_pertanian', 'status_jenis_pertanian', 
    ];

    protected $table = 'ref_jenis_pertanian';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
