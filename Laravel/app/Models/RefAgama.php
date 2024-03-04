<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefAgama extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_agama', 'status_agama', 
    ];

    protected $table = 'ref_agama';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
