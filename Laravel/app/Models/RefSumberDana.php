<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSumberDana extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_sumber_dana', 'ringkasan_sumber_dana', 'status_sumber_dana', 
    ];

    protected $table = 'ref_sumber_dana';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
