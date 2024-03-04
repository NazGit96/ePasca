<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefParlimen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_negeri', 'nama_parlimen', 'kod_parlimen', 'status_parlimen', 
    ];

    protected $table = 'ref_parlimen';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
