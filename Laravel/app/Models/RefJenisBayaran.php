<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisBayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jenis_bayaran', 'status_jenis_bayaran', 
    ];

    protected $table = 'ref_jenis_bayaran';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
