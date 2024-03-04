<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPindah extends Model
{
    use HasFactory;
    protected $fillable = [
        'pindah', 'status_pindah', 
    ];

    protected $table = 'ref_pindah';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
