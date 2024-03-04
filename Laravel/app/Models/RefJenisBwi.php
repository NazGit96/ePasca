<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisBwi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jenis_bwi', 'status_jenis_bwi', 
    ];

    protected $table = 'ref_jenis_bwi';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
