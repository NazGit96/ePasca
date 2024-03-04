<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPemilik extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pemilik', 'status_pemilik', 
    ];

    protected $table = 'ref_pemilik';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
