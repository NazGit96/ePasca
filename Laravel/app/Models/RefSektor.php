<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefSektor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_sektor', 'status_sektor', 
    ];

    protected $table = 'ref_sektor';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
