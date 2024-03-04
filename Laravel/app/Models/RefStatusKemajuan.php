<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefStatusKemajuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'status_kemajuan', 'status', 'kod_status_kemajuan', 
    ];

    protected $table = 'ref_status_kemajuan';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
