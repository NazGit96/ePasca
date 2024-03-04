<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefTapakRumah extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_tapak_rumah', 'status_tapak_rumah', 
    ];

    protected $table = 'ref_tapak_rumah';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
