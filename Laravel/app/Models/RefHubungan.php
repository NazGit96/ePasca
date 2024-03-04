<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefHubungan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_hubungan', 'status_hubungan', 
    ];

    protected $table = 'ref_hubungan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
