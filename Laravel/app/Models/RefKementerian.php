<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefKementerian extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kementerian', 'kod_kementerian', 'status_kementerian', 
    ];

    protected $table = 'ref_kementerian';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
