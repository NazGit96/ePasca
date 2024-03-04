<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKategoriBayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kategori_bayaran', 'status_kategori_bayaran', 
    ];

    protected $table = 'ref_kategori_bayaran';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
