<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefBantuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_bantuan', 'status_bantuan', 
    ];

    protected $table = 'ref_bantuan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
