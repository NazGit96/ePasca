<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPelaksana extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pelaksana', 'status_pelaksana', 
    ];

    protected $table = 'ref_pelaksana';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
