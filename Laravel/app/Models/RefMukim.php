<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefMukim extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_negeri', 'id_daerah', 'nama_mukim', 
    ];

    protected $table = 'ref_mukim';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
