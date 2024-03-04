<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisPeruntukan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jenis_peruntukan', 
    ];

    protected $table = 'ref_jenis_peruntukan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
