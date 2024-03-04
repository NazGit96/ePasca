<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefStatusKerosakan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_status_kerosakan', 'status', 
    ];

    protected $table = 'ref_status_kerosakan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
