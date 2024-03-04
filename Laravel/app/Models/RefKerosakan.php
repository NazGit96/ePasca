<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKerosakan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kerosakan', 'status_kerosakan', 
    ];

    protected $table = 'ref_kerosakan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
