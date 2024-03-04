<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDaerah extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_negeri', 'nama_daerah', 'status_daerah', 
    ];

    protected $table = 'ref_daerah';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
