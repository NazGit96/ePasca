<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDun extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_negeri', 'id_parlimen', 'kod_dun', 'nama_dun', 'status_dun', 
    ];

    protected $table = 'ref_dun';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
