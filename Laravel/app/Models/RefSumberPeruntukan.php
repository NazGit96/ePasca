<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSumberPeruntukan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_sumber_peruntukan', 'status_sumber_peruntukan', 
    ];

    protected $table = 'ref_sumber_peruntukan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
